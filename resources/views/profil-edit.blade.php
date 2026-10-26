<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Profil | SIGANA</title>

    <style>
        :root {
            --teal: #105563;
            --page: #f4f5f2;
            --border: #e1e7e5;
            --text: #18313a;
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
            max-width: 850px;
            margin: 0 auto;
        }

        .heading {
            display: flex;
            align-items: center;
            gap: 14px;
            margin-bottom: 16px;
        }

        .heading h1 {
            margin: 0;
            font-size: 24px;
        }

        .back-link {
            color: var(--teal);
            font-size: 14px;
            text-decoration: none;
        }

        .edit-card {
            padding: 20px;
            border: 1px solid var(--border);
            border-radius: 16px;
            background: white;
        }

        .edit-card h2 {
            margin: 0 0 16px;
            font-size: 17px;
        }

        .fields {
            display: grid;
            grid-template-columns: repeat(2, minmax(0, 1fr));
            gap: 14px;
        }

        .fields label {
            display: grid;
            gap: 6px;
            font-size: 12px;
            font-weight: 600;
        }

        .fields input {
            width: 100%;
            min-height: 42px;
            padding: 0 12px;
            border: 1px solid var(--border);
            border-radius: 11px;
            outline-color: var(--teal);
            background: var(--page);
            font: inherit;
            font-size: 13px;
        }

        .photo-editor {
            display: flex; align-items: center; gap: 16px; margin: 0 0 20px;
            padding: 14px; border: 1px solid var(--border); border-radius: 12px; background: #fbfcfa;
        }
        .photo-preview {
            width: 76px; height: 76px; flex: 0 0 76px; display: grid; place-items: center;
            overflow: hidden; border-radius: 50%; background: #e2eff0; color: var(--teal); font-size: 32px; font-weight: bold;
        }
        .photo-preview img { width: 100%; height: 100%; object-fit: cover; }
        .photo-controls { display: grid; gap: 7px; min-width: 0; flex: 1; }
        .photo-crop-controls {
            display: grid;
            grid-template-columns: 132px minmax(150px, 1fr);
            align-items: center;
            gap: 14px;
            margin-top: 5px;
        }
        .photo-crop-controls[hidden] { display: none; }
        .photo-crop-canvas {
            display: block;
            width: 128px;
            height: 128px;
            border: 2px solid white;
            border-radius: 50%;
            background: #e2eff0;
            box-shadow: 0 0 0 1px var(--border);
            cursor: grab;
            touch-action: none;
        }
        .photo-crop-canvas:active { cursor: grabbing; }
        .photo-crop-settings { display: grid; gap: 8px; }
        .photo-crop-settings label { font-size: 12px; font-weight: 700; }
        .photo-zoom { width: 100%; accent-color: var(--teal); }
        .photo-crop-help { color: #788889; font-size: 11px; line-height: 1.4; }
        @media (max-width: 600px) {
            .photo-crop-controls { grid-template-columns: 100px minmax(120px, 1fr); gap: 10px; }
            .photo-crop-canvas { width: 96px; height: 96px; }
        }
        .photo-title { font-size: 13px; font-weight: 700; }
        .photo-help { color: #788889; font-size: 11px; }
        .photo-input { position: absolute; width: 1px; height: 1px; overflow: hidden; opacity: 0; }
        .photo-pick {
            width: fit-content; padding: 8px 13px; border: 1px solid var(--border); border-radius: 20px;
            background: white; color: var(--teal); font-size: 12px; font-weight: 700; cursor: pointer;
        }
        .photo-pick:hover { background: #f2f8f8; }
        .photo-error { margin: 0; color: #c84b37; font-size: 12px; }
        .actions {
            display: flex;
            gap: 10px;
            margin-top: 18px;
        }

        .save-button,
        .cancel-button {
            min-height: 40px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            padding: 0 20px;
            border-radius: 22px;
            font: inherit;
            font-size: 13px;
            text-decoration: none;
            cursor: pointer;
        }

        .save-button {
            border: 0;
            background: var(--teal);
            color: white;
        }

        .cancel-button {
            border: 1px solid var(--border);
            background: white;
            color: var(--text);
        }

        @media (max-width: 760px) {
            .app { grid-template-columns: 200px minmax(0, 1fr); }
            .main { padding: 20px; }
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
            .fields { grid-template-columns: 1fr; }
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
                <a class="back-link" href="{{ route('profil.index') }}">← Kembali</a>
                <h1>Edit Profil</h1>
            </div>

            <section class="edit-card">
                <h2>Informasi pribadi</h2>

                @if (session('status'))<p class="success-message">{{ session('status') }}</p>@endif
                <form method="POST" action="{{ route('profil.update') }}" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <section class="photo-editor" aria-label="Foto profil">
                        <div class="photo-preview" id="photoPreview">
                            @if ($hasProfilePhoto)
                                <img src="{{ route('profil.photo') }}?v={{ session('profile_photo_version', '0') }}" alt="Foto profil saat ini">
                            @else
                                <span>{{ strtoupper(substr(auth()->user()->name, 0, 1)) }}</span>
                            @endif
                        </div>
                        <div class="photo-controls">
                            <span class="photo-title">Foto profil</span>
                            <label class="photo-pick" for="profile_photo">Pilih foto</label>
                            <input class="photo-input" id="profile_photo" type="file" name="profile_photo" accept="image/jpeg,image/png,image/webp">
                            <small class="photo-help">JPG, PNG, atau WEBP. Maksimal 2 MB.</small>
                            @error('profile_photo')<p class="photo-error">{{ $message }}</p>@enderror
                            <div class="photo-crop-controls" id="photoCropControls" hidden>
                                <canvas class="photo-crop-canvas" id="photoCropCanvas" width="512" height="512" aria-label="Pratinjau potongan foto"></canvas>
                                <div class="photo-crop-settings">
                                    <label for="photoZoom">Atur besar foto</label>
                                    <input class="photo-zoom" id="photoZoom" type="range" min="1" max="3" step="0.01" value="1">
                                    <small class="photo-crop-help">Geser foto di lingkaran untuk mengatur posisi.</small>
                                </div>
                            </div>
                        </div>
                    </section>
                <div class="fields">                    <label>
                        Nama lengkap
                        <input type="text" name="name" required
                               value="{{ old('name', auth()->user()->name) }}"
                               placeholder="Masukkan nama lengkap">
                    </label>

                    <label>
                        Email
                        <input type="email" name="email" required
                               value="{{ old('email', auth()->user()->email) }}"
                               placeholder="nama@email.com">
                    </label>

                    <label>
                        Nomor telepon
                        <input type="tel" name="phone" maxlength="20" value="{{ old('phone', auth()->user()->phone) }}" placeholder="08xx xxxx xxxx">
                    </label>

                    <label>
                        Kota / kabupaten
                        <input type="text" name="city" maxlength="120" value="{{ old('city', auth()->user()->city) }}" placeholder="Contoh: Padang">
                    </label>
                </div>

                <div class="actions">
                    <button class="save-button" type="submit">Simpan perubahan</button>
                    <a class="cancel-button" href="{{ route('profil.index') }}">Batal</a>
                </div>
                </form>
            </section>
        </section>
    </main>
</div>
<script>
    const photoInput = document.getElementById('profile_photo');
    const photoPreview = document.getElementById('photoPreview');
    const photoCropControls = document.getElementById('photoCropControls');
    const photoCropCanvas = document.getElementById('photoCropCanvas');
    const photoZoom = document.getElementById('photoZoom');
    const cropContext = photoCropCanvas.getContext('2d');
    const profileForm = photoInput.form;

    let sourceImage = null;
    let previewImage = null;
    let fitScale = 1;
    let cropScale = 1;
    let offsetX = 0;
    let offsetY = 0;
    let dragging = false;
    let lastPointerX = 0;
    let lastPointerY = 0;
    let croppedFileReady = false;

    function drawPhotoCrop() {
        if (!sourceImage) return;

        const width = sourceImage.naturalWidth * fitScale * cropScale;
        const height = sourceImage.naturalHeight * fitScale * cropScale;
        offsetX = Math.min(0, Math.max(photoCropCanvas.width - width, offsetX));
        offsetY = Math.min(0, Math.max(photoCropCanvas.height - height, offsetY));

        cropContext.clearRect(0, 0, photoCropCanvas.width, photoCropCanvas.height);
        cropContext.drawImage(sourceImage, offsetX, offsetY, width, height);

        if (!previewImage) {
            previewImage = document.createElement('img');
            previewImage.alt = 'Pratinjau foto profil';
            photoPreview.replaceChildren(previewImage);
        }
        previewImage.src = photoCropCanvas.toDataURL('image/jpeg', 0.82);
    }

    photoInput.addEventListener('change', function () {
        const file = this.files && this.files[0];
        if (!file) return;

        if (file.size > 2 * 1024 * 1024) {
            this.value = '';
            window.alert('Ukuran foto maksimal 2 MB.');
            return;
        }

        const imageUrl = URL.createObjectURL(file);
        const image = new Image();
        image.onload = function () {
            URL.revokeObjectURL(imageUrl);
            sourceImage = image;
            fitScale = Math.max(
                photoCropCanvas.width / image.naturalWidth,
                photoCropCanvas.height / image.naturalHeight
            );
            cropScale = 1;
            photoZoom.value = '1';
            const width = image.naturalWidth * fitScale;
            const height = image.naturalHeight * fitScale;
            offsetX = (photoCropCanvas.width - width) / 2;
            offsetY = (photoCropCanvas.height - height) / 2;
            photoCropControls.hidden = false;
            drawPhotoCrop();
        };
        image.onerror = function () {
            URL.revokeObjectURL(imageUrl);
            window.alert('Foto tidak dapat dibuka. Coba pilih file gambar lain.');
        };
        image.src = imageUrl;
    });

    photoZoom.addEventListener('input', function () {
        if (!sourceImage) return;
        const oldWidth = sourceImage.naturalWidth * fitScale * cropScale;
        const oldHeight = sourceImage.naturalHeight * fitScale * cropScale;
        const focusX = (photoCropCanvas.width / 2 - offsetX) / oldWidth;
        const focusY = (photoCropCanvas.height / 2 - offsetY) / oldHeight;
        cropScale = Number(this.value);
        const newWidth = sourceImage.naturalWidth * fitScale * cropScale;
        const newHeight = sourceImage.naturalHeight * fitScale * cropScale;
        offsetX = photoCropCanvas.width / 2 - focusX * newWidth;
        offsetY = photoCropCanvas.height / 2 - focusY * newHeight;
        drawPhotoCrop();
    });

    photoCropCanvas.addEventListener('pointerdown', function (event) {
        if (!sourceImage) return;
        dragging = true;
        lastPointerX = event.clientX;
        lastPointerY = event.clientY;
        photoCropCanvas.setPointerCapture(event.pointerId);
    });
    photoCropCanvas.addEventListener('pointermove', function (event) {
        if (!dragging) return;
        const bounds = photoCropCanvas.getBoundingClientRect();
        offsetX += (event.clientX - lastPointerX) * (photoCropCanvas.width / bounds.width);
        offsetY += (event.clientY - lastPointerY) * (photoCropCanvas.height / bounds.height);
        lastPointerX = event.clientX;
        lastPointerY = event.clientY;
        drawPhotoCrop();
    });
    photoCropCanvas.addEventListener('pointerup', function () { dragging = false; });
    photoCropCanvas.addEventListener('pointercancel', function () { dragging = false; });

    profileForm.addEventListener('submit', function (event) {
        if (!sourceImage || croppedFileReady) return;
        event.preventDefault();
        photoCropCanvas.toBlob(function (blob) {
            if (!blob) {
                window.alert('Potongan foto gagal diproses. Coba lagi.');
                return;
            }
            const transfer = new DataTransfer();
            transfer.items.add(new File([blob], 'foto-profil.jpg', { type: 'image/jpeg' }));
            photoInput.files = transfer.files;
            croppedFileReady = true;
            if (event.submitter) profileForm.requestSubmit(event.submitter);
            else profileForm.requestSubmit();
        }, 'image/jpeg', 0.9);
    });
</script>
</body>
</html>