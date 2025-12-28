<!DOCTYPE html>
<html lang="zh-Hant" data-theme="light">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>方舟人科技 · FM SYSTEM</title>
    <link rel="icon" type="image/png" href="{{ asset('img/icon.png') }}">
    <link rel="stylesheet" href="{{ asset('css/bootstrap-icons-1.11.3/font/bootstrap-icons.css') }}">
    <link rel="stylesheet" href="{{ asset('css/bootstrap.min.css') }}">
    <style>
        :root{
            --clr-primary:#F58439;
            --clr-primary-2:#22A6F2;
            --clr-bg:#0B1220;
            --clr-card:#111827;
            --glass-bg:rgba(17,24,39,.55);
            --glass-w:#ffffff0d;
            --text:#E5E7EB;
            --muted:#9CA3AF;
            --shadow-1:0 10px 30px rgba(0,0,0,.25);
            --radius:16px;
        }
        a{
            color:#F58439;
        }
        html[data-theme="light"]{
            --clr-bg:#f7fafc;
            --clr-card:#ffffff;
            --glass-bg:rgba(255,255,255,.7);
            --glass-w:#ffffffbd;
            --text:#0f172a;
            --muted:#64748b;
        }
        body{background:linear-gradient(180deg, var(--clr-bg) 0%, #0c1a2b 120%); color:var(--text);}
        .glass{background:var(--glass-bg); backdrop-filter:blur(10px); -webkit-backdrop-filter:blur(10px); border:1px solid rgba(255,255,255,.08); box-shadow:var(--shadow-1); border-radius:var(--radius);}
        .brand{font-weight:800; letter-spacing:.5px;}
        .brand i{color:var(--clr-primary);}
        .btn-primary{--bs-btn-bg:var(--clr-primary); --bs-btn-border-color:var(--clr-primary); --bs-btn-hover-bg:var(--clr-primary-2); --bs-btn-hover-border-color:var(--clr-primary-2);}
        .nav-link{color:var(--muted);} .nav-link.active{color:var(--clr-primary);}
        .hero{position:relative; min-height:46vh; border-radius:24px; overflow:hidden;}
        .hero::before{content:""; position:absolute; inset:0; background:url({{ asset('img/ff.png') }}) bottom/cover no-repeat;}
        .hero::after{content:""; position:absolute; inset:0; }
        .hero-inner{position:relative; z-index:2;}
        .card-x{background:var(--clr-card); border:1px solid rgba(255,255,255,.07); border-radius:18px; box-shadow:var(--shadow-1);}
        .card-x:hover{transform:translateY(-2px); transition:all .2s ease;}
        .kpi{font-size:28px; font-weight:700;}

        @media (max-width: 991px){ .hero{min-height:52vh;} }
    </style>
</head>
<body>
<header class="container py-3">
    <div class="d-flex align-items-center justify-content-between">
        <div class="d-flex align-items-center gap-2">
            <img src="{{ asset('img/logo.png') }}" alt="Logo" height="40" class="me-2">
            <h6 class="pt-2 mb-0" style="color: #F58439">FM SYSTEM</h6>
        </div>
        <div class="d-none d-md-flex align-items-center gap-3">
            <a class="nav-link" href="#" data-section="news">公告</a>
            <a class="nav-link" href="#" data-section="projects">表單</a>
            <a class="nav-link" href="#" data-section="facility">規章</a>
            <a class="nav-link" href="#" data-section="reports">報表</a>
            <span class="text-muted small" id="clock">03:40</span>
            <a href="#" class="btn btn-primary btn-sm"><i class="bi bi-box-arrow-in-right me-1"></i>登入</a>
        </div>
    </div>
</header>

<main class="container pb-5">
    <!-- Hero / Floor plan preview -->
    <section class="hero mb-4 glass">
        <div class="hero-inner p-4 p-md-5">
            <div class="row g-3 align-items-end">
                <div class="col-lg-7">
                    <h1 class="display-6 fw-bold text-white" style="text-shadow: 2px 2px 8px rgba(0, 0, 0, 0.7);">智慧大樓入口</h1>
                    
                </div>
            </div>
        </div>
    </section>

    <!-- Quick Modules -->
    <section class="mb-4">
        <div class="row g-3">
            <!-- Module Cards -->
            <div class="col-6 col-lg-2">
                <a href="{{ url('/communityinformation') }}" class="text-decoration-none">
                    <div class="card-x p-3 h-100">
                        <div class="d-flex align-items-center justify-content-between">
                            <div class="fs-4 fw-bold">社區資訊</div>
                            <i class="bi bi-buildings fs-3" style="color:var(--clr-primary);"></i>
                        </div>
                        <div class="mt-2 text-secondary small">
                            <i class="bi bi-caret-right"></i>社區行事曆<br>
                            <i class="bi bi-caret-right"></i>住戶資訊<br>
                            <i class="bi bi-caret-right"></i>維修清單<br>
                            <i class="bi bi-caret-right"></i>預約資訊
                        </div>
                    </div>
                </a>
            </div>
            <div class="col-6 col-lg-2">
                <a href="{{ url('/personnelmanagement') }}" class="text-decoration-none">
                    <div class="card-x p-3 h-100">
                        <div class="d-flex align-items-center justify-content-between">
                            <div class="fs-4 fw-bold">人員管理</div>
                            <i class="bi bi-person-lines-fill fs-3" style="color:var(--clr-primary);"></i>
                        </div>
                        <div class="mt-2 text-secondary small">
                            <i class="bi bi-caret-right"></i>住戶資訊建置<br>
                            <i class="bi bi-caret-right"></i>架構及成員管理<br>
                            <i class="bi bi-caret-right"></i>社區服務人員管理<br>
                            <i class="bi bi-caret-right"></i>社區外包廠商管理
                        </div>
                    </div>
                </a>
            </div>
            <div class="col-6 col-lg-2">
                <a href="{{ url('/transactionmanagement') }}" class="text-decoration-none">
                    <div class="card-x p-3 h-100">
                        <div class="d-flex align-items-center justify-content-between">
                            <div class="fs-4 fw-bold">事務管理</div>
                            <i class="bi bi-clipboard2 fs-3" style="color:var(--clr-primary);"></i>
                        </div>
                        <div class="mt-2 text-secondary small">
                            <i class="bi bi-caret-right"></i>包裹管理<br>
                            <i class="bi bi-caret-right"></i>公設預約及管理<br>
                            <i class="bi bi-caret-right"></i>報修表單簽核<br>
                            <i class="bi bi-caret-right"></i>公告事項管理
                        </div>
                    </div>
                </a>
            </div>

            <div class="col-6 col-lg-2">
                <a href="https://arkmanstudio.com/BA_Test/public/entrance" target="_blank" class="text-decoration-none">
                    <div class="card-x p-3 h-100">
                        <div class="d-flex align-items-center justify-content-between">
                            <div class="fs-4 fw-bold">BA管理系統</div>
                            <i class="bi bi-house-gear fs-3" style="color:var(--clr-primary);"></i>
                        </div>
                        <div class="mt-2 text-secondary small">
                            <i class="bi bi-caret-right"></i>裝置控制開關<br>
                            <i class="bi bi-caret-right"></i>警報偵測感應<br>
                            <i class="bi bi-caret-right"></i>效率用量管控
                        </div>
                    </div>
                </a>
            </div>
            <div class="col-6 col-lg-4">
                <div class="card-x p-3 h-100 ">
                    <div class="fw-bold mb-2">公告消息 / 大樓事件</div>
                    <ul class="list-group list-group-flush" id="newsList" >
                        @forelse($announcements as $announcement)
                            <li class="list-group-item bg-transparent " style="color: #052c65">
                                [{{ $announcement->created_at->format('Y/m/d') }}] {{ Str::limit($announcement->title, 25) }}
                            </li>
                        @empty
                            <li class="list-group-item bg-transparent text-muted" style="color: #999">\u76ee前沒有公告</li>
                        @endforelse
                    </ul>
                </div>
            </div>
            <div class="col-6 col-lg-2">
                <a href="{{ url('/assetmanagement') }}" class="text-decoration-none">
                    <div class="card-x p-3 h-100">
                        <div class="d-flex align-items-center justify-content-between">
                            <div class="fs-4 fw-bold">資產管理</div>
                            <i class="bi bi-list-ul fs-3" style="color:var(--clr-primary);"></i>
                        </div>
                        <div class="mt-2 text-secondary small">
                            <i class="bi bi-caret-right"></i>社區資產整合<br>
                            <i class="bi bi-caret-right"></i>公務車管理<br>
                        </div>
                    </div>
                </a>
            </div>
            <div class="col-6 col-lg-2">
                <a href="{{ url('/standardizedmanagement') }}" class="text-decoration-none">
                    <div class="card-x p-3 h-100">
                        <div class="d-flex align-items-center justify-content-between">
                            <div class="fs-4 fw-bold">規範管理</div>
                            <i class="bi bi-journal-bookmark-fill fs-3" style="color:var(--clr-primary);"></i>
                        </div>
                        <div class="mt-2 text-secondary small">
                            <i class="bi bi-caret-right"></i>維護計畫書<br>
                            <i class="bi bi-caret-right"></i>社區報表建置<br>
                            <i class="bi bi-caret-right"></i>社區表單建置
                        </div>
                    </div>
                </a>
            </div>
            <div class="col-6 col-lg-2">
                <a href="{{ url('/financialmanagement') }}" class="text-decoration-none">
                    <div class="card-x p-3 h-100">
                        <div class="d-flex align-items-center justify-content-between">
                            <div class="fs-4 fw-bold">財務管理</div>
                            <i class="bi bi-cash-stack fs-3" style="color:var(--clr-primary);"></i>
                        </div>
                        <div class="mt-2 text-secondary small">
                            <i class="bi bi-caret-right"></i>日常收費管理<br>
                            <i class="bi bi-caret-right"></i>日常應付管理<br>
                            <i class="bi bi-caret-right"></i>列印表單功能
                        </div>
                    </div>
                </a>
            </div>

            <div class="col-6 col-lg-6">

                    <div class="card-x p-3">
                        <div class="d-flex align-items-center justify-content-between mb-2">
                            <div class="fw-bold">今日天氣</div>
                        </div>
                        <div class="row g-3">
                            <div class="col-6 col-md-3">
                                <div class="glass p-3 rounded-4">
                                    <div class="text-secondary small">地點</div>
                                    <div class="kpi" id="weatherLocation" style="color: #052c65">高雄市</div>
                                </div>
                            </div>
                            <div class="col-6 col-md-3">
                                <div class="glass p-3 rounded-4">
                                    <div class="text-secondary small">天氣</div>
                                    <div class="kpi" id="weatherDesc" style="color: #052c65">-</div>
                                </div>
                            </div>
                            <div class="col-6 col-md-3">
                                <div class="glass p-3 rounded-4">
                                    <div class="text-secondary small">濕度</div>
                                    <div class="kpi" id="weatherHumidity" style="color: #052c65">-</div>
                                </div>
                            </div>
                            <div class="col-6 col-md-3">
                                <div class="glass p-3 rounded-4">
                                    <div class="text-secondary small">溫度</div>
                                    <div class="kpi" id="weatherTemp" style="color: #052c65">-</div>
                                </div>
                            </div>
                        </div>
                    </div>

            </div>

        </div>
    </section>
</main>

<footer class="container  text-center small text-secondary">
    © <span id="year"></span> 2025 方舟人科技. 保留所有權利.
</footer>

<script>
    // 實時更新時鐘和日期
    function updateClock() {
        const now = new Date();
        const year = now.getFullYear();
        const month = String(now.getMonth() + 1).padStart(2, '0');
        const date = String(now.getDate()).padStart(2, '0');
        const hours = String(now.getHours()).padStart(2, '0');
        const minutes = String(now.getMinutes()).padStart(2, '0');
        
        const weekdays = ['星期日', '星期一', '星期二', '星期三', '星期四', '星期五', '星期六'];
        const dayOfWeek = weekdays[now.getDay()];
        
        document.getElementById('clock').textContent = `${year}/${month}/${date} ${dayOfWeek} ${hours}:${minutes}`;
    }
    updateClock();
    setInterval(updateClock, 1000);

    // 獲取天氣信息
    function getWeather() {
        // 使用免費天氣API - OpenWeatherMap (需要API KEY)
        // 或者使用另一個方案：Open-Meteo API (免費無需KEY)
        const latitude = 22.6163;  // 高雄市
        const longitude = 120.3105;

        fetch(`https://api.open-meteo.com/v1/forecast?latitude=${latitude}&longitude=${longitude}&current=temperature_2m,relative_humidity_2m,weather_code&timezone=Asia/Taipei`)
            .then(response => response.json())
            .then(data => {
                const current = data.current;
                const temp = Math.round(current.temperature_2m);
                const humidity = current.relative_humidity_2m;
                const weatherCode = current.weather_code;
                
                // 天氣碼對應
                let weatherDesc = '晴天';
                if (weatherCode === 0 || weatherCode === 1) weatherDesc = '晴天';
                else if (weatherCode === 2 || weatherCode === 3) weatherDesc = '多雲';
                else if (weatherCode >= 45 && weatherCode <= 48) weatherDesc = '霧';
                else if (weatherCode >= 51 && weatherCode <= 67) weatherDesc = '小雨';
                else if (weatherCode >= 71 && weatherCode <= 85) weatherDesc = '下雪';
                else if (weatherCode === 80 || weatherCode === 81 || weatherCode === 82) weatherDesc = '大雨';
                else if (weatherCode >= 80 && weatherCode <= 82) weatherDesc = '雨';
                else if (weatherCode >= 85 && weatherCode <= 86) weatherDesc = '大雪';
                else if (weatherCode >= 95 && weatherCode <= 99) weatherDesc = '雷雨';

                document.getElementById('weatherTemp').textContent = `${temp}°C`;
                document.getElementById('weatherHumidity').textContent = `${humidity}%`;
                document.getElementById('weatherDesc').textContent = weatherDesc;
            })
            .catch(error => {
                console.log('天氣獲取失敗:', error);
                // 如果失敗保持預設值
            });
    }
    getWeather();
    setInterval(getWeather, 600000); // 每10分鐘更新一次
</script>

</body>
</html>
