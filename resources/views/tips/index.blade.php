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

.category-grid {
    display: grid;
    grid-template-columns: repeat(2, minmax(0, 1fr));
    gap: 14px;
}

.category-card {
    min-height: 150px;
    display: flex;
    flex-direction: column;
    align-items: flex-start;
    gap: 10px;
    padding: 18px;
    border: 1px solid var(--line);
    border-radius: 14px;
    background: white;
    color: var(--text);
    text-align: left;
    cursor: pointer;
}

.category-card:hover {
    border-color: var(--teal);
    transform: translateY(-2px);
}

.category-count,
.category-card > span:not(.category-link) {
    color: var(--muted);
    font-size: 11px;
    line-height: 1.5;
}

.category-card strong {
    font-size: 16px;
}

.category-link {
    margin-top: auto;
    color: var(--teal);
    font-size: 12px;
    font-weight: bold;
}

.tip-detail > h2 {
    margin: 16px 0 12px;
    font-size: 20px;
}

.back-to-categories {
    padding: 0;
    border: 0;
    background: transparent;
    color: var(--teal);
    font: inherit;
    font-size: 12px;
    cursor: pointer;
}

.phase-filters {
    display: flex;
    flex-wrap: wrap;
    gap: 8px;
    margin-bottom: 14px;
}

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

.phase-filter.active {
    border-color: var(--teal);
    background: var(--teal);
    color: white;
}

.tip-card small {
    color: var(--teal);
    font-size: 11px;
    font-weight: bold;
}

.tip-card[hidden] {
    display: none;
}

@media (max-width: 680px) {
    .category-grid {
        grid-template-columns: 1fr;
    }
}

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
            @php
    $tipsByCategory = $tips->groupBy(fn ($tip) => $tip->category ?: 'Panduan umum');
@endphp

<div class="tips-area">
    <div class="category-grid" id="tipsOverview">
        @forelse ($tipsByCategory as $category => $categoryTips)
            <button class="category-card" type="button" data-category="{{ $category }}">
                <span class="category-count">{{ $categoryTips->count() }} panduan</span>
                <strong>{{ $category }}</strong>
                <span>Langkah keselamatan sebelum, saat, dan sesudah bencana.</span>
                <span class="category-link">Lihat panduan <b>→</b></span>
            </button>
        @empty
            <div class="tips-empty">
                Belum ada tips keselamatan di database.
            </div>
        @endforelse
    </div>

    <section class="tip-detail" id="tipDetail" hidden>
        <button class="back-to-categories" id="backToCategories" type="button">
            ← Kembali ke jenis bencana
        </button>

        <h2 id="selectedCategory"></h2>

        <div class="phase-filters" aria-label="Pilih tahap panduan">
            <button class="phase-filter active" type="button" data-phase="semua">Semua</button>
            <button class="phase-filter" type="button" data-phase="sebelum">Sebelum</button>
            <button class="phase-filter" type="button" data-phase="saat">Saat</button>
            <button class="phase-filter" type="button" data-phase="sesudah">Sesudah</button>
        </div>

        <div class="tips-grid" id="tipCards">
            @foreach ($tips as $tip)
                @php $tipCategory = $tip->category ?: 'Panduan umum'; @endphp

                <article class="tip-card"
                         data-category="{{ $tipCategory }}"
                         data-phase="{{ Illuminate\Support\Str::lower($tip->phase) }}">
                    <div>
                        <small>{{ $tip->phase }}</small>
                        <h2>{{ $tip->title }}</h2>
                        <p>{{ $tip->content }}</p>
                    </div>
                </article>
            @endforeach
        </div>
    </section>
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
    const overview = document.getElementById('tipsOverview');
    const detail = document.getElementById('tipDetail');
    const categoryTitle = document.getElementById('selectedCategory');
    const tipCards = [...document.querySelectorAll('.tip-card')];
    let selectedCategory = '';
    let selectedPhase = 'semua';

    function filterTips() {
        tipCards.forEach((card) => {
            const categoryMatches = card.dataset.category === selectedCategory;
            const phaseMatches =
                selectedPhase === 'semua' || card.dataset.phase === selectedPhase;

            card.hidden = !(categoryMatches && phaseMatches);
        });
    }

    overview?.addEventListener('click', (event) => {
        const button = event.target.closest('.category-card');
        if (!button) return;

        selectedCategory = button.dataset.category;
        selectedPhase = 'semua';
        categoryTitle.textContent = selectedCategory;
        overview.hidden = true;
        detail.hidden = false;

        document.querySelectorAll('.phase-filter').forEach((filter) => {
            filter.classList.toggle(filter.dataset.phase === 'semua' ? 'active' : 'inactive',
                filter.dataset.phase === 'semua');
        });

        filterTips();
    });

    document.getElementById('backToCategories')?.addEventListener('click', () => {
        detail.hidden = true;
        overview.hidden = false;
    });

    document.querySelectorAll('.phase-filter').forEach((button) => {
        button.addEventListener('click', () => {
            selectedPhase = button.dataset.phase;

            document.querySelectorAll('.phase-filter').forEach((filter) => {
                filter.classList.toggle('active', filter === button);
            });

            filterTips();
        });
    });
</script>
</body>
</html>