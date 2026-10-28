<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tentang SIGANA</title>

    <style>
        :root {
            --teal: #105563;
            --page: #f4f5f2;
            --border: #e1e7e5;
            --text: #18313a;
            --muted: #71808a;
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

        .content {
            width: 100%;
            max-width: 1000px;
            margin: 0 auto;
        }

        .heading {
            display: flex;
            align-items: center;
            gap: 12px;
            margin-bottom: 18px;
        }

        .back-link {
            color: var(--teal);
            font-size: 14px;
            text-decoration: none;
        }

        h1 {
            margin: 0;
            font-size: 24px;
        }

        .hero,
        .info-card {
            border: 1px solid var(--border);
            border-radius: 16px;
            background: white;
        }

        .hero {
            display: flex;
            align-items: center;
            gap: 18px;
            padding: 24px;
        }

        .hero-icon {
            width: 64px;
            height: 64px;
            flex: 0 0 64px;
            display: grid;
            place-items: center;
            border-radius: 16px;
            background: var(--teal);
            color: white;
            font-size: 34px;
        }

        .hero h2 {
            margin: 0 0 6px;
            color: var(--teal);
            font-size: 23px;
        }

        .hero p,
        .info-card p {
            margin: 0;
            color: var(--muted);
            font-size: 14px;
            line-height: 1.7;
        }

        .info-card {
            margin-top: 16px;
            padding: 20px;
        }

        .info-card h2 {
            margin: 0 0 10px;
            font-size: 17px;
        }

        .feature-grid {
            display: grid;
            grid-template-columns: repeat(3, minmax(0, 1fr));
            gap: 12px;
            margin-top: 16px;
        }

        .feature {
            padding: 16px;
            border: 1px solid var(--border);
            border-radius: 13px;
            background: white;
        }

        .feature-icon {
            width: 36px;
            height: 36px;
            display: grid;
            place-items: center;
            margin-bottom: 10px;
            border-radius: 10px;
            background: #e2eff0;
            color: var(--teal);
            font-size: 18px;
        }

        .feature h3 {
            margin: 0 0 6px;
            font-size: 14px;
        }

        .feature p {
            margin: 0;
            color: var(--muted);
            font-size: 12px;
            line-height: 1.6;
        }

        .notice {
            margin-top: 16px;
            padding: 14px 16px;
            border: 1px solid #f0d7c9;
            border-radius: 12px;
            background: #fff8f3;
            color: #704632;
            font-size: 13px;
            line-height: 1.6;
        }

        @media (max-width: 760px) {
            .app { grid-template-columns: 200px minmax(0, 1fr); }
            .main { padding: 20px; }
            .feature-grid { grid-template-columns: 1fr; }
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

            .hero {
                align-items: flex-start;
                flex-direction: column;
                padding: 18px;
            }
        }
    </style>
    <link rel="stylesheet" href="{{ asset('css/sigana-theme.css') }}?v=6">
    <script src="{{ asset('js/sigana-theme.js') }}?v=4" defer></script>
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
        <section class="content">
            <div class="heading">
                <a class="back-link" href="{{ route('profil.index') }}">← Kembali</a>
                <h1>Tentang SIGANA</h1>
            </div>

            <section class="hero">
                <div class="hero-icon" aria-hidden="true"><svg viewBox="0 0 32 32" fill="none" style="width:25px;height:25px">
    <path d="M5 20c3 0 3-8 6-8s3 8 6 8 3-8 6-8"
          stroke="currentColor" stroke-width="2.2" stroke-linecap="round"/>
    <circle cx="24" cy="8" r="2.5" fill="#e06445"/>
</svg></div>
                <div>
                    <h2>SIGANA</h2>
                    <p>Monitoring Bencana Alam</p>
                </div>
            </section>

            <section class="info-card">
                <h2>Tentang aplikasi</h2>
                <p>
                    SIGANA membantu pengguna melihat informasi kejadian bencana,
                    membaca panduan keselamatan, dan menemukan akses bantuan
                    melalui satu aplikasi.
                </p>
            </section>

            <div class="feature-grid">
                <article class="feature">
                    <div class="feature-icon" aria-hidden="true">⚠</div>
                    <h3>Informasi bencana</h3>
                    <p>Lihat daftar kejadian dan informasi keselamatan terkait bencana.</p>
                </article>

                <article class="feature">
                    <div class="feature-icon" aria-hidden="true">♡</div>
                    <h3>Tips keselamatan</h3>
                    <p>Pelajari langkah yang dapat dilakukan sebelum dan saat bencana.</p>
                </article>

                <article class="feature">
                    <div class="feature-icon" aria-hidden="true">☎</div>
                    <h3>Bantuan darurat</h3>
                    <p>Temukan informasi nomor darurat dan layanan bantuan.</p>
                </article>
            </div>

            <div class="notice">
                Informasi pada SIGANA membantu pengguna memperoleh gambaran awal.
                Untuk kondisi darurat, ikuti arahan petugas dan informasi dari
                instansi resmi.
            </div>

            @if (($information ?? collect())->isNotEmpty())
                <section class="info-card">
                    <h2>Informasi terbaru</h2>
                    @foreach ($information as $item)
                        <article style="padding: 14px 0; border-top: 1px solid #edf0ee;">
                            <h3 style="margin: 0 0 8px;">{{ $item->title }}</h3>
                            @if ($item->image)
                                <img src="{{ \Illuminate\Support\Str::startsWith($item->image, ['http://', 'https://', '/']) ? $item->image : asset('storage/' . $item->image) }}" alt="{{ $item->title }}" style="display:block; width:min(100%, 560px); max-height:280px; margin:10px 0; border-radius:12px; object-fit:cover;">
                            @endif
                            <p style="white-space:pre-line;">{{ $item->content }}</p>
                        </article>
                    @endforeach
                </section>
            @endif
        </section>
    </main>
</div>
</body>
</html>