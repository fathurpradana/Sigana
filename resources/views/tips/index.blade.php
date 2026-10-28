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
            grid-template-columns: minmax(0, 1.6fr) minmax(280px, .8fr);
            align-items: start;
            gap: 20px;
        }

        .tips-grid {
            display: grid;
            grid-template-columns: repeat(2, minmax(0, 1fr));
            align-content: start;
            gap: 14px;
        }

.sidebar-bottom {
            margin-top: auto;
        }

        .tips-empty, .contacts-empty { padding: 22px; color: var(--muted); text-align: center; }

        .tip-card {
            min-height: 126px;
            display: flex;
            align-items: flex-start;
            gap: 13px;
            padding: 17px;
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

        .tip-card:nth-child(6) .tip-number {
            background: var(--teal);
        }

        .tip-card small {
            display: inline-block;
            margin: 0 0 6px;
            color: var(--muted);
            font-size: 10px;
        }

        .tip-card h2 {
            margin: 1px 0 6px;
            font-size: 13px;
            line-height: 1.4;
        }

        .tip-card p {
            margin: 0;
            color: #738181;
            font-size: 11px;
            line-height: 1.55;
        }

        .contact-column {
            display: grid;
            align-content: start;
            gap: 12px;
        }

        .contacts-heading {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin: 2px 0 8px;
        }

        .contacts-heading h2 {
            margin: 0;
            font-size: 14px;
        }

        .contacts-heading span {
            color: var(--muted);
            font-size: 11px;
        }

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
            max-height: 420px;
            overflow-y: auto;
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

.tips-area {
    min-width: 0;
}

.tips-toolbar {
    margin-bottom: 14px;
    padding: 16px;
    border: 1px solid var(--line);
    border-radius: 14px;
    background: white;
}
.tips-toolbar h2 { margin: 0; font-size: 15px; }
.tips-toolbar p { margin: 5px 0 13px; color: var(--muted); font-size: 12px; }
.filter-label { display: block; margin: 12px 0 7px; font-size: 11px; font-weight: bold; }
.phase-filters { display: flex; flex-wrap: wrap; gap: 8px; }
.phase-filter {
    padding: 8px 13px;
    border: 1px solid var(--line);
    border-radius: 20px;
    background: white;
    color: var(--text);
    font: inherit;
    font-size: 11px;
    cursor: pointer;
}
.phase-filter:hover { border-color: var(--teal); }
.phase-filter.active { border-color: var(--teal); background: var(--teal); color: white; }
.tips-toolbar .notice { margin-top: 12px; }
.tip-card small { color: var(--teal); font-size: 10px; font-weight: bold; }
.tip-card[hidden] { display: none; }
.tips-no-results { grid-column: 1 / -1; margin: 0; padding: 18px; border: 1px dashed var(--line); border-radius: 12px; color: var(--muted); text-align: center; }
html[data-theme="dark"] .tips-toolbar,
html[data-theme="dark"] .contacts { background: var(--sigana-surface) !important; border-color: var(--sigana-line) !important; }
html[data-theme="dark"] .phase-filter { background: var(--sigana-surface-soft); border-color: var(--sigana-line); color: var(--sigana-text); }
html[data-theme="dark"] .phase-filter.active { background: var(--teal); border-color: var(--teal); color: #fff; }
html[data-theme="dark"] .contact { border-color: var(--sigana-line); }
html[data-theme="dark"] .contact:hover { background: var(--sigana-surface-soft); }
html[data-theme="dark"] .tip-category { background: #263d42; color: #a9e1e5; }
.tips-grid .tip-card { min-height: 0; padding: 16px; }
.tip-card h2 { font-size: 14px; }
.tip-card p { font-size: 12px; }
.tip-card img { display: block; width: 100%; height: 150px; object-fit: cover; border-radius: 10px; margin-bottom: 12px; }
.tip-category { display: inline-flex; margin: 0 0 7px; padding: 4px 8px; border-radius: 20px; background: #e8f2f3; color: var(--teal); font-size: 10px; font-weight: bold; }
        @media (max-width: 900px) {
            .content {
                grid-template-columns: 1fr;
            }

            .contact-column {
                grid-template-columns: 1fr;
            }

            .call-112,
            .notice {
                grid-column: auto;
            }
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
            @php $tipCategories = $tips->pluck('category')->filter()->unique()->values(); @endphp
            <div class="tips-area">
                <section class="tips-toolbar" aria-label="Filter panduan keselamatan">
                    <h2>Pilih panduan yang dibutuhkan</h2>
                    <p>Gunakan filter jenis bencana atau tahap untuk menemukan langkah yang relevan.</p>
                    <span class="filter-label">Jenis bencana</span>
                    <div class="phase-filters" id="categoryFilters">
                        <button class="phase-filter active" type="button" data-category="semua">Semua</button>
                        @foreach ($tipCategories as $category)
                            <button class="phase-filter" type="button" data-category="{{ $category }}">{{ $category }}</button>
                        @endforeach
                    </div>
                    <span class="filter-label">Tahap kejadian</span>
                    <div class="phase-filters" aria-label="Pilih tahap panduan">
                        <button class="phase-filter active" type="button" data-phase="semua">Semua tahap</button>
                        <button class="phase-filter" type="button" data-phase="sebelum">Sebelum</button>
                        <button class="phase-filter" type="button" data-phase="saat">Saat</button>
                        <button class="phase-filter" type="button" data-phase="sesudah">Sesudah</button>
                    </div>
                    <p class="notice" id="tipsResultCount" aria-live="polite"></p>
                </section>

                <div class="tips-grid" id="tipCards">
                    @forelse ($tips as $tip)
                        @php $tipCategory = $tip->category ?: 'Panduan umum'; @endphp
                        <article class="tip-card" data-category="{{ $tipCategory }}" data-phase="{{ Illuminate\Support\Str::lower(trim($tip->phase ?? '')) }}">
                            <div>
                                @if ($tip->image)
                                    <img src="{{ \Illuminate\Support\Str::startsWith($tip->image, ['http://', 'https://', '/']) ? $tip->image : asset('storage/' . $tip->image) }}" alt="Ilustrasi {{ $tip->title }}" loading="lazy">
                                @endif
                                <span class="tip-category">{{ $tipCategory }}</span>
                                <small>{{ $tip->phase ?: 'Panduan umum' }}</small>
                                <h2>{{ $tip->title }}</h2>
                                <p>{{ $tip->content }}</p>
                            </div>
                        </article>
                    @empty
                        <div class="tips-empty">Belum ada tips keselamatan di database.</div>
                    @endforelse
                </div>
            </div>
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

                <div>
                    <div class="contacts-heading">
                        <h2>Kontak darurat lainnya</h2>
                        <span>{{ $contacts->count() }} kontak</span>
                    </div>

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
                </div>

                <p class="notice">
                    Ketersediaan layanan dapat berbeda menurut wilayah. Jika nomor 112
                    tidak tersambung, coba hubungi instansi terkait secara langsung.
                </p>
            </aside>
        </div>
    </main>
</div>

<script>
    const tipCards = [...document.querySelectorAll('.tip-card')];
    const resultCount = document.getElementById('tipsResultCount');
    const noResults = document.createElement('p');
    noResults.className = 'tips-no-results';
    noResults.textContent = 'Tidak ada panduan untuk filter ini. Coba pilih jenis atau tahap lain.';
    noResults.hidden = true;
    document.getElementById('tipCards')?.append(noResults);
    let selectedCategory = 'semua';
    let selectedPhase = 'semua';

    function filterTips() {
        let visibleCount = 0;
        tipCards.forEach((card) => {
            const categoryMatches = selectedCategory === 'semua' || card.dataset.category === selectedCategory;
            const phaseMatches = selectedPhase === 'semua' || card.dataset.phase.includes(selectedPhase);
            card.hidden = !(categoryMatches && phaseMatches);
            if (!card.hidden) visibleCount++;
        });
        if (resultCount) resultCount.textContent = `${visibleCount} panduan ditampilkan`;
        noResults.hidden = visibleCount !== 0;
    }

    document.querySelectorAll('#categoryFilters [data-category]').forEach((button) => {
        button.addEventListener('click', () => {
            selectedCategory = button.dataset.category;
            document.querySelectorAll('#categoryFilters [data-category]').forEach((item) => item.classList.toggle('active', item === button));
            filterTips();
        });
    });

    document.querySelectorAll('.phase-filters [data-phase]').forEach((button) => {
        button.addEventListener('click', () => {
            selectedPhase = button.dataset.phase;
            document.querySelectorAll('.phase-filters [data-phase]').forEach((item) => item.classList.toggle('active', item === button));
            filterTips();
        });
    });

    filterTips();
</script>
</body>
</html>