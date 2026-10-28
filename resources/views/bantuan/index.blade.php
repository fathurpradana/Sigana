<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bantuan | SIGANA</title>

    <style>
        * { box-sizing: border-box; }

        :root {
            --teal: #105361;
            --teal-dark: #0d4652;
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
            padding: 25px clamp(18px, 3vw, 42px);
        }

        .main h1 {
            margin: 0 0 20px;
            font-size: clamp(22px, 2.5vw, 30px);
        }

.report-page-body .chat-card {
    display: none;
}

.report-page-body .help-layout {
    grid-template-columns: minmax(0, 760px);
}

.report-card > a:first-child {
    display: inline-block;
    margin-bottom: 14px;
    color: var(--teal);
    font-size: 12px;
    text-decoration: none;
}

a.report-submit {
    padding: 0 12px;
}

        .help-layout {
            display: grid;
            grid-template-columns: minmax(0, 1fr) 300px;
            gap: 14px;
            align-items: start;
        }

        .chat-card,
        .report-card {
            overflow: hidden;
            border: 1px solid var(--line);
            border-radius: 15px;
            background: white;
        }

        .chat-card {
            min-height: 540px;
            display: flex;
            flex-direction: column;
        }

        .chat-header {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 13px 15px;
            border-bottom: 1px solid var(--line);
        }

        .assistant-icon {
            width: 34px;
            height: 34px;
            display: grid;
            place-items: center;
            border-radius: 50%;
            background: #e6f1f2;
            color: var(--teal);
        }

        .assistant-name { font-size: 12px; font-weight: bold; }

        .online {
            margin-top: 3px;
            color: #438662;
            font-size: 10px;
        }

        .online::before {
            display: inline-block;
            width: 6px;
            height: 6px;
            margin-right: 5px;
            border-radius: 50%;
            background: #39875c;
            content: "";
        }

        .chat-messages {
            min-height: 0;
            flex: 1;
            display: flex;
            flex-direction: column;
            gap: 10px;
            overflow-y: auto;
            padding: 15px;
            background: #f8faf8;
        }

        .bubble {
            max-width: 82%;
            padding: 11px 13px;
            border: 1px solid var(--line);
            border-radius: 13px;
            background: white;
            color: #415456;
            font-size: 11px;
            line-height: 1.5;
        }

        .bubble.user {
            align-self: flex-end;
            border-color: var(--teal);
            background: var(--teal);
            color: white;
        }

        .chat-form {
            display: flex;
            gap: 8px;
            padding: 10px 14px;
            border-top: 1px solid var(--line);
        }

        .chat-form input {
            min-width: 0;
            height: 42px;
            flex: 1;
            padding: 0 14px;
            border: 1px solid var(--line);
            border-radius: 24px;
            outline: 0;
            background: var(--page);
            font-size: 12px;
        }

        .chat-form input:focus { border-color: var(--teal); }

        .send-button {
            width: 42px;
            height: 42px;
            border: 0;
            border-radius: 50%;
            background: var(--teal);
            color: white;
            font-size: 18px;
            cursor: pointer;
        }

        .report-card { padding: 16px; }

.sidebar-bottom {
            margin-top: auto;
        }

        .report-card h2 {
            margin: 0 0 7px;
            font-size: 15px;
        }

        .report-intro {
            margin: 0 0 15px;
            color: var(--muted);
            font-size: 11px;
            line-height: 1.5;
        }

        .report-label {
            display: block;
            margin: 12px 0 7px;
            font-size: 11px;
            font-weight: bold;
        }

        .category-options {
            display: flex;
            flex-wrap: wrap;
            gap: 6px;
        }

        .category-button {
            padding: 8px 11px;
            border: 1px solid var(--line);
            border-radius: 20px;
            background: white;
            color: var(--text);
            font-size: 10px;
            cursor: pointer;
        }

        .category-button.selected {
            border-color: var(--teal);
            background: var(--teal);
            color: white;
        }

        .report-card input,
        .report-card textarea {
            width: 100%;
            padding: 11px;
            border: 1px solid var(--line);
            border-radius: 10px;
            outline: 0;
            background: var(--page);
            color: var(--text);
            font: inherit;
            font-size: 11px;
        }

        .report-card input:focus,
        .report-card textarea:focus {
            border-color: var(--teal);
        }

        .report-card textarea {
            min-height: 92px;
            resize: vertical;
        }
        .photo-preview-wrap { display: none; margin-top: 10px; }
        .photo-preview-wrap.visible { display: block; }
        .photo-preview { width: 100%; aspect-ratio: 16 / 5; overflow: hidden; border: 1px solid var(--line); border-radius: 10px; background: #e8eeee; }
        .photo-preview img { width: 100%; height: 100%; display: block; object-fit: cover; }
        .photo-adjustment { display: grid; gap: 8px; margin-top: 10px; color: var(--muted); font-size: 10px; }
        .photo-adjustment label { display: grid; gap: 4px; }
        .photo-adjustment input[type="range"] { width: 100%; accent-color: var(--teal); }
        .report-submit,
        .emergency-button {
            width: 100%;
            min-height: 42px;
            display: grid;
            place-items: center;
            margin-top: 10px;
            border-radius: 24px;
            font-size: 11px;
            font-weight: bold;
            text-decoration: none;
            cursor: pointer;
        }

        .report-submit {
            border: 0;
            background: var(--teal);
            color: white;
        }

        .emergency-button {
            border: 1px solid var(--orange);
            background: white;
            color: var(--orange);
        }

        .form-note {
            display: none;
            margin: 10px 0 0;
            color: #9a4b28;
            font-size: 10px;
            line-height: 1.5;
        }

        .form-note.visible { display: block; }

        @media (max-width: 900px) {
            .help-layout { grid-template-columns: 1fr; }
            .chat-card { min-height: 430px; }
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
            .chat-card { min-height: 420px; }
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

<body class="{{ ($page ?? 'help') === 'report' ? 'report-page-body' : '' }}">
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
            <a href="{{ route('bencana.index') }}"><span>⚠</span> Bencana</a>
            <a href="{{ route('tips.index') }}"><span>♡</span> Tips &amp; darurat</a>
            <a class="active" href="{{ route('bantuan.index') }}"><span>◌</span> Bantuan</a>
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
    </aside>

    <main class="main">
        <h1>{{ ($page ?? 'help') === 'report' ? 'Lapor bencana' : 'Layanan pelanggan' }}</h1>

        <div class="help-layout">
            <section class="chat-card" aria-label="Chat bantuan SIGANA">
                <header class="chat-header">
                    <div class="assistant-icon" aria-hidden="true">◉</div>
                    <div>
                        <div class="assistant-name">Asisten SIGANA</div>
                        <div class="online">Online</div>
                    </div>
                </header>

                <div class="chat-messages" id="chatMessages" aria-live="polite">
                    <div class="bubble">
                        Halo! Saya asisten SIGANA. Ada yang bisa kami bantu?
                    </div>
                </div>

                <form class="chat-form" id="chatForm">
                    <input id="chatInput" type="text"
                           placeholder="Tulis pesan..."
                           autocomplete="off"
                           aria-label="Tulis pesan">
                    <button class="send-button" type="submit" aria-label="Kirim pesan">→</button>
                </form>
            </section>

            @if (($page ?? 'help') === 'report')

    <aside class="report-card">
        <a href="{{ route('bantuan.index') }}">← Kembali ke Bantuan</a>

        <h2>Lapor bencana</h2>
        <p class="report-intro">
            Bantu petugas dengan informasi yang jelas dan akurat.
        </p>

        <form id="reportForm"
      method="POST"
      action="{{ route('bantuan.report') }}"
      enctype="multipart/form-data">
            @csrf

            @if (session('report_status'))
                <p class="form-note visible">{{ session('report_status') }}</p>
            @endif

            @if ($errors->any())
                <p class="form-note visible">{{ $errors->first() }}</p>
            @endif

            <span class="report-label">Jenis kejadian</span>

            <div class="category-options">
                @forelse ($categories as $index => $category)
                    <button
                        class="category-button {{ $index === 0 ? 'selected' : '' }}"
                        data-category-id="{{ $category->id }}"
                        type="button">
                        {{ $category->name }}
                    </button>
                @empty
                    <p>Kategori bencana belum tersedia.</p>
                @endforelse
            </div>

            <input
                type="hidden"
                name="category_id"
                id="reportCategory"
                value="{{ $categories->first()->id ?? '' }}">

            <label class="report-label" for="reportTitle">Judul laporan</label>
            <input
                id="reportTitle"
                name="title"
                type="text"
                value="{{ old('title') }}"
                placeholder="Contoh: Banjir menggenangi jalan utama"
                maxlength="255"
                required>

            <label class="report-label" for="reportLocation">Lokasi kejadian</label>
            <input
                id="reportLocation"
                name="location"
                type="text"
                value="{{ old('location') }}"
                placeholder="Desa, kecamatan, kota"
                required>

<label class="report-label" for="reportOccurredAt">
    Tanggal dan waktu kejadian
</label>
<input
    id="reportOccurredAt"
    name="occurred_at"
    type="datetime-local"
    value="{{ old('occurred_at') }}"
    required>

<label class="report-label" for="reportDescription">Keterangan</label>
<textarea
    id="reportDescription"
    name="description"
    placeholder="Ceritakan apa yang terjadi"
    required>{{ old('description') }}</textarea>

<label class="report-label" for="reportPhoto">
    Foto kejadian <span>(wajib)</span>
</label>
<input
    id="reportPhoto"
    name="photo"
    type="file"
    accept=".jpg,.jpeg,.png,.webp,image/jpeg,image/png,image/webp"
    required>


<div class="photo-preview-wrap" id="photoPreviewWrap">
    <span class="report-label">Sesuaikan posisi foto</span>
    <div class="photo-preview"><img id="photoPreview" alt="Pratinjau potongan foto kejadian"></div>
    <div class="photo-adjustment">
        <label for="photoPositionX">Geser horizontal
            <input id="photoPositionX" type="range" min="0" max="100" value="50">
        </label>
        <label for="photoPositionY">Geser vertikal
            <input id="photoPositionY" type="range" min="0" max="100" value="50">
        </label>
    </div>
</div>
<p class="form-note visible">
    Format JPG, PNG, atau WebP. Ukuran maksimal 4 MB.
</p>

<button class="report-submit" type="submit">Kirim laporan</button>

<p class="form-note" id="reportNote">
    Laporan akan disimpan dengan status Dilaporkan dan dapat dipantau pada menu Bencana.
</p>
        </form>

        <a class="emergency-button" href="tel:112">
            Hubungi nomor darurat · 112
        </a>
    </aside>

@else

    <aside class="report-card">
        <h2>Lapor bencana</h2>
        <p class="report-intro">
            Bantu petugas dengan informasi yang jelas dan akurat.
        </p>

        <a class="report-submit"
           href="{{ route('bantuan.report.form') }}">
            Buka formulir laporan
        </a>

        <a class="emergency-button" href="tel:112">
            Hubungi nomor darurat · 112
        </a>
    </aside>

@endif
        </div>
    </main>
</div>

<script>
    const chatForm = document.getElementById('chatForm');
    const chatInput = document.getElementById('chatInput');
    const chatMessages = document.getElementById('chatMessages');

    function addBubble(text, type = '') {
        const bubble = document.createElement('div');
        bubble.className = 'bubble' + (type ? ' ' + type : '');
        bubble.textContent = text;
        chatMessages.appendChild(bubble);
        chatMessages.scrollTop = chatMessages.scrollHeight;
    }

    chatForm.addEventListener('submit', function (event) {
        event.preventDefault();

        const message = chatInput.value.trim();
        if (!message) return;

        addBubble(message, 'user');
        chatInput.value = '';

        const lowerMessage = message.toLowerCase();
        let reply;

        if (lowerMessage.includes('bencana') || lowerMessage.includes('kejadian')) {
            reply = 'Buka menu Bencana untuk melihat informasi kejadian dan imbauan keselamatan.';
        } else if (lowerMessage.includes('lapor')) {
            reply = 'Isi jenis kejadian, lokasi, dan keterangan pada form Lapor bencana. Laporan dapat dikirim melalui formulir di halaman ini.';
        } else if (lowerMessage.includes('darurat') || lowerMessage.includes('112')) {
            reply = 'Untuk keadaan darurat, hubungi 112 atau nomor instansi terkait pada halaman Tips & Darurat.';
        } else {
            reply = 'Terima kasih sudah menghubungi SIGANA. Coba tanyakan informasi bencana, cara melapor, atau nomor darurat.';
        }

        window.setTimeout(function () {
            addBubble(reply);
        }, 350);
    });

    document.querySelectorAll('.category-button').forEach(function (button) {
        button.addEventListener('click', function () {
            document.querySelectorAll('.category-button').forEach(function (item) {
                item.classList.remove('selected');
            });

            button.classList.add('selected');
            document.getElementById('reportCategory').value = button.dataset.categoryId;
        });
    });


    const reportForm = document.getElementById('reportForm');
    const photoInput = document.getElementById('reportPhoto');
    const photoPreviewWrap = document.getElementById('photoPreviewWrap');
    const photoPreview = document.getElementById('photoPreview');
    const photoPositionX = document.getElementById('photoPositionX');
    const photoPositionY = document.getElementById('photoPositionY');
    let selectedPhoto = null;

    if (photoInput && reportForm) {
        photoInput.addEventListener('change', function () {
            selectedPhoto = photoInput.files[0] || null;
            photoInput.dataset.cropped = 'false';
            if (!selectedPhoto) {
                photoPreviewWrap.classList.remove('visible');
                photoPreview.removeAttribute('src');
                return;
            }
            photoPreview.src = URL.createObjectURL(selectedPhoto);
            photoPositionX.value = 50;
            photoPositionY.value = 50;
            photoPreview.style.objectPosition = '50% 50%';
            photoPreviewWrap.classList.add('visible');
        });

        function updatePhotoPosition() {
            photoPreview.style.objectPosition = photoPositionX.value + '% ' + photoPositionY.value + '%';
        }
        photoPositionX.addEventListener('input', updatePhotoPosition);
        photoPositionY.addEventListener('input', updatePhotoPosition);

        reportForm.addEventListener('submit', function (event) {
            if (!selectedPhoto || photoInput.dataset.cropped === 'true') return;
            event.preventDefault();
            const image = new Image();
            image.onload = function () {
                const frame = photoPreview.getBoundingClientRect();
                const ratio = frame.width / frame.height;
                let cropWidth = image.width;
                let cropHeight = image.height;
                if (image.width / image.height > ratio) cropWidth = image.height * ratio;
                else cropHeight = image.width / ratio;

                const cropX = (image.width - cropWidth) * (Number(photoPositionX.value) / 100);
                const cropY = (image.height - cropHeight) * (Number(photoPositionY.value) / 100);
                const canvas = document.createElement('canvas');
                canvas.width = 1600;
                canvas.height = Math.round(canvas.width / ratio);
                canvas.getContext('2d').drawImage(image, cropX, cropY, cropWidth, cropHeight, 0, 0, canvas.width, canvas.height);
                canvas.toBlob(function (blob) {
                    if (!blob) { reportForm.submit(); return; }
                    const file = new File([blob], 'foto-kejadian.jpg', { type: 'image/jpeg' });
                    const transfer = new DataTransfer();
                    transfer.items.add(file);
                    photoInput.files = transfer.files;
                    photoInput.dataset.cropped = 'true';
                    reportForm.requestSubmit();
                }, 'image/jpeg', 0.9);
            };
            image.onerror = function () { reportForm.submit(); };
            image.src = URL.createObjectURL(selectedPhoto);
        });
    }
</script>
</body>
</html>