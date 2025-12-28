
    (function () {
    // ========== Boot / Config ==========
    const BOOT = JSON.parse(document.getElementById('ba-bootstrap')?.textContent || '{}');
    const R    = BOOT.routes   || {};
    const DEF  = BOOT.defaults || {};
    const MOD  = BOOT.modbus   || {};

    // Modbus-WS 入口與（可選）裝置代碼濾器
    const MODBUS_WS_URL   = MOD.ws || 'ws://127.0.0.1:8081';
    const DEVICE_CODE_RAW = String(MOD.device_code || '').trim(); // 若有在設定指定，僅更新該裝置

    const OFFLINE_TIMEOUT_MS_DEFAULT = Number(DEF.offline_timeout_ms ?? 15000);
    const CSRF = document.querySelector('meta[name="csrf-token"]')?.content || '';

    // ========== APIs ==========
    const API_INCIDENT = {
    index : R.incidents?.index || '',
    store : R.incidents?.store || '',
    ack   : R.incidents?.ack   || '',
    reset : R.incidents?.reset || '',
    update: (id) => (R.incidents?.update || '').replace(/\/$/, '') + '/' + id,
};
    const API_SENSORS  = {
    store  : R.sensors?.store  || '',
    index  : R.sensors?.index  || '',
    update : (id) => (R.sensors?.update  || '').replace(/\/$/, '') + '/' + id,
    destroy: (id) => (R.sensors?.destroy || '').replace(/\/$/, '') + '/' + id,
};
    const API_DEVICES  = { index: R.devices?.index || '' };
    const API_SETTINGS = { index: R.settings?.index || '' };

    // ========== Utils ==========
    const esc = s => String(s ?? '').replace(/[&<>"']/g, m => ({'&':'&amp;','<':'&lt;','>':'&gt;','"':'&quot;',"'":'&#39;'}[m]));
    async function getJSON(url){ const r=await fetch(url,{headers:{Accept:'application/json'}}); if(!r.ok) throw new Error(await r.text()); return r.json(); }
    async function postJSON(url, body={}){ const r=await fetch(url,{method:'POST',headers:{'Content-Type':'application/json','Accept':'application/json','X-CSRF-TOKEN':CSRF},body:JSON.stringify(body)}); if(!r.ok) throw new Error(await r.text()); return r.json(); }
    async function patchJSON(url, body={}){ const r=await fetch(url,{method:'PATCH',headers:{'Content-Type':'application/json','Accept':'application/json','X-CSRF-TOKEN':CSRF},body:JSON.stringify(body)}); if(!r.ok) throw new Error(await r.text()); return r.json(); }

    function hexToRgba(hex, a=1){ const h=String(hex||'#F5F7FB').replace('#',''); const r=parseInt(h.slice(0,2)||'f',16), g=parseInt(h.slice(2,4)||'f',16), b=parseInt(h.slice(4,6)||'f',16); return `rgba(${r},${g},${b},${a})`; }
    function applyViewerBg(color, opacity){ const v=document.getElementById('viewer'); if(v) v.style.backgroundColor = hexToRgba(color, opacity); }

    // ========== Settings（只留顯示/告警/系統）==========
    let __settingsCache = null;
    function normalizeSettings(raw){
    const d = raw?.display||{}, a=raw?.alert||{}, sys=raw?.system||{};
    return {
    markerSize:Number(d.markerSize??28), tipHover:!!(d.tipHover??true),
    pulseSpeed:Number(d.pulseSpeed??900), pingSpeed:Number(d.pingSpeed??1000),
    onlyAlarmDefault:!!(d.onlyAlarmDefault??false),
    floorUrl:String(d.floorUrl??''), bgColor:String(d.bgColor??'#F5F7FB'), bgOpacity:Number(d.bgOpacity??1),

    notifyDesktop:!!(a.notifyDesktop??false), repeatDialog:!!(a.repeatDialog??true),
    alarmVolume:Number(a.alarmVolume??1), workBegin:String(a.workBegin??'08:00'),
    workEnd:String(a.workEnd??'19:00'), limitWorkHours:!!(a.limitWorkHours??false),

    offlineTimeoutMs:Number(sys.offlineTimeoutMs??OFFLINE_TIMEOUT_MS_DEFAULT),
    __groups:{display:d,alert:a,system:sys}
};
}
    async function loadSettings(){ if(__settingsCache) return __settingsCache; try{ const r=await fetch(API_SETTINGS.index,{headers:{Accept:'application/json'}}); __settingsCache=normalizeSettings(r.ok?await r.json():{});}catch{ __settingsCache=normalizeSettings({}); } return __settingsCache; }

    async function bootSettings(){
    const s = await loadSettings();
    const style = document.documentElement.style;
    style.setProperty('--marker-size', (s.markerSize??28)+'px');
    style.setProperty('--pulse-speed', (s.pulseSpeed??900)+'ms');
    style.setProperty('--ping-speed',  (s.pingSpeed ??1000)+'ms');
    if (s.onlyAlarmDefault){ const btn=document.getElementById('btn-only-alarm'); if(btn && !btn.classList.contains('btn-secondary')) btn.click(); }
    if (s.floorUrl){ const floor=document.getElementById('floor'); if(floor){ const bust=u=>u+(u.includes('?')?'&':'?')+'t='+Date.now(); floor.src=bust(s.floorUrl); } }
    if (s.tipHover===false) document.body.setAttribute('data-tip-hover-off','true'); else document.body.removeAttribute('data-tip-hover-off');
    const audio = document.getElementById('alarmAudio'); if (audio) audio.volume = s.alarmVolume ?? 1;
    applyViewerBg(s.bgColor, s.bgOpacity);
    if('Notification' in window && Notification.permission==='default'){ try{ await Notification.requestPermission(); }catch{} }
}

    // ========== Global state ==========
    let lastUpdateAt = 0;
    let prevLeakMap = null;
    let snapshotReady = false;

    // 本地 ACK / Latched
    const ACK_KEY='water_alarm_acks', LATCH_KEY='water_alarm_latched';
    let ackSet   = new Set(JSON.parse(localStorage.getItem(ACK_KEY)   || '[]'));
    let alarmSet = new Set(JSON.parse(localStorage.getItem(LATCH_KEY) || '[]'));
    const saveAck   = ()=>localStorage.setItem(ACK_KEY,   JSON.stringify([...ackSet]));
    const saveAlarm = ()=>localStorage.setItem(LATCH_KEY, JSON.stringify([...alarmSet]));

    // Device code → DB id（方便只更新某裝置）
    let DEVICE_CODE_TO_DBID = new Map();
    async function refreshDeviceMap(){ try{ const list = await getJSON(API_DEVICES.index); DEVICE_CODE_TO_DBID = new Map(list.map(d=>[String(d.device_id), Number(d.id)])); }catch{} }

    // ========== UI helpers ==========
    function applyMarker(el, { leak=null, online=true }){
    if (leak===null) return;
    el.classList.toggle('leak', leak);
    el.classList.toggle('is-off', online===false);
    el.classList.toggle('is-on', !leak && online!==false);
    el.title = `${el.dataset.name}｜${leak?'浸水告警':(online===false?'離線':'正常')}`;
}
    function focusMarker(id){
    const el=document.querySelector(`.ht-marker[data-id="${id}"]`); if(!el) return;
    el.classList.add('ping'); const s=__settingsCache||{}; const dur=Math.max(300,Number(s.pingSpeed??1000));
    setTimeout(()=>el.classList.remove('ping'), (dur*2)+120);
    document.getElementById('viewer')?.scrollIntoView({behavior:'smooth',block:'center'});
}
    function setAllNormalUI(){
    document.querySelectorAll('.ht-marker').forEach(el=>{ el.classList.remove('leak','is-off'); el.classList.add('is-on'); el.title=`${el.dataset.name}｜正常`; });
    document.querySelectorAll('.status-dot').forEach(dot=>{ dot.classList.remove('leak','off'); dot.classList.add('normal'); });
    document.querySelectorAll('[id^="st-"]').forEach(st=>{ st.classList.remove('bg-secondary','bg-danger','bg-dark','bg-success'); st.classList.add('bg-success'); st.textContent='正常'; });
}

    // 右側/左側
    function refreshCountersAndEmptyState(){
    const list=document.getElementById('alarm-list'), empty=document.getElementById('alarm-empty');
    const cnt=(list&&list.children)?list.children.length:0;
    const cntEl=document.getElementById('cnt-alarm'); if(cntEl) cntEl.textContent=cnt;
    if(empty) empty.style.display = cnt ? 'none' : '';
}
    function renderAlarmList(data){
    const list=document.getElementById('alarm-list'); if(!list) return;
    const nowMap=new Map(data.map(s=>[String(s.id),s]));
    list.innerHTML=[...alarmSet].map(id=>{
    const now=nowMap.get(String(id));
    const name= now?.name || document.querySelector(`.ht-marker[data-id="${id}"]`)?.dataset.name || ('#'+id);
    const room= now?.room || document.querySelector(`.ht-marker[data-id="${id}"]`)?.dataset.room || '';
    const isLeakNow=!!now?.leak; const acked=ackSet.has(String(id));
    const clearedCls=isLeakNow?'':' alarm-cleared'; const ackCls=acked?' alarm-acked':'';
    return `<div class="alarm-row${clearedCls}${ackCls}" data-id="${id}">
        <div class="alarm-info"><span class="alarm-dot"></span>
          <div class="alarm-name"><div class="fw-semibold">${esc(name)}</div><div class="text-muted">${esc(room)}</div></div>
        </div>
        <div class="d-flex align-items-center gap-2">
          <button class="btn btn-sm btn-outline-secondary btn-focus" title="定位"><i class="bi bi-crosshair"></i></button>
        </div>
      </div>`;
}).join('');
    refreshCountersAndEmptyState();
}
    (function bindAlarmList(){
    const list=document.getElementById('alarm-list'); if(!list) return;
    list.addEventListener('click',(e)=>{ const row=e.target.closest('.alarm-row'); if(!row) return;
    if(e.target.closest('.btn-focus')) focusMarker(row.dataset.id);
});
})();
    function updateRightList(data){
    data.forEach(s=>{
    const dot=document.querySelector(`.status-dot[data-id="${s.id}"]`);
    const st =document.getElementById(`st-${s.id}`);
    if(dot){ dot.classList.remove('normal','leak','off'); dot.classList.add(s.leak?'leak':(s.online===false?'off':'normal')); }
    if(st){ st.classList.remove('bg-secondary','bg-danger','bg-success','bg-dark');
    if(s.leak){ st.textContent='告警'; st.classList.add('bg-danger'); }
    else if(s.online===false){ st.textContent='離線'; st.classList.add('bg-dark'); }
    else { st.textContent='正常'; st.classList.add('bg-success'); }
}
});
}
    function syncPanels(data){
    window.__lastWaterSnapshot = Array.isArray(data)?data:[];
    const currLeakMap = new Map(window.__lastWaterSnapshot.map(s=>[String(s.id), !!s.leak]));
    if(!prevLeakMap) prevLeakMap = new Map(currLeakMap);
    snapshotReady = true;
    renderAlarmList(data);
    updateRightList(data);
    refreshAlarm();
    prevLeakMap = new Map(currLeakMap);
}

    // ========== Sensors 初次渲染 ==========
    async function initSensorsFromDB(){
    const list = await getJSON(API_SENSORS.index);
    renderSensors(list);
}
    function renderSensors(list){
    let container=document.getElementById('markers-root');
    if(!container){ const root=document.getElementById('viewer'); container=document.createElement('div'); container.id='markers-root'; root?.appendChild(container); }
    const frag=document.createDocumentFragment();
    list.forEach(s=>{
    const m=document.createElement('button');
    m.className='ht-marker is-on'; m.setAttribute('role','button'); m.tabIndex=0;
    m.dataset.id=s.id; m.dataset.name=s.name??''; m.dataset.room=s.room??'';
    m.dataset.di=(s.di==null)?'':s.di; m.dataset.invert=s.invert?'1':'0'; m.dataset.deviceId=(s.device_id==null?'':s.device_id);
    m.style.left=(s.x??0)+'%'; m.style.top=(s.y??0)+'%';
    m.title=`${s.name??''}｜正常`;
    m.innerHTML=`<i class="bi bi-droplet"></i><span class="marker-tip">${esc(s.name??'')}｜${esc(s.room??'')}</span>`;
    m.addEventListener('click', ()=>{
    const leak=m.classList.contains('leak'); const online=!m.classList.contains('is-off');
    Swal.fire({ title:`${esc(m.dataset.name)}（${esc(m.dataset.room)}）`,
    html:`<div style="text-align:left">狀態：${leak?'<b style="color:#e11d48">⚠ 浸水告警</b>':(online?'正常':'離線')}</div>`,
    showCancelButton:true, cancelButtonText:'關閉', confirmButtonText:'我知道了', reverseButtons:true
}).then(r=>{ if(r.isConfirmed) ackOne(m.dataset.id); });
});
    frag.appendChild(m);
});
    container.innerHTML=''; container.appendChild(frag);

    const listEl=document.getElementById('dev-list');
    if(listEl){
    listEl.innerHTML = list.map(s=>`
        <a href="#" class="list-group-item list-group-item-action d-flex justify-content-between align-items-center" data-id="${s.id}">
          <div class="d-flex align-items-center gap-2">
            <span class="status-dot" data-id="${s.id}"></span>
            <div><div class="fw-semibold">${esc(s.name??'')}</div><div class="text-muted">${esc(s.room??'')}</div></div>
          </div>
          <span class="badge rounded-pill bg-secondary" id="st-${s.id}">—</span>
        </a>`).join('');
    listEl.querySelectorAll('.list-group-item').forEach(a=>a.addEventListener('click',(e)=>{ e.preventDefault(); focusMarker(a.dataset.id); }));
    const cnt=document.getElementById('cnt-all'); if(cnt) cnt.textContent=String(list.length);
}
}

    // ========== Alarm / ACK ==========
    const audio = document.getElementById('alarmAudio'); let alarming=false;
    function withinWorkingHours(){ const s=__settingsCache||{}; if(!s.limitWorkHours) return true; try{ const [bH,bM]=String(s.workBegin||'08:00').split(':').map(Number); const [eH,eM]=String(s.workEnd||'19:00').split(':').map(Number); const now=new Date(); const t=now.getHours()*60+now.getMinutes(); const b=bH*60+bM, e=eH*60+eM; return (b<=e)?(t>=b && t<=e):(t>=b || t<=e); }catch{ return true; } }
    function playAlarm(){ if(!alarming){ audio.loop=true; audio.play().catch(()=>{}); alarming=true; } }
    function stopAlarm(){ if(alarming){ audio.pause(); audio.currentTime=0; alarming=false; } }
    function refreshAlarm(){ if(!snapshotReady){ stopAlarm(); return; } const s=__settingsCache||{}; const hasUnacked=[...alarmSet].some(id=>!ackSet.has(String(id))); (hasUnacked && withinWorkingHours())?playAlarm():stopAlarm(); audio.volume=Number(s.alarmVolume??1); }
    function showAlarmNotification({id,name,room}){ const s=__settingsCache||{}; if(!s.notifyDesktop) return; if(!withinWorkingHours()) return; if(!('Notification' in window) || Notification.permission!=='granted') return; try{ const n=new Notification('⚠️ 浸水警報',{ body:`${room||''} ${name||''}\n請立即處理。`, icon:'/favicon.ico', requireInteraction:true, tag:`water-alarm-${id}`, renotify:true }); n.onclick=()=>{ window.focus(); n.close(); }; }catch{} }

    function ackOne(id){ ackSet.add(String(id)); saveAck(); document.querySelector(`#alarm-list .alarm-row[data-id="${id}"]`)?.classList.add('alarm-acked'); refreshAlarm(); patchJSON(API_INCIDENT.ack, { sensor_id:Number(id) }).catch(()=>{}); }
    function resetAcks(){ ackSet.clear(); saveAck(); alarmSet.clear(); saveAlarm(); setAllNormalUI(); const list=document.getElementById('alarm-list'); if(list) list.innerHTML=''; refreshCountersAndEmptyState(); stopAlarm(); postJSON(API_INCIDENT.reset,{}).catch(()=>{}); }
    document.getElementById('btn-reset-acks')?.addEventListener('click', resetAcks);

    // ========== Modbus-WS 核心 ==========
    function parseDi(obj, idx){
    if (typeof obj?.[`di${idx}`] !== 'undefined') return !!obj[`di${idx}`];
    const arr = Array.isArray(obj?.DI) ? obj.DI : (Array.isArray(obj?.DIn) ? obj.DIn : null);
    if (arr){ if (typeof arr[idx] !== 'undefined') return !!arr[idx]; if (typeof arr[idx-1] !== 'undefined') return !!arr[idx-1]; }
    return null;
}

    function handleAdamData(obj, onlyDeviceDbId=null){
    lastUpdateAt = Date.now();
    const data=[]; const currMapTemp=new Map();

    document.querySelectorAll('.ht-marker').forEach(el=>{
    if (onlyDeviceDbId && String(el.dataset.deviceId||'') !== String(onlyDeviceDbId)) return;
    const diAttr=el.dataset.di; const di=(diAttr===''||diAttr===undefined)?null:Number(diAttr);
    if (di===null || Number.isNaN(di)) return;
    const invert=(el.dataset.invert==='1'||el.dataset.invert==='true');
    const raw=parseDi(obj, di); if (raw===null) return;
    const leak = invert ? !raw : raw;
    currMapTemp.set(String(el.dataset.id), !!leak);
    applyMarker(el, { leak, online:true });
    data.push({ id:Number(el.dataset.id), name:el.dataset.name, room:el.dataset.room, leak, online:true });
});

    if (!prevLeakMap){
    let seeded=false; currMapTemp.forEach((leak,idStr)=>{ if(leak){ alarmSet.add(idStr); seeded=true; }});
    if (seeded) saveAlarm();
}
    const prevMap=prevLeakMap||new Map();
    currMapTemp.forEach((nowLeak,idStr)=>{
    const wasLeak=!!prevMap.get(idStr);
    if (nowLeak && !wasLeak){
    if(!alarmSet.has(idStr)){ alarmSet.add(idStr); saveAlarm(); }
    const el=document.querySelector(`.ht-marker[data-id="${idStr}"]`);
    const name=el?.dataset.name||('#'+idStr); const room=el?.dataset.room||'';
    showAlarmNotification({ id:Number(idStr), name, room });
    postJSON(API_INCIDENT.store, { sensor_id:Number(idStr), sensor_name:name, room }).catch(()=>{});
}
});

    syncPanels(data);
}

    let ws=null, wsRetry=0, wsTimer=null;
    function wsBadge(txt, cls){
    let b=document.getElementById('mqtt-badge');
    if(!b){ b=document.createElement('div'); b.id='mqtt-badge'; Object.assign(b.style,{position:'fixed',left:'12px',bottom:'92%',zIndex:1030,padding:'4px 8px',borderRadius:'8px',fontSize:'12px',boxShadow:'0 2px 10px rgba(0,0,0,.15)'}); document.body.appendChild(b); }
    b.textContent=txt;
    b.style.background=(cls==='ok')?'#e9fce9':(cls==='warn')?'#fff7e6':'#ffeaea';
    b.style.border='1px solid '+((cls==='ok')?'#16a34a':(cls==='warn')?'#f59e0b':'#ef4444');
    b.style.color=(cls==='ok')?'#14532d':(cls==='warn')?'#7c2d12':'#7f1d1d';
}
    function scheduleReconnect(){ clearTimeout(wsTimer); const delay=Math.min(10000, 1000*Math.pow(1.5, wsRetry++)); wsTimer=setTimeout(connectWS, delay); wsBadge('Modbus-WS: reconnecting…','warn'); }

    function connectWS(){
    const url = MODBUS_WS_URL;
    try{ ws = new WebSocket(url); window.modbusWS = ws; }catch(e){ console.error('WS create error', e); scheduleReconnect(); return; }

    ws.addEventListener('open', ()=>{ wsRetry=0; wsBadge('Modbus-WS: connected','ok'); });
    ws.addEventListener('close', ()=>{ wsBadge('Modbus-WS: disconnected','err'); scheduleReconnect(); });
    ws.addEventListener('error', ()=>{ wsBadge('Modbus-WS: error','err'); try{ ws.close(); }catch{} scheduleReconnect(); });

    ws.addEventListener('message', (e)=>{
    let msg; try{ msg=JSON.parse(e.data); }catch{ return; }
    // 後端定義：{ type:'di_poll', data: [bool,...], device_code?: 'ADAM-xxxx' }
    if (msg.type==='di_poll' && Array.isArray(msg.data)){
    let onlyDeviceDbId=null;
    const code = String(msg.device_code || DEVICE_CODE_RAW || '').trim();
    if (code) onlyDeviceDbId = DEVICE_CODE_TO_DBID.get(code) || null;
    handleAdamData({ DI: msg.data }, onlyDeviceDbId);
    return;
}
    if (msg.type==='di' && Array.isArray(msg.data)){
    handleAdamData({ DI: msg.data }, null); return;
}
    if (msg.type==='do_ack'){ /* 可做提示 */ }
});
}

    // 公開一個 DO 寫入（可選）
    window.writeDoViaWs = function(addr, on){
    if (!window.modbusWS || window.modbusWS.readyState!==1){ Swal.fire({icon:'error',title:'Modbus-WS 未連線'}); return; }
    window.modbusWS.send(JSON.stringify({ cmd:'writeDO', addr:Number(addr), value:!!on }));
};

    // ========== 離線判定 ==========
    function markOfflineIfStale(){
    const s=__settingsCache||{};
    if (Date.now() - lastUpdateAt < s.offlineTimeoutMs) return;
    document.querySelectorAll('.ht-marker').forEach(el=> applyMarker(el, { leak:false, online:false }));
    const enriched=[...document.querySelectorAll('.ht-marker')].map(el=>({ id:Number(el.dataset.id), name:el.dataset.name, room:el.dataset.room, leak:false, online:false }));
    syncPanels(enriched);
}
    setInterval(markOfflineIfStale, 3000);

    // ========== Boot ==========
    (async ()=>{
    await bootSettings();
    await refreshDeviceMap();
    await initSensorsFromDB();
    connectWS();
})().catch(e=>console.error('[boot] failed:', e));
})();
