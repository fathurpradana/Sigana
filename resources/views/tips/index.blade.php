<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tips Keselamatan | SIGANA</title>

    <style>
        * { box-sizing: border-box; }

        :root {
            --teal: #105361;
            --page: #f4f5f2;
            --text: #19373d;
            --muted: #788889;
            --line: #e6eae7;
            --orange: #c94320;
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
            font-size: 20px;
        }

        .brand-name { margin: 0; font-size: 17px; }
        .brand-caption { margin: 3px 0 0; color: #c6dfe2; font-size: 10px; }

        .nav { display: grid; gap: 7px; }

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

        .main {
            min-width: 0;
            padding: 28px clamp(18px, 3vw, 42px);
        }

        .page-heading { margin-bottom: 20px; }

        .page-heading h1 {
            margin: 0;
            font-size: clamp(22px, 2.6vw, 30px);
        }

        .page-heading p {
            margin: 6px 0 0;
            color: var(--muted);
            font-size: 13px;
        }

        .content {
            display: grid;
            grid-template-columns: minmax(0, 1fr) 300px;
            align-items: start;
            gap: 16px;
        }

        .tips-grid {
            display: grid;
            grid-template-columns: repeat(2, minmax(0, 1fr));
            gap: 10px;
        }

.sidebar-bottom {
            margin-top: auto;
        }

        .tips-empty, .contacts-empty { padding: 22px; color: var(--muted); text-align: center; }

        .tip-card {
            min-height: 112px;
            display: flex;
            gap: 12px;
            padding: 15px;
            border: 1px solid var(--line);
            border-radius: 13px;
            background: white;
        }

        .tip-number {
            width: 32px;
            height: 32px;
            flex: 0 0 auto;
            display: grid;
            place-items: center;
            border-radius: 50%;
            background: var(--teal);
            color: white;
            font-size: 12px;
            font-weight: bold;
        }

        .tip-card:nth-child(6) .tip-number { background: var(--orange); }

        .tip-card h2 {
            margin: 1px 0 6px;
            font-size: 13px;
        }

        .tip-card p {
            margin: 0;
            color: #738181;
            font-size: 11px;
            line-height: 1.55;
        }

        .contact-column { display: grid; gap: 10px; }

        .call-112 {
            min-height: 84px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 14px;
            padding: 15px 17px;
            border-radius: 14px;
            background: var(--orange);
            color: white;
            text-decoration: none;
        }

        .call-112 span,
        .call-112 small { display: block; }

        .call-112 span { font-size: 11px; }
        .call-112 strong { display: block; margin: 3px 0; font-size: 24px; }
        .call-112 small { font-size: 10px; }

        .call-icon {
            width: 40px;
            height: 40px;
            display: grid;
            place-items: center;
            border-radius: 50%;
            background: white;
            color: var(--orange);
            font-size: 20px;
        }

        .contacts {
            overflow: hidden;
            border: 1px solid var(--line);
            border-radius: 14px;
            background: white;
        }

        .contact {
            min-height: 54px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 12px;
            padding: 10px 13px;
            border-bottom: 1px solid #edf0ed;
            color: inherit;
            text-decoration: none;
        }

        .contact:last-child { border-bottom: 0; }
        .contact:hover { background: #f8faf8; }

        .contact-name { display: block; font-size: 12px; font-weight: bold; }
        .contact-description { display: block; margin-top: 3px; color: var(--muted); font-size: 10px; }
        .contact-number { color: var(--teal); font-size: 12px; font-weight: bold; }

        .notice {
            margin: 0;
            color: var(--muted);
            font-size: 10px;
            line-height: 1.5;
        }

        @media (max-width: 900px) {
            .content { grid-template-columns: 1fr; }
            .contact-column { grid-template-columns: 1fr 1fr; }
            .call-112, .notice { grid-column: 1 / -1; }
        }

        @media (max-width: 680px) {
            .app { display: block; }

            .sidebar {
                min-height: auto;
                padding: 12px;
            }

            .brand { padding: 0 5px 12px; }

            .nav {
                display: flex;
                gap: 5px;
                overflow-x: auto;
            }

            .nav a {
                min-width: max-content;
                min-height: 36px;
                padding: 0 10px;
            }

            .sidebar-emergency { display: none; }
            .main { padding: 20px 14px; }
            .tips-grid { grid-template-columns: 1fr; }
            .contact-column { grid-template-columns: 1fr; }
        }

        @media (min-width: 681px) {
            html, body { height: 100%; overflow: hidden; }
            .app { height: 100vh; min-height: 0; overflow: hidden; }
            .sidebar { height: 100vh; min-height: 0; }
            .main { height: 100vh; min-height: 0; overflow-y: auto; }
        }

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
    </style>
</head>

<body>
<div class="app">
    <aside class="sidebar">
        <div class="brand">
            <div class="brand-icon"><svg viewBox="0 0 32 32" fill="none" style="width:25px;height:25px">
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
            <a href="{{ route('bencana.index') }}">
                <span>⚠</span> Bencana
            </a>
            <a class="active" href="{{ route('tips.index') }}">
                <span class="nav-icon">♡</span>
                <span class="nav-label">Tips &amp; darurat</span>
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
        <header class="page-heading">
            <h1>Tips keselamatan &amp; nomor darurat</h1>
            <p>Langkah sederhana saat terjadi bencana alam.</p>
        </header>

        <div class="content">
            <section class="tips-grid" aria-label="Tips keselamatan">
                @forelse ($tips as $index => $tip)
                    <article class="tip-card">
                        <span class="tip-number">{{ $index + 1 }}</span>
                        <div>
                            @if ($tip->category)
                                <small>{{ $tip->category }} · {{ $tip->phase }}</small>
                            @endif
                            <h2>{{ $tip->title }}</h2>
                            <p>{{ $tip->content }}</p>
                        </div>
                    </article>
                @empty
                    <div class="tips-empty">
                        Belum ada tips keselamatan di database. Konten akan tampil setelah data mitigasi ditambahkan.
                    </div>
                @endforelse
            </section>

            <aside class="contact-column" aria-label="Kontak darurat">
                <a class="call-112" href="tel:112">
                    <span>
                        <span>Keadaan darurat?</span>
                        <strong>112</strong>
                        <small>Layanan darurat terpadu</small>
                    </span>
                    <span class="call-icon" aria-hidden="true">
            <svg viewBox="0 0 24 24" fill="none">
                <path
                    d="M7.2 3.8h2.4l1.2 4.1-1.8 1.7a14 14 0 0 0 5.4 5.4l1.7-1.8 4.1 1.2v2.4c0 1.3-1 2.3-2.3 2.3A15.9 15.9 0 0 1 4.9 6.1c0-1.3 1-2.3 2.3-2.3Z"
                    stroke="currentColor"
                    stroke-width="1.7"
                    stroke-linecap="round"
                    stroke-linejoin="round"
                />
            </svg>
            </span>
                </a>

                <div class="contacts">
                    @forelse ($contacts as $contact)
                        @php $telephone = preg_replace('/[^0-9+]/', '', $contact->phone); @endphp
                        <a class="contact" href="tel:{{ $telephone }}">
                            <span>
                                <span class="contact-name">{{ $contact->agency ?: $contact->name }}</span>
                                <span class="contact-description">{{ $contact->description ?: $contact->name }}</span>
                            </span>
                            <span class="contact-number">{{ $contact->phone }}</span>
                        </a>
                    @empty
                        <p class="contacts-empty">Belum ada kontak darurat tambahan di database.</p>
                    @endforelse
                </div>

                <p class="notice">
                    Ketersediaan layanan dapat berbeda menurut wilayah. Jika nomor 112
                    tidak tersambung, coba hubungi instansi terkait secara langsung.
                </p>
            </aside>
        </div>
    </main>
</div>
</body>
</html>