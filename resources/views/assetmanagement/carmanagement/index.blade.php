<!DOCTYPE html>
<html lang="zh-Hant">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title>FM 公務車管理</title>
    <link rel="icon" type="image/png" href="{{ asset('img/icon.png') }}">
    <link rel="stylesheet" href="{{ asset('css/bootstrap-icons-1.11.3/font/bootstrap-icons.css') }}">
    <link rel="stylesheet" href="{{ asset('css/bootstrap.min.css') }}">
    <style>
        :root{
            --clr-primary:#48C0FF;
            --clr-ink:#1a1d20;
            --glass-bg: rgba(255,255,255,.5);
            --glass-bg-strong: rgba(255,255,255,.95);
            --glass-border: 1px solid rgba(0,0,0,.06);
            --shadow-1: 0 8px 24px rgba(0,0,0,.12);
            --shadow-2: 0 8px 24px rgba(0,0,0,.5);
            --rail-x: 1.5rem;
            --rail-top: 5.5rem;
            --dock-width: 112px;
            --sheet-gap: .75rem;
            --sheet-w: 340px;
        }
        .page-bg::after{ content:""; position: fixed; inset: 0; background: rgba(15,23,42,.1); z-index: -1; }
        .ba-topbar{ padding:.75rem 1rem; border-bottom:1px solid rgba(0,0,0,.08);}
        .ba-topbar h6{ margin:0; font-weight:700; letter-spacing:.5px; }

        .ba-panel{
            position: fixed; left: 1rem; right: 11rem; top: 5.5rem; height: 79%;
            z-index: 990; background: var(--glass-bg); backdrop-filter: blur(6px);
            border-radius: 12px; box-shadow: var(--shadow-1); border: var(--glass-border);
            overflow: hidden; display:flex; flex-direction:column; transition: right .2s ease;
        }
        .ba-panel .card-header{ flex: 0 0 auto; }
        .fw-semibold{ margin-left:25px; margin-right:18px; margin-top:10px; }
        .panel-body{ flex: 1 1 auto; overflow:auto; -webkit-overflow-scrolling:touch; padding:.75rem 1rem; padding-bottom:5rem; }
        .panel-body::-webkit-scrollbar{ width:0; height:0; }
        .panel-body{ scrollbar-width:none; -ms-overflow-style:none; }
        body.dock-open .ba-panel{
            right: calc(var(--rail-x) + var(--dock-width) + var(--sheet-gap) + var(--sheet-w) + 1.25rem);
        }

        .quick-toolbar{
            position: fixed; left:46%; bottom:0; transform: translateX(-50%);
            display:flex; gap:.5rem; align-items:center; width:90%; padding:.5rem 1rem; height:10%;
            z-index:1000; background:rgba(255,255,255,.4); backdrop-filter:blur(6px);
            border-radius:10px 20px 0 0; box-shadow:var(--shadow-1); border:var(--glass-border);
        }
        .quick-toolbar .floor-btn{
            width:100px; height:70px; border-radius:10px; background:var(--glass-bg-strong); border:var(--glass-border);
            box-shadow:var(--shadow-1); display:flex; flex-direction:column; align-items:center; justify-content:center;
            font-weight:1000; color:#334155; user-select:none; text-decoration:none;
            transition: transform .15s ease, box-shadow .15s ease; margin:15px 7px;
        }
        .quick-toolbar .floor-btn:hover{ box-shadow:0 8px 20px rgba(0,0,0,.25); transform:scale(1.06); }
        .quick-toolbar .floor-btn.is-active{ outline:3px solid var(--clr-primary); color:#0ea5e9;
            box-shadow:0 0 0 6px rgba(72,192,255,.18), 0 8px 24px rgba(0,0,0,.16); }
        .quick-toolbar .floor-btn span{ font-size:.9rem; }

        .corner-dock{
            position: fixed; right: var(--rail-x); top: var(--rail-top);
            display:flex; flex-direction:column; gap:.5rem; z-index:1100;
            width:7%; padding:.5rem .3rem; height:88%; background:rgba(255,255,255,.4);
            backdrop-filter: blur(6px); border-radius:10px; box-shadow:var(--shadow-1); border: var(--glass-border);
        }
        .corner-dock .dock-btn{
            display:flex; align-items:center; gap:.35rem; height:50px; padding:0 .75rem; border-radius:10px; width:120px;
            background:var(--glass-bg-strong); border:var(--glass-border); box-shadow:var(--shadow-1);
            cursor:pointer; user-select:none; transition: transform .12s ease, box-shadow .12s ease;
            font-weight:600; color:#334155;
        }
        .corner-dock .dock-btn:hover{ transform: translateY(-1px); box-shadow: 0 8px 18px rgba(0,0,0,.18); }
        .corner-dock .dock-btn.is-active{ outline:2px solid var(--clr-primary); }

        #calendar{ min-height: 640px; }
        #ticketWrap .list-group-item { border-left:0; border-right:0; }
        #ticketWrap .meta { gap:.75rem; }
        #placeholderWrap .card { border: var(--glass-border); backdrop-filter: blur(6px); }
        .sortable{ cursor:pointer; user-select:none; }
        .sortable .sort-ind{ font-size:.8em; opacity:.6; margin-left:.25rem; }
        #assetsWrap .progress{ height:8px; }
        #residentsWrap .table td, #residentsWrap .table th,
        #facilityWrap  .table td, #facilityWrap  .table th,
        #carWrap       .table td, #carWrap       .table th{ vertical-align: middle; }
    </style>
</head>
<body class="container-fluid page-bg">

<!-- 頂部 -->
<div class="container-fluid ba-topbar d-flex justify-content-between align-items-center">
    <div class="d-flex align-items-center gap-2">
        <a href="{{ url('entrance') }}" class="d-flex align-items-center gap-2 text-decoration-none" aria-label="返回首頁" title="返回首頁">
            <img src="{{ asset('img/logo.png') }}" alt="Logo" height="40" class="me-2">
            <h6 class="pt-2 mb-0" style="color:#F58439">FM SYSTEM</h6>
        </a>
    </div>
    <div class="d-flex align-items-center">
        <span class="me-3" style="color:var(--clr-ink)">Admin</span>
        <a href="#" class="btn btn-sm btn-outline-secondary" style="color:var(--clr-ink)">登出</a>
    </div>
</div>

<!-- 中央面板 -->
<section class="ba-panel" aria-label="裝置清單">
    <div class="card-header d-flex justify-content-between align-items-center" style="background:#ECECEC">
        <div class="fw-semibold" id="panelTitle"></div>
    </div>

    <div class="panel-body">
        <div class="row mb-3">
            <div class="col">
                <h5 class="fw-semibold mb-0">公務車列表</h5>
                <small class="text-muted">車牌、品牌、購買日期與狀態</small>
            </div>
        </div>

        @if(isset($cars) && $cars->count() > 0)
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead style="background: #f8f9fa;">
                        <tr>
                            <th class="sortable">車牌</th>
                            <th class="sortable">品牌</th>
                            <th class="sortable">購買日期</th>
                            <th class="sortable">狀態</th>
                            <th class="text-end">操作</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($cars as $car)
                            <tr>
                                <td>{{ $car->license_plate }}</td>
                                <td>{{ $car->brand }}</td>
                                <td>{{ $car->purchase_date ? $car->purchase_date->format('Y-m-d') : '-' }}</td>
                                <td>
                                    @if($car->status === 'normal')
                                        <span class="badge bg-success">正常</span>
                                    @elseif($car->status === 'maintenance')
                                        <span class="badge bg-warning">維修中</span>
                                    @else
                                        <span class="badge bg-secondary">{{ $car->status }}</span>
                                    @endif
                                </td>
                                <td class="text-end">
                                    <button type="button" class="btn btn-sm btn-outline-info" data-bs-toggle="modal" data-bs-target="#maintenanceModal" data-maintenance="{{ $car->maintenance_method ?? '無保養方式' }}">
                                        <i class="bi bi-card-text"></i> 保養方式
                                    </button>
                                    <button type="button" class="btn btn-sm btn-outline-secondary" data-bs-toggle="modal" data-bs-target="#vendorModal" data-vendor-name="{{ $car->vendor->name ?? '未指定廠商' }}" data-contact="{{ $car->vendor->contact_person ?? '無聯絡人資料' }}" data-phone="{{ $car->vendor->phone ?? '無電話資料' }}" data-email="{{ $car->vendor->email ?? '無Email資料' }}" data-service="{{ $car->vendor->service_item ?? '無服務項目資料' }}">
                                        <i class="bi bi-person-lines-fill"></i> 廠商
                                    </button>
                                    <a href="{{ url('/addcar/'.$car->id.'/edit') }}" class="btn btn-sm btn-outline-primary">
                                        <i class="bi bi-pencil-square"></i> 編輯
                                    </a>
                                    <form action="{{ url('/addcar/'.$car->id) }}" method="POST" class="d-inline" onsubmit="return confirm('確定刪除這台車嗎？');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-outline-danger">
                                            <i class="bi bi-trash"></i> 刪除
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <div class="alert alert-info text-center" role="alert">
                <i class="bi bi-info-circle"></i> 目前沒有公務車資料
            </div>
        @endif

        <!-- 保養方式檢視 Modal -->
        <div class="modal fade" id="maintenanceModal" tabindex="-1" aria-labelledby="maintenanceModalLabel" aria-hidden="true" data-bs-backdrop="false">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="maintenanceModalLabel">保養方式</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body" id="maintenanceModalBody" style="white-space: pre-wrap;"></div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">關閉</button>
                    </div>
                </div>
            </div>
        </div>

        <!-- 廠商資訊 Modal -->
        <div class="modal fade" id="vendorModal" tabindex="-1" aria-labelledby="vendorModalLabel" aria-hidden="true" data-bs-backdrop="false">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="vendorModalLabel">廠商資訊</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div><strong>廠商名稱：</strong><span id="vendorModalName">未指定廠商</span></div>
                        <div class="mt-2"><strong>聯絡人：</strong><span id="vendorModalContact">無聯絡人資料</span></div>
                        <div class="mt-2"><strong>電話：</strong><span id="vendorModalPhone">無電話資料</span></div>
                        <div class="mt-2"><strong>Email：</strong><span id="vendorModalEmail">無Email資料</span></div>
                        <div class="mt-2"><strong>服務項目：</strong><span id="vendorModalService">無服務項目資料</span></div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">關閉</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- 底部快速工具列 -->
<nav class="quick-toolbar" aria-label="快速工具列">
    <a class="floor-btn d-flex flex-column align-items-center justify-content-center gap-1" href="{{ url('/communityassets') }}" >
        <i class="bi bi-clipboard2-pulse fs-4" aria-hidden="true"></i><span>社區資產</span>
    </a>
    <a class="floor-btn d-flex flex-column align-items-center justify-content-center gap-1 is-active" href="{{ url('/carmanagement') }}">
        <i class="bi bi-car-front-fill fs-4" aria-hidden="true"></i><span>公務車管理</span>
    </a>
</nav>

<!-- 右側工具鍵欄 -->
<div class="corner-dock" aria-label="右下角功能列">
    <a class="dock-btn " href="{{ url('/addcar') }}" style="text-decoration: none;"><i class="bi bi-patch-plus"></i> 新增車輛</a>
    <a class="dock-btn is-active" href="{{ url('/carmanagement') }}" style="text-decoration: none;"><i class="bi bi-car-front-fill"></i> 車輛列表</a>
</div>

<script src="{{ asset('js/bootstrap.bundle.min.js') }}"></script>
<script src="{{ asset('js/sweetalert2@11.js') }}"></script>
<script>
    const maintenanceModal = document.getElementById('maintenanceModal');
    if (maintenanceModal) {
        maintenanceModal.addEventListener('show.bs.modal', event => {
            const button = event.relatedTarget;
            const content = button?.getAttribute('data-maintenance') || '無保養方式';
            document.getElementById('maintenanceModalBody').textContent = content;
        });
    }

    const vendorModal = document.getElementById('vendorModal');
    if (vendorModal) {
        vendorModal.addEventListener('show.bs.modal', event => {
            const button = event.relatedTarget;
            const name = button?.getAttribute('data-vendor-name') || '未指定廠商';
            const contact = button?.getAttribute('data-contact') || '無聯絡人資料';
            const phone = button?.getAttribute('data-phone') || '無電話資料';
            const email = button?.getAttribute('data-email') || '無Email資料';
            const service = button?.getAttribute('data-service') || '無服務項目資料';
            document.getElementById('vendorModalName').textContent = name;
            document.getElementById('vendorModalContact').textContent = contact;
            document.getElementById('vendorModalPhone').textContent = phone;
            document.getElementById('vendorModalEmail').textContent = email;
            document.getElementById('vendorModalService').textContent = service;
        });
    }
</script>



</body>
</html>
