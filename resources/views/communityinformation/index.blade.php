<!DOCTYPE html>
<html lang="zh-Hant">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title>FM 社區資訊</title>

    <link rel="icon" type="image/png" href="{{ asset('img/icon.png') }}">
    <link rel="stylesheet" href="{{ asset('css/bootstrap-icons-1.11.3/font/bootstrap-icons.css') }}">
    <link rel="stylesheet" href="{{ asset('css/bootstrap.min.css') }}">

    <style>
        :root{ --brand:#F58439; --ink:#0f172a; --muted:#64748b; }
        html,body{height:100%;}
        body{
            background: radial-gradient(1200px 600px at 20% -10%, #eaf2ff 0%, transparent 60%),
            radial-gradient(1000px 500px at 120% 120%, #eef6ff 0%, transparent 60%), #f3f4f6;
            color:var(--ink);
        }
        .hero-wrap{  display:flex;  justify-content:center; padding:80px 16px; }
        .hero-card{ max-width: 1040px; border:1px solid rgba(15,23,42,.06); border-radius:16px; box-shadow:0 12px 32px rgba(2,6,23,.12); background:#fff; overflow:hidden; }
        .hero-img{ width:100%; height:100%; object-fit:cover; object-position:center; min-height:360px; }
        .brand-mark{  display:inline-flex; align-items:center; justify-content:center; ; margin-bottom:.75rem; }
        .hero-title{ font-weight:800; letter-spacing:.2px; }
        .hero-text{ color:var(--muted); }

        /* 入口按鈕網格 */
        .link-grid{
            display:grid;
            grid-template-columns: repeat(2, minmax(0,1fr));
            gap: 12px;
            margin-top: 16px;
        }
        @media (min-width: 576px){ .link-grid{ grid-template-columns: repeat(3, minmax(0,1fr)); } }
        @media (min-width: 992px){ .link-grid{ grid-template-columns: repeat(3, minmax(0,1fr)); } }

        .link-tile{
            position:relative;
            display:flex; align-items:flex-start; gap:10px;
            padding:14px 3px 14px 14px;
            border:1px solid rgba(15,23,42,.08);
            background:#fff;
            border-radius:12px;
            text-decoration:none;
            color:inherit;
            box-shadow:0 4px 14px rgba(2,6,23,.06);
            transition: transform .12s ease, box-shadow .12s ease, border-color .12s ease;
        }
        .link-tile:focus-visible{ outline: none; border-color: var(--brand); box-shadow: 0 0 0 3px rgba(37,99,235,.25); }
        .link-tile:hover{ transform: translateY(-2px); box-shadow: 0 10px 22px rgba(2,6,23,.12); }
        .link-tile:hover .tile-icon{ transform: scale(1.06); }
        .link-tile.is-primary{ border-color: rgba(37,99,235,.4); box-shadow: 0 0 0 3px rgba(37,99,235,.14), 0 8px 18px rgba(37,99,235,.12); }
        .tile-icon{
            flex:0 0 36px; height:36px; width:36px; border-radius:10px;
            display:inline-flex; align-items:center; justify-content:center;
            background: rgba(37,99,235,.10); color: var(--brand);
            transition: transform .12s ease;
        }
        .tile-title{ font-weight:700; line-height:1.1; }
        .tile-desc{ font-size:.85rem; color:var(--muted); margin-top:2px; }

        @media (max-width: 992px){
            .hero-body{ padding: 1.5rem !important; }
            .hero-img{ min-height: 220px; }
        }
        /* 右下角設定按鈕 */
        .fab-settings{
            position: fixed;
            right: 24%;
            bottom: 10%;
            z-index: 1500;
            width: 56px; height: 56px;
            border-radius: 14px;
            display:flex; align-items:center; justify-content:center;
            background: rgba(255,255,255,.95);
            border: 1px solid rgba(15,23,42,.08);
            box-shadow: 0 12px 28px rgba(2,6,23,.18);
            backdrop-filter: blur(6px);
            color:#2563eb;
            transition: transform .12s ease, box-shadow .12s ease, border-color .12s ease;
        }
        .fab-settings:hover{
            transform: translateY(-2px);
            box-shadow: 0 16px 32px rgba(2,6,23,.22);
            border-color: rgba(37,99,235,.35);
        }
        .fab-settings:active{ transform: translateY(0); }
        .fab-settings i{ font-size: 1.35rem; }
        @media (max-width: 576px){
            .fab-settings{ right: 16px; bottom: 16px; width: 52px; height: 52px; }
        }

        /* 標題區塊背景 */
        .hero-header-section{
            background-image: linear-gradient(rgba(0, 0, 0, 0.5), rgba(0, 0, 0, 0.5)), url('{{ asset('img/aa.jpg') }}');
            background-size: cover;
            background-position: top center;
            background-repeat: no-repeat;
            padding: 24px;
            border-radius: 12px;
            border: 1px solid rgba(37,99,235,.12);
            margin-bottom: 24px;
        }

    </style>
</head>
<body>
<nav class="navbar navbar-light bg-transparent px-3 px-md-4 py-3">
    <div class="d-flex align-items-center gap-2">
        <a href="{{ url('entrance') }}" class="d-flex align-items-center gap-2 text-decoration-none"
           aria-label="返回首頁" title="返回首頁">
            <img src="{{ asset('img/logo.png') }}" alt="Logo" height="40" class="me-2">
            <h6 class="pt-2 mb-0" style="color: #F58439">FM SYSTEM</h6>
        </a>
    </div>
</nav>

<main class="hero-wrap">
    <div class="hero-card w-100">
        <div class="row g-0">
            <!-- 左圖 -->
            

            <!-- 右內容：標題＋描述＋入口網格 -->
            <div class="col-lg-12">
                <div class="hero-body p-4 p-lg-5">

                    <div class="hero-header-section">
                        <h1 class="hero-title h2 h1-lg mb-2 text-white"><i class="bi bi-buildings fs-3" style="color: #F58439"></i>社區資訊</h1>
                        <p class="hero-text mb-0 text-white">
                            快速進入社區各事務訊息平台，掌握最新動態與資訊。
                        </p>
                    </div>

                    <!-- 多入口按鈕：把 href 換成你的路由 is-primary-->
                    <div class="link-grid">
                        <a class="link-tile "
                           href="{{ url('/dailyschedule') }}"
                           target="_blank"
                           rel="noopener noreferrer">
                            <span class="tile-icon"><i class="bi bi-calendar-week"></i></span>
                            <span>
                                <div class="tile-title">日常日程</div>
                                <div class="tile-desc">維修、活動、例會日程表</div>
                            </span>
                        </a>
                        <a class="link-tile "
                           href="{{ url('/repairlist') }}"
                           target="_blank"
                           rel="noopener noreferrer">
                            <span class="tile-icon"><i class="bi bi-tools"></i></span>
                            <span>
                                <div class="tile-title">維修清單</div>
                                <div class="tile-desc">待維修列表、例行檢查列表</div>
                            </span>
                        </a>
                        <a class="link-tile "
                           href="{{ url('/residentdata') }}"
                           target="_blank"
                           rel="noopener noreferrer">
                            <span class="tile-icon"><i class="bi bi-person-vcard"></i></span>
                            <span>
                                <div class="tile-title">住戶資料</div>
                                <div class="tile-desc">住戶基本資料、聯絡資訊</div>
                            </span>
                        </a>

                        <a class="link-tile "
                           href="{{ url('/assetinformation') }}"
                           target="_blank"
                           rel="noopener noreferrer">
                            <span class="tile-icon"><i class="bi bi-building-fill"></i></span>
                            <span>
                                <div class="tile-title">資產資料</div>
                                <div class="tile-desc">開關、溫度、濕度、抽風</div>
                            </span>
                        </a>

                        <a class="link-tile "
                           href="{{ url('/publicreservation') }}"
                           target="_blank"
                           rel="noopener noreferrer">
                            <span class="tile-icon"><i class="bi bi-window-desktop"></i></span>
                            <span>
                                <div class="tile-title">公設預約</div>
                                <div class="tile-desc">電梯、監測、立體圖、情境</div>
                            </span>
                        </a>

                        <a class="link-tile "
                           href="{{ url('/carreservation') }}"
                           target="_blank"
                           rel="noopener noreferrer">
                            <span class="tile-icon"><i class="bi bi-car-front-fill"></i></span>
                            <span>
                                <div class="tile-title">公務車預約表</div>
                                <div class="tile-desc">順時流量、水壓、水溫、用水量</div>
                            </span>
                        </a>

                        <a class="link-tile "
                           href="{{ url('/announcement') }}"
                           target="_blank"
                           rel="noopener noreferrer">
                            <span class="tile-icon"><i class="bi bi-window-fullscreen"></i></span>
                            <span>
                                <div class="tile-title">公告</div>
                                <div class="tile-desc">門鎖、群開、門禁、感應</div>
                            </span>
                        </a>
                    </div>

                    <!-- 小字說明 -->
                    <div class="text-muted small mt-3">
                        提示：點擊開啟全新視窗
                    </div>
                    
                </div>
            </div>
        </div>
    </div>

</main>

<footer class="text-center text-secondary small pb-4">
    © 2025 方舟人科技. 保留所有權利.
</footer>


</body>
</html>
