<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pemindai Kerusakan | SIGANA</title>
    <link rel="stylesheet" href="{{ asset('css/sigana-theme.css') }}?v=9">
    <link rel="stylesheet" href="{{ asset('css/sigana-scan.css') }}?v=3">
    <script src="{{ asset('js/sigana-theme.js') }}?v=6" defer></script>
</head>
<body class="scan-page">
<div class="app scan-app">
    @include('partials.sidebar')

    <main class="main scan-main">
        <div class="scan-container">
            <header class="scan-heading-block">
                <p class="scan-eyebrow">Fitur unggulan SIGANA</p>
                <h1>Pemindai kerusakan bangunan</h1>
                <p>Unggah foto bangunan untuk melihat pengamatan awal tanda kerusakan yang mungkin terlihat setelah banjir atau gempa.</p>
            </header>

            <div class="scan-grid">
                <section class="scan-card">
                    <div class="scan-card-heading">
                        <span class="scan-step">01</span>
                        <div>
                            <h2>Unggah foto</h2>
                            <p>Pilih foto yang jelas dan memperlihatkan bagian bangunan yang ingin diperiksa.</p>
                        </div>
                    </div>

                    @if ($errors->any())
                        <div class="scan-error" role="alert">{{ $errors->first() }}</div>
                    @endif
                    @if (isset($scanError))
                        <div class="scan-error" role="alert">{{ $scanError }}</div>
                    @endif

                    <form id="damageScanForm" method="POST" action="{{ route('damage-scan.analyze') }}" enctype="multipart/form-data">
                        @csrf
                        <label class="scan-field" for="scanHazardType">
                            <span>Konteks bencana</span>
                            <select id="scanHazardType" name="hazard_type" required>
                                <option value="Banjir" @selected(old('hazard_type', $hazardType ?? 'Banjir') === 'Banjir')>Banjir</option>
                                <option value="Gempa Bumi" @selected(old('hazard_type', $hazardType ?? '') === 'Gempa Bumi')>Gempa bumi</option>
                            </select>
                        </label>

                        <div id="scanDrop" class="scan-drop {{ !empty($previewData) ? 'has-image' : '' }}">
                            <img id="scanPreview" src="{{ $previewData ?? '' }}" alt="Pratinjau foto bangunan yang dipilih">
                            <div class="scan-drop-copy">
                                <span class="scan-upload-icon" aria-hidden="true">＋</span>
                                <strong>Tambahkan foto bangunan</strong>
                                <span>Seret foto ke sini atau pilih tombol di bawah · maksimal 5 MB</span>
                            </div>
                        </div>
                        <input class="scan-file" id="scanPhoto" name="photo" type="file" accept="image/jpeg,image/png,image/webp" required>
                        <div class="scan-photo-actions">
                            <label class="scan-select" for="scanPhoto">Pilih atau ganti foto</label>
                            <button class="scan-clear" id="scanClear" type="button" {{ empty($previewData) ? 'hidden' : '' }}>Hapus foto</button>
                        </div>
                        <p class="scan-hint">Foto dikirim ke layanan AI untuk dianalisis dan tidak disimpan oleh SIGANA. Hasil hanya tampil di halaman ini.</p>
                        <button id="scanSubmit" class="scan-button" type="submit">Analisis foto</button>
                    </form>
                    <p class="scan-consent">Dengan menekan Analisis foto, Anda setuju foto diproses oleh penyedia AI untuk menghasilkan pengamatan visual.</p>
                </section>

                <section class="scan-card scan-result" aria-live="polite">
                    <div class="scan-card-heading">
                        <span class="scan-step">02</span>
                        <div>
                            <h2>Hasil pengamatan awal</h2>
                            <p>Gunakan hasil ini sebagai informasi awal, bukan pengganti pemeriksaan petugas.</p>
                        </div>
                    </div>
                    @if (isset($result))
                        <div class="scan-result-top"><span class="scan-badge">{{ $result['hazard_type'] }} · AI visual</span></div>
                        @if (! $result['is_building_photo'])
                            <div class="scan-error">Foto ini tidak teridentifikasi sebagai foto bangunan. Coba unggah foto bangunan yang lebih jelas.</div>
                        @endif
                        <div class="scan-severity-row">
                            <span>Tingkat pengamatan</span>
                            <strong class="scan-severity {{ \Illuminate\Support\Str::slug($result['severity']) }}">{{ $result['severity'] }}</strong>
                        </div>
                        <p class="scan-summary">{{ $result['summary'] }}</p>
                        @if (count($result['signs']))
                            <div class="scan-result-section"><h3>Tanda yang terlihat</h3><ul>@foreach ($result['signs'] as $sign)<li>{{ $sign }}</li>@endforeach</ul></div>
                        @endif
                        @if (count($result['actions']))
                            <div class="scan-result-section"><h3>Langkah yang disarankan</h3><ul>@foreach ($result['actions'] as $action)<li>{{ $action }}</li>@endforeach</ul></div>
                        @endif
                    @else
                        <div class="scan-empty">
                            <span class="scan-empty-icon" aria-hidden="true">⌕</span>
                            <strong>Hasil analisis akan tampil di sini</strong>
                            <p>Pilih foto bangunan, lalu tekan tombol Analisis foto.</p>
                        </div>
                    @endif
                </section>
            </div>

            <aside class="scan-disclaimer">
                <span class="scan-disclaimer-icon" aria-hidden="true">!</span>
                <div><strong>Catatan keselamatan</strong><p>Hasil ini hanya pengamatan visual awal, bukan pemeriksaan teknis atau sertifikat keamanan bangunan. Jika terlihat kerusakan berat atau bangunan terasa tidak aman, menjauh dan hubungi petugas/112.</p></div>
            </aside>
        </div>
    </main>
</div>

<script>
const photoInput = document.getElementById('scanPhoto');
const preview = document.getElementById('scanPreview');
const drop = document.getElementById('scanDrop');
const form = document.getElementById('damageScanForm');
const submit = document.getElementById('scanSubmit');
const clearPhoto = document.getElementById('scanClear');
let previewUrl = null;

function resetPreview() {
    photoInput.value = '';
    preview.removeAttribute('src');
    drop.classList.remove('has-image');
    clearPhoto.hidden = true;
    if (previewUrl) {
        URL.revokeObjectURL(previewUrl);
        previewUrl = null;
    }
}

window.addEventListener('pageshow', () => {
    submit.disabled = false;
    submit.textContent = 'Analisis foto';
});

photoInput.addEventListener('change', () => {
    const file = photoInput.files?.[0];
    if (!file) return;
    if (!['image/jpeg', 'image/png', 'image/webp'].includes(file.type)) {
        alert('Pilih foto JPG, PNG, atau WebP.');
        resetPreview();
        return;
    }
    if (file.size > 5 * 1024 * 1024) {
        alert('Ukuran foto maksimal 5 MB.');
        resetPreview();
        return;
    }
    if (previewUrl) URL.revokeObjectURL(previewUrl);
    previewUrl = URL.createObjectURL(file);
    preview.src = previewUrl;
    drop.classList.add('has-image');
    clearPhoto.hidden = false;
});

clearPhoto.addEventListener('click', resetPreview);
['dragenter', 'dragover'].forEach((name) => drop.addEventListener(name, (event) => {
    event.preventDefault();
    drop.classList.add('is-dragging');
}));
['dragleave', 'drop'].forEach((name) => drop.addEventListener(name, (event) => {
    event.preventDefault();
    drop.classList.remove('is-dragging');
}));
drop.addEventListener('drop', (event) => {
    const file = event.dataTransfer.files?.[0];
    if (!file) return;
    const transfer = new DataTransfer();
    transfer.items.add(file);
    photoInput.files = transfer.files;
    photoInput.dispatchEvent(new Event('change', { bubbles: true }));
});
form.addEventListener('submit', () => {
    submit.disabled = true;
    submit.innerHTML = '<span class="scan-loader"><span class="scan-spinner"></span>Sedang menganalisis…</span>';
});
</script>
</body>
</html>
