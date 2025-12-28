<!DOCTYPE html>
<html lang="zh-Hant">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title>FM 公告管理</title>
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
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h5 class="mb-0"><i class="bi bi-megaphone me-2"></i>公告列表</h5>
                
            </div>

            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <i class="bi bi-check-circle me-2"></i>{{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            <div class="table-responsive">
                <table class="table table-hover align-middle">
                    <thead class="table-light">
                        <tr>
                            <th width="15%">發布時間</th>
                            <th width="40%">標題</th>
                            <th width="25%">附件</th>
                            <th width="20%">操作</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($announcements as $announcement)
                            <tr>
                                <td class="text-muted small">
                                    {{ $announcement->created_at->format('Y/m/d H:i') }}
                                </td>
                                <td>
                                    <strong>{{ $announcement->title }}</strong>
                                </td>
                                <td>
                                    @if($announcement->attachment)
                                        <i class="bi bi-paperclip me-1"></i>
                                        <a href="{{ asset($announcement->attachment) }}" target="_blank" class="text-decoration-none">
                                            {{ basename($announcement->attachment) }}
                                        </a>
                                    @else
                                        <span class="text-muted">無附件</span>
                                    @endif
                                </td>
                                <td>
                                    <div class="d-flex gap-4" role="group">
                                        
                                        <button type="button" class="btn btn-outline-info btn-sm" data-bs-toggle="modal" data-bs-target="#announcementModal" 
                                                data-title="{{ $announcement->title }}" 
                                                data-content="{{ $announcement->content }}" 
                                                data-time="{{ $announcement->created_at->format('Y/m/d H:i') }}"
                                                data-attachment="{{ $announcement->attachment }}">
                                            <i class="bi bi-eye"></i>
                                        </button>

                                        <a href="{{ route('announcement.edit', $announcement->id) }}" class="btn btn-outline-warning btn-sm">
                                            <i class="bi bi-pencil"></i>
                                        </a>

                                        <form action="{{ route('announcement.destroy', $announcement->id) }}" method="POST" class="d-inline" onsubmit="return confirm('確定要刪除此公告嗎？');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-outline-danger btn-sm">
                                                <i class="bi bi-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="text-center text-muted py-4">
                                    <i class="bi bi-inbox fs-1 d-block mb-2"></i>
                                    目前沒有任何公告
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="small text-muted mt-2">
                共 {{ $announcements->count() }} 則公告
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
    <a class="dock-btn" href="{{ url('/announcement') }}" style="text-decoration: none;"><i class="bi bi-stars"></i> 新增公告</a>
</div>

<script src="{{ asset('js/bootstrap.bundle.min.js') }}"></script>
<script src="{{ asset('js/sweetalert2@11.js') }}"></script>

<!-- 公告詳情 Modal -->
<div class="modal fade" id="announcementModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-light">
                <h5 class="modal-title" id="modalTitle"></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div class="mb-2">
                    <small class="text-muted"><i class="bi bi-calendar me-1"></i><span id="modalTime"></span></small>
                </div>
                <div id="modalContent" style="line-height: 1.8; white-space: pre-wrap; word-break: break-word;"></div>
                <div id="modalAttachment" class="mt-3 pt-3 border-top d-none">
                    <strong><i class="bi bi-paperclip me-1"></i>附件</strong><br>
                    <a id="attachmentLink" href="#" target="_blank" class="text-decoration-none"></a>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">關閉</button>
            </div>
        </div>
    </div>
</div>

<script>
// Modal 資料填充
const announcementModal = document.getElementById('announcementModal');
announcementModal.addEventListener('show.bs.modal', function (event) {
    const button = event.relatedTarget;
    const title = button.getAttribute('data-title');
    const content = button.getAttribute('data-content');
    const time = button.getAttribute('data-time');
    const attachment = button.getAttribute('data-attachment');
    
    document.getElementById('modalTitle').textContent = title;
    document.getElementById('modalContent').textContent = content;
    document.getElementById('modalTime').textContent = time;
    
    if (attachment) {
        document.getElementById('modalAttachment').classList.remove('d-none');
        const attachmentLink = document.getElementById('attachmentLink');
        const filename = attachment.split('/').pop();
        attachmentLink.href = window.location.origin + '/' + attachment;
        attachmentLink.textContent = filename;
    } else {
        document.getElementById('modalAttachment').classList.add('d-none');
    }
});
</script>

</body>
</html>
