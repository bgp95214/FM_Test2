<!DOCTYPE html>
<html lang="zh-Hant">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title>FM 例會填寫</title>
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
        @if(session('success'))
            <div class="alert alert-success" role="alert">{{ session('success') }}</div>
        @endif

        <form action="{{ isset($meeting) ? url('/writemeeting/' . $meeting->id) : url('/writemeeting') }}" method="POST" enctype="multipart/form-data">
            @csrf
            @if(isset($meeting))
                @method('PUT')
            @endif

            <div class="mb-3">
                <label for="title" class="form-label">標題 <span class="text-danger">*</span></label>
                <input type="text" class="form-control" id="title" name="title" value="{{ old('title', $meeting->title ?? '') }}" required maxlength="150">
                @error('title')
                    <div class="text-danger small mt-1">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="content" class="form-label">內容 <span class="text-danger">*</span></label>
                <textarea class="form-control" id="content" name="content" rows="6" required>{{ old('content', $meeting->content ?? '') }}</textarea>
                @error('content')
                    <div class="text-danger small mt-1">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="photo" class="form-label">上傳照片 (可選)</label>
                <input class="form-control" type="file" id="photo" name="photo" accept="image/*">
                <div class="form-text">上傳的檔案會儲存到 public/uploads/meeting</div>
                @if(isset($meeting) && $meeting->photo)
                    <div class="mt-2">
                        <small class="text-muted">目前照片：</small><br>
                        <img src="{{ asset($meeting->photo) }}" alt="例會照片" style="max-width: 150px; max-height: 100px; margin-top: 0.5rem;">
                    </div>
                @endif
                @error('photo')
                    <div class="text-danger small mt-1">{{ $message }}</div>
                @enderror
            </div>

            <div class="d-flex gap-2">
                <button type="submit" class="btn btn-primary">
                    <i class="bi bi-check-circle me-1"></i> {{ isset($meeting) ? '更新例會資料' : '送出例會資料' }}
                </button>
                @if(isset($meeting))
                    <a href="{{ url('/writemeeting') }}" class="btn btn-secondary">
                        <i class="bi bi-x-lg"></i> 取消
                    </a>
                @endif
            </div>
        </form>


        </div>
    </div>
</section>

<!-- 底部快速工具列 -->
<nav class="quick-toolbar" aria-label="快速工具列">
    <a class="floor-btn d-flex flex-column align-items-center justify-content-center gap-1 " href="{{ url('/residentmanagement') }}" >
        <i class="bi bi-house-gear-fill fs-4" aria-hidden="true"></i><span>住戶管理</span>
    </a>
    <a class="floor-btn d-flex flex-column align-items-center justify-content-center gap-1 is-active" href="{{ url('/organizationalmanagement') }}">
        <i class="bi bi-diagram-3 fs-4" aria-hidden="true"></i><span>組織管理</span>
    </a>
    <a class="floor-btn d-flex flex-column align-items-center justify-content-center gap-1" href="{{ url('/humanmanagement') }}" >
        <i class="bi bi-person-fill-gear fs-4" aria-hidden="true"></i><span>人事管理</span>
    </a>
    <a class="floor-btn d-flex flex-column align-items-center justify-content-center gap-1" href="{{ url('/vendormanagement') }}" >
        <i class="bi bi-wrench-adjustable-circle fs-4" aria-hidden="true"></i><span>廠商管理</span>
    </a>
</nav>

<!-- 右側工具鍵欄 -->
<div class="corner-dock" aria-label="右下角功能列">
    <a class="dock-btn " href="{{ url('/addpositions') }}" style="text-decoration: none;"><i class="bi bi-database-add"></i> 新增職位</a>
    <a class="dock-btn " href="{{ url('/positions') }}" style="text-decoration: none;"><i class="bi bi-database"></i> 職位清單</a>
    <a class="dock-btn" href="{{ url('/allocation') }}" style="text-decoration: none;"><i class="bi bi-database-gear"></i> 職位分配</a>
    <a class="dock-btn " href="{{ url('/organizationalmanagement') }}" style="text-decoration: none;"><i class="bi bi-diagram-3"></i> 組織架構</a>
    <a class="dock-btn is-active" href="{{ url('/writemeeting') }}" style="text-decoration: none;"><i class="bi bi-pen"></i> 例會填寫</a>
    <a class="dock-btn " href="{{ url('/meeting') }}" style="text-decoration: none;"><i class="bi bi-pass"></i> 例會紀錄</a>
    <a class="dock-btn" href="{{ url('/writeconference') }}" style="text-decoration: none;"><i class="bi bi-pen-fill"></i> 大會填寫</a>
    <a class="dock-btn " href="{{ url('/conference') }}" style="text-decoration: none;"><i class="bi bi-pass-fill"></i> 大會紀錄</a>
    <a class="dock-btn " href="{{ url('/meetingschedule') }}" style="text-decoration: none;"><i class="bi bi-calendar-plus-fill"></i> 日程安排</a>
</div>

<script src="{{ asset('js/bootstrap.bundle.min.js') }}"></script>
<script src="{{ asset('js/sweetalert2@11.js') }}"></script>


</body>
</html>
