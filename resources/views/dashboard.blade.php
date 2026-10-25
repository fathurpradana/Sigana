<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard | SIGANA</title>

    <link rel="stylesheet"
      href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css">

    <style>
        * { box-sizing: border-box; }

        :root {
            --teal: #105361;
            --teal-dark: #0d4652;
            --page: #f4f5f2;
            --text: #19373d;
            --muted: #788889;
            --line: #e6eae7;
        }

        body {
            min-height: 100vh;
            margin: 0;
            background: var(--page);
            color: var(--text);
            font-family: Arial, Helvetica, sans-serif;
        }

        .app {
            min-height: 100vh;
            display: grid;
            grid-template-columns: 240px minmax(0, 1fr);
        }

        /* Sidebar */
        .sidebar {
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            padding: 24px 16px 16px;
            background: var(--teal);
            color: white;
        }

        .brand {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 0 8px 26px;
        }

        .brand-icon {
            width: 38px;
            height: 38px;
            display: grid;
            place-items: center;
            border-radius: 10px;
            background: white;
            color: var(--teal);
        }

        .brand-icon svg { width: 25px; height: 25px; }

        .brand-name {
            margin: 0;
            font-size: 17px;
            letter-spacing: .03em;
        }

        .brand-caption {
            margin: 3px 0 0;
            color: #c6dfe2;
            font-size: 10px;
        }

        .nav {
            display: grid;
            gap: 7px;
        }

        .nav a {
            display: flex;
            align-items: center;
            gap: 14px;
            min-height: 42px;
            padding: 0 12px;
            border-radius: 9px;
            color: #e2eff0;
            font-size: 13px;
            text-decoration: none;
        }

        .nav a:hover,
        .nav a.active {
            background: rgba(255, 255, 255, .17);
            color: white;
        }

        .nav svg {
            width: 17px;
            height: 17px;
            flex: 0 0 auto;
        }

        .sidebar-bottom {
            margin-top: auto;
        }

        .emergency-card {
            padding: 14px;
            border-radius: 12px;
            background: rgba(255, 255, 255, .13);
        }

        .emergency-card span {
            display: block;
            margin-bottom: 5px;
            color: #d0e3e5;
            font-size: 11px;
        }

        .emergency-card strong { font-size: 20px; }

        /* Konten utama */
        .main {
            min-width: 0;
            padding: 28px clamp(20px, 4vw, 58px);
        }

        .topbar {
            position: relative;
            z-index: 1100;
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 18px;
            margin-bottom: 24px;
        }

        .welcome h1 {
            margin: 0;
            font-size: clamp(22px, 2.4vw, 30px);
        }

        .welcome p {
            margin: 6px 0 0;
            color: var(--muted);
            font-size: 13px;
        }

        .top-actions {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .search {
            width: min(270px, 32vw);
            height: 42px;
            display: flex;
            align-items: center;
            gap: 8px;
            padding: 0 13px;
            border: 1px solid var(--line);
            border-radius: 24px;
            background: white;
        }

        .search svg {
            width: 16px;
            height: 16px;
            color: #728182;
        }

        .search input {
            width: 100%;
            border: 0;
            outline: 0;
            color: var(--text);
            font-size: 12px;
        }

        .search input::placeholder { color: #8a9695; }

        .icon-button {
            width: 40px;
            height: 40px;
            display: grid;
            place-items: center;
            border: 1px solid var(--line);
            border-radius: 50%;
            background: white;
            color: var(--teal);
        }

        .user-avatar {
            width: 40px;
            height: 40px;
            display: grid;
            place-items: center;
            border: 0;
            border-radius: 50%;
            background: #dcebed;
            color: var(--teal);
            font-weight: bold;
        }

        .stats {
            display: grid;
            grid-template-columns: repeat(4, minmax(0, 1fr));
            gap: 12px;
            margin-bottom: 18px;
        }

        .stat-card {
            min-height: 76px;
            padding: 15px 16px;
            border: 1px solid var(--line);
            border-radius: 13px;
            background: white;
        }

        .stat-card span {
            display: block;
            margin-bottom: 7px;
            color: #778585;
            font-size: 11px;
        }

        .stat-card strong {
            font-size: 19px;
            letter-spacing: .02em;
        }

        .stat-card.red strong { color: #df482e; }
        .stat-card.orange strong { color: #b36b1c; }
        .stat-card.blue strong { color: var(--teal); }

        .content-grid {
            display: grid;
            grid-template-columns: minmax(260px, .75fr) minmax(0, 1.65fr);
            gap: 16px;
        }

        .panel {
            min-width: 0;
            overflow: hidden;
            border: 1px solid var(--line);
            border-radius: 16px;
            background: white;
        }

        .panel-heading {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 10px;
            padding: 18px 18px 12px;
        }

        .panel-heading h2 {
            margin: 0;
            font-size: 15px;
        }

        .panel-heading a {
            color: var(--teal);
            font-size: 11px;
            font-weight: bold;
            text-decoration: none;
        }

        .updates {
            padding: 0 18px 16px;
        }

        .update-item {
            display: block;
            color: inherit;
            text-decoration: none;
            cursor: pointer;
            padding: 12px 0;
            border-bottom: 1px solid #edf0ed;
        }

        .update-item:last-child { border-bottom: 0; }
        .update-item:hover h3 { color: var(--teal); }

        .tag {
            display: inline-block;
            margin-bottom: 6px;
            padding: 4px 8px;
            border-radius: 20px;
            background: #fff0e9;
            color: #b7472e;
            font-size: 10px;
            font-weight: bold;
        }

        .tag.orange {
            background: #fff4df;
            color: #a66b1a;
        }

        .update-item h3 {
            margin: 0 0 5px;
            color: #243c40;
            font-size: 12px;
            line-height: 1.4;
        }

        .update-item p {
            margin: 0;
            color: #899493;
            font-size: 10px;
        }

        /* Panel peta ilustratif */
        .map-panel {
            position: relative;
            min-height: 420px;
            background: #a9d9ed;
        }

        .map-art {
            position: absolute;
            inset: 0;
            overflow: hidden;
            background:
                linear-gradient(25deg, transparent 45%, rgba(255,255,255,.2) 46%, transparent 47%),
                linear-gradient(130deg, transparent 62%, rgba(255,255,255,.18) 63%, transparent 64%),
                #a9d9ed;
        }

        .land {
            position: absolute;
            background: #d9dfc7;
            border: 1px solid rgba(125, 155, 137, .65);
            box-shadow: inset 0 0 20px rgba(255,255,255,.35);
        }

        .land.one {
            top: 5%;
            left: 13%;
            width: 28%;
            height: 22%;
            border-radius: 55% 38% 48% 35%;
            transform: rotate(-15deg);
        }

        .land.two {
            top: 36%;
            left: 3%;
            width: 29%;
            height: 17%;
            border-radius: 45% 50% 35% 55%;
            transform: rotate(12deg);
        }

        .land.three {
            top: 49%;
            left: 32%;
            width: 22%;
            height: 12%;
            border-radius: 50% 40% 55% 35%;
            transform: rotate(-8deg);
        }

        .land.four {
            top: 57%;
            left: 53%;
            width: 24%;
            height: 14%;
            border-radius: 40% 55% 35% 50%;
            transform: rotate(8deg);
        }

        .land.five {
            top: 24%;
            left: 66%;
            width: 28%;
            height: 20%;
            border-radius: 40% 55% 45% 50%;
            transform: rotate(-12deg);
        }

        .land.six {
            top: 78%;
            left: 22%;
            width: 61%;
            height: 10%;
            border-radius: 50%;
            transform: rotate(-4deg);
        }

        .map-label {
            position: absolute;
            color: #567274;
            font-size: 11px;
            text-shadow: 0 1px 2px white;
        }

        .label-indonesia { top: 57%; left: 42%; font-weight: bold; }
        .label-malaysia { top: 40%; left: 26%; }
        .label-papua { top: 68%; right: 7%; }

        .quake {
            position: absolute;
            width: 23px;
            height: 23px;
            border: 1px solid rgba(210, 41, 36, .65);
            border-radius: 50%;
            background: rgba(240, 61, 51, .72);
            box-shadow: 0 0 0 7px rgba(240, 61, 51, .14);
        }

        .q1 { top: 56%; left: 20%; }
        .q2 { top: 63%; left: 35%; }
        .q3 { top: 51%; left: 48%; }
        .q4 { top: 67%; left: 61%; }
        .q5 { top: 44%; left: 72%; }
        .q6 { top: 72%; left: 82%; }
        .q7 { top: 38%; left: 56%; }
        .q8 { top: 76%; left: 46%; }
        .q9 { top: 55%; left: 89%; }

        .map-title {
            position: absolute;
            top: 15px;
            left: 16px;
            padding: 9px 12px;
            border: 1px solid rgba(255,255,255,.75);
            border-radius: 9px;
            background: rgba(255,255,255,.88);
            font-size: 12px;
            font-weight: bold;
        }

        .map-legend {
            position: absolute;
            bottom: 14px;
            left: 16px;
            padding: 8px 10px;
            border-radius: 8px;
            background: rgba(255,255,255,.88);
            color: #5b6a6b;
            font-size: 10px;
        }

        .map-legend i {
            display: inline-block;
            width: 8px;
            height: 8px;
            margin-right: 4px;
            border-radius: 50%;
            background: #ef463b;
        }

        .map-button {
            position: absolute;
            right: 14px;
            bottom: 14px;
            padding: 10px 14px;
            border: 0;
            border-radius: 20px;
            background: white;
            color: var(--teal);
            font-size: 11px;
            font-weight: bold;
            text-decoration: none;
        }

        .logout-form { margin: 12px 0 0; }

        .logout-button {
            display: block;
            width: 100%;
            margin-top: 12px;
            padding: 12px 14px;
            box-sizing: border-box;
            border: 1px solid rgba(255, 255, 255, .3);
            border-radius: 9px;
            background: transparent;
            color: #e2eff0;
            font: inherit;
            font-size: 13px;
            text-align: center;
            text-decoration: none;
            cursor: pointer;
        }

.logout-button:hover {
    background: rgba(255, 255, 255, .12);
        }
        .notification-wrap {
            position: relative;
            z-index: 1101;
        }

        .notification-toggle {
            position: relative;
            cursor: pointer;
        }

        .notification-toggle svg {
            width: 18px;
            height: 18px;
        }

        .notification-badge[hidden] { display: none !important; }

        .notification-badge {
            position: absolute;
            top: -4px;
            right: -3px;
            min-width: 17px;
            height: 17px;
            display: grid;
            place-items: center;
            padding: 0 4px;
            border: 2px solid white;
            border-radius: 20px;
            background: #e64e3f;
            color: white;
            font-size: 9px;
            font-weight: bold;
        }

        .notification-menu {
            position: absolute;
            z-index: 1102;
            top: calc(100% + 12px);
            right: 0;
            width: min(350px, calc(100vw - 32px));
            overflow: hidden;
            border: 1px solid var(--line);
            border-radius: 14px;
            background: white;
            box-shadow: 0 12px 35px rgb(20 45 50 / 16%);
        }

        .notification-menu[hidden] {
            display: none;
        }

        .notification-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 12px;
            padding: 16px;
            border-bottom: 1px solid var(--line);
        }

        .notification-header h2 {
            margin: 0;
            font-size: 15px;
        }

        .notification-header button {
            padding: 0;
            border: 0;
            background: transparent;
            color: var(--teal);
            font-size: 11px;
            font-weight: bold;
            cursor: pointer;
        }

        .notification-list {
            max-height: min(330px, calc(100vh - 220px));
            overflow-y: auto;
        }

        .notification-item {
            text-decoration: none;
            width: 100%;
            display: flex;
            align-items: flex-start;
            gap: 11px;
            padding: 14px 16px;
            border: 0;
            border-bottom: 1px solid #edf0ed;
            background: white;
            color: var(--text);
            text-align: left;
            cursor: pointer;
        }

        .notification-item:hover {
            background: #f8faf8;
        }

        .notification-item.unread {
            background: #f2f8f8;
        }

        .notification-dot {
            width: 9px;
            height: 9px;
            flex: 0 0 auto;
            margin-top: 4px;
            border-radius: 50%;
            background: #e64e3f;
        }

        .notification-item:not(.unread) .notification-dot {
            background: #d8dfdc;
        }

        .notification-copy {
            display: grid;
            gap: 5px;
        }

        .notification-copy strong {
            font-size: 12px;
            line-height: 1.4;
        }

        .notification-copy span {
            color: #788889;
            font-size: 11px;
            line-height: 1.4;
        }

        .notification-copy time {
            color: #9aa4a3;
            font-size: 10px;
        }

        .notification-footer {
            display: block;
            padding: 12px;
            color: var(--teal);
            text-align: center;
            text-decoration: none;
            font-size: 12px;
            font-weight: bold;
        }

        .notification-footer:hover {
            background: #f8faf8;
        }

        @media (max-width: 950px) {
            .app { grid-template-columns: 260px minmax(0, 1fr); }
            .main { padding: 22px; }
            .content-grid { grid-template-columns: 1fr; }
            .map-panel { min-height: 360px; }
        }

        @media (max-width: 680px) {
            .app { display: block; }

            .sidebar {
                min-height: auto;
                padding: 12px;
            }

            .brand { padding: 0 6px 12px; }

            .nav {
                display: flex;
                gap: 6px;
                overflow-x: auto;
                padding-bottom: 4px;
            }

            .nav a {
                min-width: max-content;
                min-height: 38px;
                padding: 0 10px;
                font-size: 12px;
            }

            .sidebar-bottom { display: none; }
            .main { padding: 20px 14px; }

            .topbar {
            position: relative;
            z-index: 1100;
                align-items: flex-start;
                flex-direction: column;
            }

            .top-actions { width: 100%; }
            .search { width: 100%; flex: 1; }

            .stats {
                grid-template-columns: repeat(2, minmax(0, 1fr));
                gap: 8px;
            }

            .stat-card { padding: 12px; }
            .stat-card strong { font-size: 17px; }
            .map-panel { min-height: 320px; }
        }

                #sigana-map {
            width: 100%;
            height: 380px;
        }

        @media (max-width: 680px) {
            #sigana-map {
                height: 320px;
            }
        }
        @media (min-width: 681px) {
    html,
    body {
        height: 100%;
        overflow: hidden;
    }

    .app {
        height: 100vh;
        min-height: 0;
        overflow: hidden;
    }

    .sidebar {
        height: 100vh;
        min-height: 0;
        overflow-y: auto;
        overscroll-behavior: contain;
    }

    .main {
        height: 100vh;
        min-height: 0;
        overflow-y: auto;
        overscroll-behavior: contain;
    }
}

@media (max-width: 680px) {
    html,
    body {
        height: auto;
        overflow: auto;
    }

    .app {
        height: auto;
        min-height: 100vh;
        overflow: visible;
    }

    .sidebar {
        height: auto;
        min-height: auto;
        overflow: visible;
    }

    .main {
        height: auto;
        min-height: 0;
        overflow: visible;
    }
}
    </style>
</head>

<body>
<div class="app">
    <aside class="sidebar">
        <div class="brand">
            <div class="brand-icon" aria-hidden="true">
                <svg viewBox="0 0 32 32" fill="none">
                    <path d="M5 20c3 0 3-8 6-8s3 8 6 8 3-8 6-8"
                          stroke="currentColor" stroke-width="2.2"
                          stroke-linecap="round"/>
                    <circle cx="24" cy="8" r="2.5" fill="#e06445"/>
                </svg>
            </div>
            <div>
                <h2 class="brand-name">SIGANA</h2>
                <p class="brand-caption">Monitoring Bencana Alam</p>
            </div>
        </div>

        <nav class="nav" aria-label="Menu utama">
            <a class="active" href="{{ auth()->check() ? route('dashboard') : route('guest.home') }}">
                <span>⌂</span> Dashboard
            </a>
            <a href="{{ route('bencana.index') }}">
                <span>⚠</span> Bencana
            </a>
            <a href="{{ route('tips.index') }}">
                <span>♡</span> Tips &amp; darurat
            </a>
            <a href="{{ route('bantuan.index') }}">
                <span>◌</span> Bantuan
            </a>
            <a href="{{ route('profil.index') }}">
    <span>♙</span> Profil
</a>
        </nav>

        <div class="sidebar-bottom">
            <div class="emergency-card">
                <span>Keadaan darurat?</span>
                <strong>112</strong>
            </div>

            @if (auth()->check())
                <form class="logout-form" method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button class="logout-button" type="submit">Keluar dari akun</button>
                </form>
            @else
                <a class="logout-button" href="{{ route('login') }}">Masuk ke akun</a>
            @endif
        </div>
    </aside>

    <main class="main">
        <header class="topbar">
            <div class="welcome">
                <h1>Selamat datang, {{ auth()->user()->name ?? 'Pengguna' }}</h1>
                <p>Pantau kondisi kebencanaan di sekitar Anda.</p>
            </div>

            <div class="top-actions">
                <label class="search">
                    <svg viewBox="0 0 24 24" fill="none" aria-hidden="true">
                        <circle cx="10.8" cy="10.8" r="6.5"
                                stroke="currentColor" stroke-width="1.7"/>
                        <path d="m16 16 4.2 4.2"
                              stroke="currentColor" stroke-width="1.7"
                              stroke-linecap="round"/>
                    </svg>
                    <input type="search" placeholder="Cari kejadian atau wilayah">
                </label>

                <div class="notification-wrap">
            <button
                class="icon-button notification-toggle"
                id="notificationToggle"
                type="button"
                aria-label="Buka notifikasi"
                aria-expanded="false"
                aria-controls="notificationMenu"
            >
                <svg viewBox="0 0 24 24" fill="none" aria-hidden="true">
                    <path d="M18 9a6 6 0 0 0-12 0c0 7-3 7-3 9h18c0-2-3-2-3-9Z"
                        stroke="currentColor" stroke-width="1.7"
                        stroke-linecap="round" stroke-linejoin="round"/>
                    <path d="M10 21h4"
                        stroke="currentColor" stroke-width="1.7"
                        stroke-linecap="round"/>
                </svg>
                <span class="notification-badge" id="notificationCount" @if ($unreadNotifications === 0) hidden @endif>{{ $unreadNotifications }}</span>
            </button>

            <section
                class="notification-menu"
                id="notificationMenu"
                aria-label="Daftar notifikasi"
                hidden
            >
                <header class="notification-header">
                    <h2>Notifikasi</h2>
                    @auth<form method="POST" action="{{ route('notifications.read-all') }}">@csrf<button type="submit" id="markAllRead">Tandai dibaca</button></form>@endauth
                </header>

                <div class="notification-list">
                    @forelse ($notifications as $notification)
                        <a class="notification-item {{ $notification->is_read ? '' : 'unread' }}" href="{{ route('bencana.index') }}">
                            <span class="notification-dot"></span>
                            <span class="notification-copy">
                                <strong>{{ $notification->title }}</strong>
                                <span>{{ $notification->message }}</span>
                                <time>{{ $notification->created_at ? \Illuminate\Support\Carbon::parse($notification->created_at, 'UTC')->setTimezone('Asia/Jakarta')->locale('id')->translatedFormat('j M Y · H.i') . ' WIB' : 'Baru saja' }}</time>
                            </span>
                        </article>
                    @empty
                        <p class="notification-empty">Belum ada notifikasi.</p>
                    @endforelse
                </div>

                <a class="notification-footer" href="{{ route('bencana.index') }}">
                    Lihat update terbaru
                </a>
            </section>
        </div>
                <div class="user-avatar" title="{{ auth()->user()->name ?? 'Pengguna' }}">
                    {{ strtoupper(substr(auth()->user()->name ?? 'P', 0, 1)) }}
                </div>
            </div>
        </header>

        <section class="stats" aria-label="Ringkasan bencana">
            <article class="stat-card red">
                <span>Kejadian aktif</span>
                <strong>[{{ $stats['active'] }}]</strong>
            </article>
            <article class="stat-card orange">
                <span>Sedang dipantau</span>
                <strong>[{{ $stats['monitored'] }}]</strong>
            </article>
            <article class="stat-card blue">
                <span>Wilayah terdampak</span>
                <strong>[{{ $stats['areas'] }}]</strong>
            </article>
            <article class="stat-card blue">
                <span>Pembaruan terakhir</span>
                <strong>[{{ $stats['latest'] }}]</strong>
            </article>
        </section>

        <section class="content-grid">
            <article class="panel" id="updates">
                <div class="panel-heading">
                    <h2>Update terbaru</h2>
                    <a href="{{ route('bencana.index') }}">Lihat semua</a>
                </div>

                <div class="updates">
                    @forelse ($disasters->take(5) as $disaster)
                        <a class="update-item" href="{{ route('bencana.detail', $disaster->id) }}">
                            <span class="tag">{{ $disaster->category }}</span>
                            <h3>{{ $disaster->title }}</h3>
                            <p>{{ \Illuminate\Support\Carbon::parse($disaster->occurred_at, 'UTC')->setTimezone('Asia/Jakarta')->locale('id')->translatedFormat('j M Y · H.i') }} WIB · {{ $disaster->location }}</p>
                        </a>
                    @empty
                        <p class="updates-empty">Belum ada kejadian bencana di database.</p>
                    @endforelse
                </div>
            </article>

            <article class="panel map-panel" id="map">
            <div class="panel-heading">
                <h2>Peta kejadian bencana</h2>
            </div>

            <div id="sigana-map"></div>
        </article>
        </section>
    </main>
</div>
<script>
    const notificationToggle = document.getElementById('notificationToggle');
    const notificationMenu = document.getElementById('notificationMenu');

    function closeNotifications() {
        notificationMenu.hidden = true;
        notificationToggle.setAttribute('aria-expanded', 'false');
    }

    notificationToggle.addEventListener('click', function (event) {
        event.stopPropagation();
        const open = notificationMenu.hidden;
        notificationMenu.hidden = !open;
        notificationToggle.setAttribute('aria-expanded', String(open));
    });

    notificationMenu.addEventListener('click', function (event) {
        event.stopPropagation();
    });

    document.addEventListener('click', closeNotifications);

    document.addEventListener('keydown', function (event) {
        if (event.key === 'Escape') closeNotifications();
    });
</script>

<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>

<script>
    const map = L.map('sigana-map').setView([-2.5, 118], 4);

    L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
        maxZoom: 19,
        attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap contributors</a>'
    }).addTo(map);

    const disasterPoints = @json($mapDisasters);

    function makeDisasterPopup(disaster) {
        const content = document.createElement('div');
        const title = document.createElement('strong');
        title.textContent = disaster.title;
        const location = document.createElement('div');
        location.textContent = disaster.location;
        content.append(title, location);
        return content;
    }
    disasterPoints.forEach(function (disaster) {
        L.marker([disaster.latitude, disaster.longitude])
            .addTo(map)
            .bindPopup(makeDisasterPopup(disaster));
    });
</script>
</body>
</html>
