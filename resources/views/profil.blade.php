<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profil | SIGANA</title>

    <style>
        :root {
            --teal: #105563;
            --page: #f4f5f2;
            --border: #e1e7e5;
            --text: #18313a;
            --muted: #71808a;
            --orange: #d64d2c;
        }

        * { box-sizing: border-box; }

        body {
            margin: 0;
            color: var(--text);
            background: var(--page);
            font-family: Arial, Helvetica, sans-serif;
        }

        .app {
            min-height: 100vh;
            display: grid;
            grid-template-columns: 240px minmax(0, 1fr);
        }

        .sidebar {
            height: 100vh;
            position: sticky;
            top: 0;
            display: flex;
            flex-direction: column;
            padding: 24px 16px 16px;
            overflow-y: auto;
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
            flex: 0 0 38px;
            display: grid;
            place-items: center;
            border-radius: 10px;
            background: white;
            color: var(--teal);
            font-size: 24px;
        }

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
            min-height: 42px;
            display: flex;
            align-items: center;
            gap: 14px;
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

        .sidebar-bottom {
            margin-top: auto;
            padding-top: 18px;
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

        .logout-form { margin: 0; }

        .logout-button {
            width: 100%;
            min-height: 42px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-top: 12px;
            padding: 12px 14px;
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

        .main {
            min-width: 0;
            padding: 28px;
            overflow-y: auto;
        }

        .page {
            width: 100%;
            max-width: 1100px;
            margin: 0 auto;
        }

        .heading {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 16px;
        }

        .heading h1 {
            margin: 0;
            font-size: 24px;
        }

        .gear-link {
            width: 42px;
            height: 42px;
            display: grid;
            place-items: center;
            border: 1px solid var(--border);
            border-radius: 50%;
            background: white;
            color: var(--teal);
            text-decoration: none;
        }

        .gear-link svg { width: 21px; height: 21px; }

        .profile-layout {
            display: grid;
            grid-template-columns: 228px minmax(0, 1fr);
            align-items: start;
            gap: 16px;
        }

        .profile-card,
        .panel {
            border: 1px solid var(--border);
            border-radius: 16px;
            background: white;
        }

        .profile-card {
            padding: 20px 16px;
            text-align: center;
        }

        .avatar {
            width: 80px;
            height: 80px;
            display: grid;
            place-items: center;
            margin: 0 auto 10px;
            border-radius: 50%;
            background: #e2eff0;
            color: var(--teal);
            font-size: 38px;
        }

        .profile-card h2 { margin: 0; font-size: 16px; }

        .email {
            margin: 4px 0 14px;
            color: var(--muted);
            font-size: 12px;
        }

        .profile-card form { margin: 0; }

        .profile-logout {
            width: 100%;
            min-height: 38px;
            display: flex;
            align-items: center;
            justify-content: center;
            border: 1px solid var(--orange);
            border-radius: 22px;
            background: white;
            color: var(--orange);
            font: inherit;
            font-size: 12px;
            text-decoration: none;
            cursor: pointer;
        }

        .details {
            display: grid;
            gap: 14px;
        }

        .panel { padding: 16px; }

        .panel h2 {
            margin: 0 0 12px;
            font-size: 16px;
        }

        .info-grid {
            display: grid;
            grid-template-columns: repeat(2, minmax(0, 1fr));
            gap: 10px;
        }

        .info-item span {
            display: block;
            margin-bottom: 5px;
            font-size: 11px;
            font-weight: 600;
        }

        .info-value {
            min-height: 38px;
            display: flex;
            align-items: center;
            padding: 0 12px;
            border: 1px solid var(--border);
            border-radius: 11px;
            background: var(--page);
            font-size: 12px;
        }

        .setting-row {
            min-height: 44px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 12px;
            border-top: 1px solid #edf0ee;
            color: var(--text);
            font-size: 12px;
            text-decoration: none;
        }

        .setting-row:first-of-type { border-top: 0; }

        .setting-value,
        .setting-arrow { color: var(--muted); }

        .toggle {
            width: 38px;
            height: 22px;
            position: relative;
            appearance: none;
            border-radius: 20px;
            background: #cbd4d4;
            cursor: pointer;
        }

        .toggle::before {
            width: 16px;
            height: 16px;
            position: absolute;
            top: 3px;
            left: 3px;
            border-radius: 50%;
            background: white;
            content: "";
            transition: transform .2s;
        }

        .toggle:checked { background: var(--teal); }
        .toggle:checked::before { transform: translateX(16px); }

        @media (max-width: 760px) {
            .app { grid-template-columns: 200px minmax(0, 1fr); }
            .main { padding: 20px; }
            .profile-layout { grid-template-columns: 1fr; }
        }

        @media (max-width: 600px) {
            .app { display: block; }

            .sidebar {
                height: auto;
                position: static;
                padding: 12px;
                overflow: visible;
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

            .sidebar-bottom { padding-top: 12px; }
            .main { padding: 20px 14px; }
            .info-grid { grid-template-columns: 1fr; }
        }
    </style>
</head>

<body>
<div class="app">
    <aside class="sidebar">
        <div class="brand">
            <div class="brand-icon" aria-hidden="true"><svg viewBox="0 0 32 32" fill="none" style="width:25px;height:25px">
    <path d="M5 20c3 0 3-8 6-8s3 8 6 8 3-8 6-8"
          stroke="currentColor" stroke-width="2.2" stroke-linecap="round"/>
    <circle cx="24" cy="8" r="2.5" fill="#e06445"/>
</svg></div>
            <div>
                <h2 class="brand-name">SIGANA</h2>
                <p class="brand-caption">Monitoring Bencana Alam</p>
            </div>
        </div>

        <nav class="nav" aria-label="Menu utama">
            <a href="{{ auth()->check() ? route('dashboard') : route('guest.home') }}">
                <span>⌂</span> Dashboard
            </a>
            <a href="{{ route('bencana.index') }}"><span>⚠</span> Bencana</a>
            <a href="{{ route('tips.index') }}"><span>♡</span> Tips &amp; darurat</a>
            <a href="{{ route('bantuan.index') }}"><span>◌</span> Bantuan</a>
            <a class="active" href="{{ route('profil.index') }}"><span>♙</span> Profil</a>
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
        <section class="page">
            <div class="heading">
                <h1>Profil</h1>
                @if (session('status'))<p class="success-message">{{ session('status') }}</p>@endif

                <a class="gear-link"
                   href="{{ route('profil.edit') }}"
                   aria-label="Edit profil"
                   title="Edit profil">
                    <svg viewBox="0 0 24 24" fill="none" aria-hidden="true">
                        <path d="M12 8a4 4 0 1 0 0 8 4 4 0 0 0 0-8Z"
                              stroke="currentColor" stroke-width="1.8"/>
                        <path d="m19 13 .1-.9-1.2-.9-.5-1.2.4-1.4-1.4-1.4-1.4.4-1.2-.5-.9-1.2h-2l-.9 1.2-1.2.5-1.4-.4-1.4 1.4.4 1.4-.5 1.2-1.2.9v2l1.2.9.5 1.2-.4 1.4 1.4 1.4 1.4-.4 1.2.5.9 1.2h2l.9-1.2 1.2-.5 1.4.4 1.4-1.4-.4-1.4.5-1.2 1.2-.9v-2Z"
                              stroke="currentColor" stroke-width="1.4"
                              stroke-linejoin="round"/>
                    </svg>
                </a>
            </div>

            <div class="profile-layout">
                <section class="profile-card">
                    <div class="avatar" aria-hidden="true">♙</div>
                    <h2>{{ auth()->user()?->name ?? '[Nama pengguna]' }}</h2>
                    <p class="email">
                        {{ auth()->user()?->email ?? '[email@contoh.id]' }}
                    </p>

                    @if (auth()->check())
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button class="profile-logout" type="submit">↪ Keluar</button>
                        </form>
                    @else
                        <a class="profile-logout" href="{{ route('login') }}">↪ Masuk</a>
                    @endif
                </section>

                <div class="details">
                    <section class="panel">
                        <h2>Informasi pribadi</h2>

                        <div class="info-grid">
                            <div class="info-item">
                                <span>Nama lengkap</span>
                                <div class="info-value">
                                    {{ auth()->user()?->name ?? '[Nama lengkap]' }}
                                </div>
                            </div>
                            <div class="info-item">
                                <span>Email</span>
                                <div class="info-value">
                                    {{ auth()->user()?->email ?? '[email@contoh.id]' }}
                                </div>
                            </div>
                            <div class="info-item">
                                <span>Nomor telepon</span>
                                <div class="info-value">{{ auth()->user()?->phone ?: 'Belum ditambahkan' }}</div>
                            </div>
                            <div class="info-item">
                                <span>Kota / kabupaten</span>
                                <div class="info-value">Belum ditambahkan</div>
                            </div>
                        </div>
                    </section>

                    <section class="panel">
                        <h2>Pengaturan</h2>

                        <label class="setting-row">
                            <span>♧ &nbsp; Notifikasi peringatan</span>
                            <input class="toggle" type="checkbox" checked>
                        </label>

                        <div class="setting-row">
                            <span>◎ &nbsp; Bahasa</span>
                            <span class="setting-value">Indonesia</span>
                        </div>

                        <a class="setting-row" href="{{ route('tips.index') }}">
                            <span>♧ &nbsp; Nomor Darurat!</span>
                            <span class="setting-arrow">›</span>
                        </a>

                        <a class="setting-row" href="{{ route('tentang.index') }}">
    <span>ⓘ &nbsp; Tentang SIGANA</span>
    <span class="setting-arrow">›</span>
</a>
                    </section>
                </div>
            </div>
        </section>
    </main>
</div>
</body>
</html>