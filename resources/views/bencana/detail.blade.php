<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $disaster->title }} | SIGANA</title>

    <style>
        * { box-sizing: border-box; }

        :root {
            --teal: #105361;
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

        .nav a:hover, .nav a.active {
            background: rgba(255, 255, 255, .17);
            color: white;
        }

        .emergency-card {
    display: flex;
    flex-direction: column;
    align-items: flex-start;
    width: 100%;
    box-sizing: border-box;
    padding: 14px;
    border-radius: 12px;
    background: rgba(255, 255, 255, .13);
}

        .emergency-card span {
    display: block;
    margin: 0 0 5px;
    color: #d0e3e5;
    font-size: 11px;
}

.emergency-card strong {
    display: block;
    font-size: 20px;
}

.sidebar-bottom {
    margin-top: auto;
}

        .main { min-width: 0; padding: 26px; }

        .detail-card {
            width: min(100%, 1000px);
            margin: 0 auto;
            padding: 20px;
            border: 1px solid var(--line);
            border-radius: 17px;
            background: white;
        }

        .hero {
    height: clamp(220px, 32vw, 340px);
    display: grid;
    place-items: center;
    overflow: hidden;
    border-radius: 12px;
    background: #263b40;
}

.hero img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    object-position: center 42%;
}
        .detail-content { max-width: 860px; margin: 0 auto; padding: 20px 12px 6px; }

        .status {
            display: inline-block;
            padding: 5px 9px;
            border-radius: 20px;
            background: #fff0e9;
            color: #aa492f;
            font-size: 10px;
            font-weight: bold;
        }

        h1 {
            margin: 14px 0;
            color: #172d32;
            font-size: clamp(22px, 2.5vw, 32px);
            line-height: 1.25;
            text-align: left;
        }

        .meta {
            display: flex;
            flex-wrap: wrap;
            gap: 8px;
            margin: 0 0 20px;
            color: var(--muted);
            font-size: 12px;
        }
        .meta-item {
            display: inline-flex;
            align-items: center;
            min-height: 34px;
            padding: 7px 10px;
            border: 1px solid var(--line);
            border-radius: 9px;
            background: #f7f8f6;
        }

        .description {
            margin: 0 0 28px;
            color: #526365;
            font-size: 14px;
            line-height: 1.8;
        }

        .advice {
            padding: 17px;
            border: 1px solid var(--line);
            border-radius: 13px;
        }

        .advice h2 {
            margin: 0 0 12px;
            color: #647475;
            font-size: 11px;
            font-weight: normal;
            text-transform: uppercase;
        }

        .advice ul {
            display: grid;
            gap: 10px;
            margin: 0;
            padding: 0;
            list-style: none;
        }

        .advice li {
            display: flex;
            gap: 9px;
            color: #526365;
            font-size: 12px;
            line-height: 1.5;
        }

        .check {
            color: var(--teal);
            font-weight: bold;
        }

        .emergency-button {
            display: block;
            margin-top: 16px;
            padding: 12px;
            border: 1px solid #e45a46;
            border-radius: 24px;
            color: #c94a37;
            font-size: 12px;
            text-align: center;
            text-decoration: none;
        }

        .back-link {
            display: inline-block;
            margin: 0 0 14px 2px;
            color: var(--teal);
            font-size: 13px;
            text-decoration: none;
        }

        @media (max-width: 650px) {
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
            }

            .emergency { display: none; }

            .main { padding: 14px; }
            .detail-card { padding: 10px; }
            .hero { height: 220px; }
            .detail-content { padding: 14px 4px 4px; }
            h1 { font-size: 22px; }
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
    <link rel="stylesheet" href="{{ asset('css/sigana-theme.css') }}?v=7">
    <script src="{{ asset('js/sigana-theme.js') }}?v=4" defer></script>
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
            <a class="active" href="{{ route('bencana.index') }}">
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
        <a class="back-link" href="{{ route('bencana.index') }}">← Kembali ke informasi bencana</a>

        @php
            $imageUrl = $disaster->photo ? (\Illuminate\Support\Str::startsWith($disaster->photo, ['http://', 'https://', '/']) ? $disaster->photo : asset('storage/' . $disaster->photo)) : null;
            $categoryName = \Illuminate\Support\Str::lower($disaster->category);
            $sceneEmoji = str_contains($categoryName, 'gempa') ? '🏚️' : (str_contains($categoryName, 'banjir') || str_contains($categoryName, 'tsunami') ? '🌊' : '🌋');
        @endphp
        <article class="detail-card">
            <div class="hero" role="img" aria-label="{{ $disaster->category }}">
                @if ($imageUrl)
                    <img src="{{ $imageUrl }}" alt="{{ $disaster->title }}">
                @else
                    {{ $sceneEmoji }}
                @endif
            </div>

            <div class="detail-content">
                <span class="status">{{ $disaster->category }} · {{ $disaster->status }}</span>

                <h1>{{ $disaster->title }}</h1>

                <div class="meta">
                    <span class="meta-item">Diunggah {{ $disaster->created_at ? \Illuminate\Support\Carbon::parse($disaster->created_at, 'UTC')->setTimezone('Asia/Jakarta')->locale('id')->translatedFormat('j M Y · H.i') . ' WIB' : '—' }}</span>
                    <span class="meta-item">Kejadian {{ $disaster->occurred_at ? \Illuminate\Support\Carbon::parse($disaster->occurred_at, 'UTC')->setTimezone('Asia/Jakarta')->locale('id')->translatedFormat('j M Y · H.i') . ' WIB' : 'Waktu tidak tersedia' }}</span>
                    <span class="meta-item">{{ $disaster->location }}</span>
                </div>

                <p class="description">{{ $disaster->description ?: 'Belum ada keterangan untuk kejadian ini.' }}</p>

                <section class="advice">
                    <h2>Imbauan keselamatan</h2>
                    @if ($mitigations->isNotEmpty())
                        <ul>
                            @foreach ($mitigations as $mitigation)
                                <li>
                                    <span class="check">✓</span>
                                    <span><strong>{{ $mitigation->title }}</strong>@if ($mitigation->content) — {{ $mitigation->content }}@endif</span>
                                </li>
                            @endforeach
                        </ul>
                    @else
                        <p>Belum ada imbauan khusus yang tersimpan untuk kategori {{ $disaster->category }}.</p>
                    @endif
                </section>

                <a class="emergency-button" href="tel:112">
                    Nomor darurat · 112
                </a>
            </div>
        </article>
    </main>
</div>
</body>
</html>