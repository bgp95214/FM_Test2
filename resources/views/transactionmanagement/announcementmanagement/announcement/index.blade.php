<!DOCTYPE html>
<html lang="zh-Hant">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title>FM 新增公告</title>
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
        <div class="container-fluid">
            <div class="row justify-content-center">
                <div class="col-lg-12">
                    <div class="card shadow-sm" style="background: var(--glass-bg-strong); border: var(--glass-border);">
                        <div class="card-header bg-transparent">
                            <h5 class="mb-0">
                                <i class="bi bi-megaphone me-2"></i>
                                @if(isset($announcement))
                                    編輯公告
                                @else
                                    新增公告
                                @endif
                            </h5>
                        </div>
                        <div class="card-body">
                            <form id="announcementForm" 
                                  action="@if(isset($announcement)){{ route('announcement.update', $announcement->id) }}@else{{ route('announcement.store') }}@endif" 
                                  method="POST" enctype="multipart/form-data">
                                @csrf
                                @if(isset($announcement))
                                    @method('PUT')
                                @endif
                                
                                <!-- 公告標題 -->
                                <div class="mb-3">
                                    <label for="title" class="form-label fw-semibold">公告標題 <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" id="title" name="title" required placeholder="請輸入公告標題"
                                           value="{{ $announcement->title ?? '' }}">
                                </div>

                                <!-- 公告內容 -->
                                <div class="mb-3">
                                    <label for="content" class="form-label fw-semibold">公告內容 <span class="text-danger">*</span></label>
                                    <textarea class="form-control" id="content" name="content" rows="8" required placeholder="請輸入公告內容">{{ $announcement->content ?? '' }}</textarea>
                                </div>

                                <!-- 附件上傳 -->
                                <div class="mb-3">
                                    <label for="attachment" class="form-label fw-semibold">附件上傳</label>
                                    @if(isset($announcement) && $announcement->attachment)
                                        <div class="alert alert-info alert-sm mb-2">
                                            <i class="bi bi-info-circle me-1"></i>
                                            目前附件：<a href="{{ asset($announcement->attachment) }}" target="_blank">{{ basename($announcement->attachment) }}</a>
                                        </div>
                                    @endif
                                    <input type="file" class="form-control" id="attachment" name="attachment" accept="image/*,.pdf,.doc,.docx">
                                    <div class="form-text">支援格式：圖片、PDF、Word 文件（最大 10MB）
                                        @if(isset($announcement))
                                            <br><small>若要更換附件，請選擇新的檔案；不變更則保留原附件</small>
                                        @endif
                                    </div>
                                </div>

                                <!-- 按鈕區 -->
                                <div class="d-flex justify-content-end gap-2">
                                    <a href="{{ url('/announcementmanagement') }}" class="btn btn-secondary">
                                        <i class="bi bi-x-circle me-1"></i>取消
                                    </a>
                                    <button type="submit" class="btn btn-primary">
                                        <i class="bi bi-cloud-upload me-1"></i>
                                        @if(isset($announcement))
                                            更新公告
                                        @else
                                            發布公告
                                        @endif
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- 底部快速工具列 -->
<nav class="quick-toolbar" aria-label="快速工具列">
    <a class="floor-btn d-flex flex-column align-items-center justify-content-center gap-1 " href="{{ url('/packagemanagement') }}" >
        <i class="bi bi-box-seam fs-4" aria-hidden="true"></i><span>包裹管理</span>
    </a>
    <a class="floor-btn d-flex flex-column align-items-center justify-content-center gap-1" href="{{ url('/repairmanagement') }}">
        <i class="bi bi-screwdriver fs-4" aria-hidden="true"></i><span>報修管理</span>
    </a>
    <a class="floor-btn d-flex flex-column align-items-center justify-content-center gap-1" href="{{ url('/publicmanagement') }}" >
        <i class="bi bi-clipboard2-check fs-4" aria-hidden="true"></i><span>公設管理</span>
    </a>
    <a class="floor-btn d-flex flex-column align-items-center justify-content-center gap-1" href="{{ url('/carapproval') }}" >
        <i class="bi bi-clipboard-check fs-4" aria-hidden="true"></i><span>公務車預約</span>
    </a>
    <a class="floor-btn d-flex flex-column align-items-center justify-content-center gap-1 " href="{{ url('/maintenancemanagement') }}">
        <i class="bi bi-wrench fs-4" aria-hidden="true"></i><span>維修管理</span>
    </a>
    <a class="floor-btn d-flex flex-column align-items-center justify-content-center gap-1 is-active" href="{{ url('/announcementmanagement') }}" >
        <i class="bi bi-window-fullscreen fs-4" aria-hidden="true"></i><span>公告管理</span>
    </a>
</nav>

<!-- 右側工具鍵欄 -->
<div class="corner-dock" aria-label="右下角功能列">
    <a class="dock-btn" href="{{ url('/electronicboard') }}" style="text-decoration: none;"><i class="bi bi-collection"></i> 電子公告</a>
    @if(isset($announcement))
        <a class="dock-btn is-active" href="{{ route('announcement.edit', $announcement->id) }}" style="text-decoration: none;"><i class="bi bi-pencil-square"></i> 編輯公告</a>
    @else
        <a class="dock-btn is-active" href="{{ url('/announcement') }}" style="text-decoration: none;"><i class="bi bi-plus-circle"></i> 新增公告</a>
    @endif
</div>

<script src="{{ asset('js/bootstrap.bundle.min.js') }}"></script>
<script src="{{ asset('js/sweetalert2@11.js') }}"></script>


</body>
</html>
