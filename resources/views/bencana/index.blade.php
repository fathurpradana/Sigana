<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Informasi Bencana | SIGANA</title>

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

        .emergency-card strong {
            font-size: 20px;
        }

        .main {
            min-width: 0;
            padding: 25px clamp(18px, 3vw, 42px);
        }

        .header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 16px;
            margin-bottom: 22px;
        }

        .header h1 {
            margin: 0;
            font-size: clamp(22px, 2.5vw, 30px);
        }

.sidebar-bottom {
            margin-top: auto;
        }

        .search {
            width: min(280px, 40%);
            height: 42px;
            display: flex;
            align-items: center;
            gap: 8px;
            padding: 0 13px;
            border: 1px solid var(--line);
            border-radius: 24px;
            background: white;
        }

        .search input {
            width: 100%;
            border: 0;
            outline: 0;
            background: transparent;
            color: var(--text);
            font-size: 12px;
        }

        .filters {
            display: flex;
            gap: 8px;
            overflow-x: auto;
            margin-bottom: 17px;
            padding-bottom: 3px;
        }

        .filter-button {
            min-height: 36px;
            padding: 0 17px;
            border: 1px solid #e1e5e2;
            border-radius: 22px;
            background: white;
            color: var(--text);
            font-size: 12px;
            white-space: nowrap;
            cursor: pointer;
        }

        .filter-button:hover,
        .filter-button.active {
            border-color: var(--teal);
            background: var(--teal);
            color: white;
        }

        .cards {
            display: grid;
            grid-template-columns: repeat(3, minmax(0, 1fr));
            gap: 15px;
        }

        .card {
            overflow: hidden;
            border: 1px solid var(--line);
            border-radius: 15px;
            background: white;
        }

        .scene {
            height: 175px;
            display: grid;
            place-items: center;
            overflow: hidden;
            position: relative;
            font-size: 56px;
        }

        .scene::after {
            position: absolute;
            inset: 0;
            background: linear-gradient(transparent 50%, rgba(0,0,0,.12));
            content: "";
        }

        .scene-volcano {
            background:
                radial-gradient(ellipse at 52% 75%, #ffb347 0 7%, transparent 8%),
                radial-gradient(ellipse at 50% 82%, #263239 0 23%, transparent 24%),
                linear-gradient(180deg, #46545a, #d4865d 60%, #263239);
        }

        .scene-earthquake {
            background:
                linear-gradient(145deg, transparent 40%, #aeb6b3 41% 55%, transparent 56%),
                linear-gradient(35deg, #ded8c9 0 35%, #8d9b96 36% 58%, #c1c9bd 59%);
        }

        .scene-flood {
            background:
                linear-gradient(180deg, #93b98e 0 38%, #658f73 39% 48%, #669cb0 49% 100%);
        }

        .scene-tsunami {
            background:
                radial-gradient(ellipse at 55% 100%, #367d99 0 35%, transparent 36%),
                linear-gradient(180deg, #9dc9d2, #5598ae);
        }

        .scene img { width: 100%; height: 100%; object-fit: cover; }

        .scene-emoji {
            position: relative;
            z-index: 1;
            filter: drop-shadow(0 3px 5px rgba(0, 0, 0, .3));
        }

        .card-body { padding: 12px 13px 15px; }

        .card-meta {
            display: flex;
            align-items: center;
            gap: 8px;
            margin-bottom: 8px;
            color: var(--muted);
            font-size: 10px;
        }

        .tag {
            padding: 4px 8px;
            border-radius: 20px;
            background: #fff0e9;
            color: #b7472e;
            font-size: 9px;
            font-weight: bold;
        }

        .tag.gempa { background: #fff4df; color: #a66b1a; }
        .tag.banjir { background: #e9f5f8; color: #28738a; }
        .tag.tsunami { background: #e8f0ff; color: #4168a0; }

        .card h2 {
            margin: 0 0 7px;
            font-size: 14px;
            line-height: 1.4;
        }

        .card p {
            margin: 0;
            color: #718080;
            font-size: 11px;
            line-height: 1.5;
        }

        .empty-state {
            display: none;
            grid-column: 1 / -1;
            padding: 40px 20px;
            border: 1px dashed #ccd6d2;
            border-radius: 14px;
            color: var(--muted);
            text-align: center;
            font-size: 14px;
        }

        @media (max-width: 900px) {
            .cards { grid-template-columns: repeat(2, minmax(0, 1fr)); }
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
                padding: 0 10px;
            }

            .emergency, .account-link { display: none; }

            .main { padding: 20px 14px; }

            .header {
                align-items: flex-start;
                flex-direction: column;
            }

            .search { width: 100%; }

            .cards { grid-template-columns: 1fr; }

            .scene { height: 200px; }
        }
        .card {
    display: block;
    color: inherit;
    text-decoration: none;
    transition: transform .15s ease, box-shadow .15s ease;
}

.card:hover {
    transform: translateY(-3px);
    box-shadow: 0 8px 22px rgb(20 45 50 / 10%);
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

.logout-form {
    width: 100%;
    margin: 0;
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
        <header class="header">
            <h1>Informasi bencana</h1>

            <label class="search">
                <span aria-hidden="true">⌕</span>
                <input id="searchInput" type="search"
                       placeholder="Cari kejadian atau wilayah" value="{{ request('q') }}">
            </label>
        </header>

        <nav class="filters" aria-label="Filter kategori bencana">
            <button class="filter-button active" type="button" data-filter="semua">Semua</button>
            @foreach ($categories as $category)
                <button class="filter-button" type="button" data-filter="{{ \Illuminate\Support\Str::lower($category->name) }}">
                    {{ $category->name }}
                </button>
            @endforeach
        </nav>

        <section class="cards" id="disasterCards">
            @forelse ($disasters as $disaster)
                @php
                    $categoryName = \Illuminate\Support\Str::lower($disaster->category);
                    $sceneClass = str_contains($categoryName, 'gempa') ? 'scene-earthquake' : (str_contains($categoryName, 'banjir') ? 'scene-flood' : (str_contains($categoryName, 'tsunami') ? 'scene-tsunami' : 'scene-volcano'));
                    $sceneEmoji = str_contains($categoryName, 'gempa') ? '🏚️' : (str_contains($categoryName, 'banjir') || str_contains($categoryName, 'tsunami') ? '🌊' : '🌋');
                    $imageUrl = $disaster->photo ? (\Illuminate\Support\Str::startsWith($disaster->photo, ['http://', 'https://', '/']) ? $disaster->photo : asset('storage/' . $disaster->photo)) : null;
                @endphp
                <a class="card"
                   href="{{ route('bencana.detail', $disaster->id) }}"
                   data-category="{{ $categoryName }}"
                   data-search="{{ \Illuminate\Support\Str::lower($disaster->title . ' ' . $disaster->location . ' ' . $disaster->category) }}">
                    <div class="scene {{ $sceneClass }}" role="img" aria-label="{{ $disaster->category }}">
                        @if ($imageUrl)
                            <img src="{{ $imageUrl }}" alt="{{ $disaster->title }}">
                        @else
                            <span class="scene-emoji">{{ $sceneEmoji }}</span>
                        @endif
                    </div>
                    <div class="card-body">
                        <div class="card-meta">
                            <span class="tag">{{ $disaster->category }}</span>
                            <time>{{ \Illuminate\Support\Carbon::parse($disaster->occurred_at, 'UTC')->setTimezone('Asia/Jakarta')->locale('id')->translatedFormat('j M Y · H.i') }} WIB</time>
                        </div>
                        <h2>{{ $disaster->title }}</h2>
                        <p>{{ \Illuminate\Support\Str::limit($disaster->description ?: $disaster->location, 150) }}</p>
                    </div>
                </a>
            @empty
                <div class="empty-state" id="emptyState" style="display:block">
                    Belum ada data kejadian bencana. Informasi akan tampil di sini setelah data ditambahkan.
                </div>
            @endforelse

            @if ($disasters->isNotEmpty())
                <div class="empty-state" id="emptyState">
                    Tidak ada informasi bencana yang cocok dengan pencarian.
                </div>
            @endif
        </section>
    </main>
</div>

<script>
    const filterButtons = document.querySelectorAll('.filter-button');
    const cards = document.querySelectorAll('.card');
    const searchInput = document.getElementById('searchInput');
    const emptyState = document.getElementById('emptyState');

    let activeFilter = 'semua';

    function filterCards() {
        const searchText = searchInput.value.trim().toLowerCase();
        let visibleCount = 0;

        cards.forEach(function (card) {
            const category = card.dataset.category;
            const searchableText = (
                card.dataset.search + ' ' + card.textContent
            ).toLowerCase();

            const matchesCategory =
                activeFilter === 'semua' || category === activeFilter;
            const matchesSearch = searchableText.includes(searchText);
            const visible = matchesCategory && matchesSearch;

            card.style.display = visible ? '' : 'none';

            if (visible) visibleCount++;
        });

        emptyState.style.display = visibleCount === 0 ? 'block' : 'none';
    }

    filterButtons.forEach(function (button) {
        button.addEventListener('click', function () {
            filterButtons.forEach(item => item.classList.remove('active'));
            button.classList.add('active');
            activeFilter = button.dataset.filter;
            filterCards();
        });
    });

    searchInput.addEventListener('input', filterCards);
</script>
</body>
</html>