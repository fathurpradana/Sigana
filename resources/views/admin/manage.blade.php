<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kelola SIGANA | Admin</title>
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css">
    <style>
        :root { --teal:#105461; --teal2:#174f5a; --page:#f3f5f2; --line:#dfe7e4; --text:#17343a; --muted:#718287; --red:#c84b37; }
        * { box-sizing:border-box; }
        html { scroll-behavior:smooth; scroll-padding-top:18px; }
        body { margin:0; background:var(--page); color:var(--text); font-family:Arial,sans-serif; }
        header { position:sticky; top:0; z-index:10; display:flex; align-items:center; justify-content:space-between; gap:16px; padding:14px clamp(16px,4vw,50px); background:var(--teal); color:white; box-shadow:0 3px 14px #183d4420; }
        .brand strong { font-size:18px; letter-spacing:.04em; }.brand span { display:block; margin-top:4px; color:#d2e4e5; font-size:12px; }
        .header-actions { display:flex; align-items:center; gap:10px; }.header-actions a,.header-actions button { padding:10px 13px; border:1px solid #ffffff70; border-radius:9px; background:transparent; color:white; text-decoration:none; font:inherit; cursor:pointer; }
        .shell { display:grid; grid-template-columns:225px minmax(0,1fr); gap:24px; width:min(1500px,100%); margin:0 auto; padding:24px; }
        aside { align-self:start; position:sticky; top:84px; display:grid; gap:7px; padding:12px; border:1px solid var(--line); border-radius:15px; background:white; }
        aside a { padding:11px 12px; border-radius:9px; color:var(--text); font-size:13px; text-decoration:none; } aside a:hover { background:#eaf2f1; color:var(--teal); }
        main { min-width:0; }.page-title { margin:0; font-size:30px; }.lead { margin:8px 0 22px; color:var(--muted); }
        .stats { display:grid; grid-template-columns:repeat(4,minmax(0,1fr)); gap:12px; margin-bottom:22px; }.stat,.panel { border:1px solid var(--line); border-radius:14px; background:white; }.stat { padding:17px; }.stat span { color:var(--muted); font-size:12px; }.stat strong { display:block; margin-top:8px; color:var(--teal); font-size:25px; }
        .panel { margin:0 0 20px; padding:20px; scroll-margin-top:84px; }.panel-head { display:flex; align-items:flex-start; justify-content:space-between; gap:12px; margin-bottom:15px; }.panel h2 { margin:0; font-size:19px; }.panel p.hint { margin:6px 0 0; color:var(--muted); font-size:12px; line-height:1.5; }
        .create-box { margin-bottom:15px; padding:15px; border:1px solid var(--line); border-radius:12px; background:#fbfcfb; }.create-box summary,.record summary { cursor:pointer; color:var(--teal); font-weight:700; font-size:13px; }.create-box form,.record form { margin-top:13px; }
        .form-grid { display:grid; grid-template-columns:repeat(2,minmax(0,1fr)); gap:11px; }.field { display:grid; gap:6px; font-size:12px; font-weight:600; }.field.full { grid-column:1/-1; }.field input,.field select,.field textarea { width:100%; min-height:39px; padding:9px 11px; border:1px solid var(--line); border-radius:8px; background:#fff; color:var(--text); font:inherit; font-weight:400; }.field textarea { min-height:85px; resize:vertical; }.field small { color:var(--muted); font-weight:400; }
        .button { display:inline-flex; align-items:center; justify-content:center; min-height:38px; padding:9px 14px; border:0; border-radius:8px; background:var(--teal); color:#fff; font:inherit; font-size:12px; font-weight:700; text-decoration:none; cursor:pointer; }.button.secondary { border:1px solid var(--line); background:#fff; color:var(--teal); }.button.danger { background:#fff2ef; color:var(--red); }.form-actions { display:flex; flex-wrap:wrap; gap:8px; margin-top:12px; }
        .flash { margin:0 0 16px; padding:12px 14px; border:1px solid #b9dfca; border-radius:9px; background:#effaf2; color:#246c42; font-size:13px; }.errors { margin:0 0 16px; padding:12px 14px 12px 34px; border:1px solid #f1c5bb; border-radius:9px; background:#fff4f1; color:#a63827; font-size:13px; }
        .record-list { display:grid; gap:9px; }.record { padding:13px; border:1px solid var(--line); border-radius:11px; }.record-top { display:flex; justify-content:space-between; gap:12px; align-items:flex-start; }.record-top strong { font-size:13px; }.record-meta { margin-top:5px; color:var(--muted); font-size:11px; }.record details { margin-top:10px; }.record textarea { min-height:75px; }.record .delete-form { display:inline; margin:0; }.empty { padding:14px; border:1px dashed var(--line); border-radius:10px; color:var(--muted); font-size:13px; text-align:center; }
        .role-form { display:flex; gap:7px; align-items:center; }.role-form select { padding:8px; border:1px solid var(--line); border-radius:7px; background:white; }.table-wrap { overflow-x:auto; }table { width:100%; border-collapse:collapse; font-size:12px; }th,td { padding:10px 8px; border-bottom:1px solid var(--line); text-align:left; vertical-align:middle; }th { color:var(--muted); font-weight:600; white-space:nowrap; }.status-pill { display:inline-block; padding:5px 8px; border-radius:999px; background:#e8f3f2; color:var(--teal); font-size:11px; }
.verification-map-block { margin:14px 0; padding:14px; border:1px solid var(--line); border-radius:12px; background:#f8fbfa; }
.verification-map-block p { margin:0 0 10px; color:var(--muted); font-size:12px; line-height:1.5; }
.verification-map { width:100%; height:280px; border:1px solid var(--line); border-radius:10px; background:#e4eff0; }
.verification-map-block .map-coordinate-readout { margin:9px 0 0; color:var(--teal); font-weight:700; }
        @media(max-width:950px) { .shell { grid-template-columns:1fr; padding:16px; } aside { position:static; display:flex; gap:4px; overflow-x:auto; } aside a { flex:0 0 auto; white-space:nowrap; }.stats { grid-template-columns:repeat(2,minmax(0,1fr)); } }
        @media(max-width:560px) { header { align-items:flex-start; }.header-actions { flex-direction:column; align-items:stretch; }.stats,.form-grid { grid-template-columns:1fr; }.field.full { grid-column:auto; }.panel { padding:14px; }.page-title { font-size:25px; } }
    </style>
    <link rel="stylesheet" href="{{ asset('css/sigana-theme.css') }}?v=6">
    <script src="{{ asset('js/sigana-theme.js') }}?v=4" defer></script>
</head>
<body>
<header>
    <div class="brand"><strong>SIGANA · PANEL ADMIN</strong><span>Masuk sebagai {{ auth()->user()->name }}</span></div>
    <div class="header-actions"><a href="{{ route('admin.dashboard') }}">Ringkasan</a><form method="POST" action="{{ route('logout') }}">@csrf<button type="submit">Keluar</button></form></div>
</header>
<div class="shell">
    <aside aria-label="Navigasi pengelolaan">
        <a href="#bencana-admin">Berita &amp; laporan bencana</a>
        <a href="#kategori-admin">Kategori bencana</a>
        <a href="#tips-admin">Tips keselamatan</a>
        <a href="#kontak-admin">Nomor darurat</a>
        <a href="#informasi-admin">Informasi umum</a>
        <a href="#pengguna-admin">Akun &amp; role</a>
        <a href="#pengumuman-admin">Notifikasi</a>
    </aside>
    <main>
        <h1 class="page-title">Kelola semua data SIGANA</h1>
        <p class="lead">Kelola data utama, tinjau laporan, atur akun, dan kirim pengumuman untuk pengguna SIGANA.</p>
        @if(session('status'))<p class="flash" role="status">{{ session('status') }}</p>@endif
        @if($errors->any())<ul class="errors">@foreach($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul>@endif
        <section class="stats" aria-label="Ringkasan data">
            <article class="stat"><span>Pengguna</span><strong>{{ $stats['users'] }}</strong></article>
            <article class="stat"><span>Berita bencana</span><strong>{{ $stats['disasters'] }}</strong></article>
            <article class="stat"><span>Laporan baru</span><strong>{{ $stats['pending_reports'] }}</strong></article>
            <article class="stat"><span>Kategori</span><strong>{{ $stats['categories'] }}</strong></article>
        </section>

        <section class="panel" id="bencana-admin">
            <div class="panel-head"><div><h2>Berita &amp; laporan bencana</h2><p class="hint">Tinjau laporan pengguna, ubah status, atau buat berita resmi.</p></div></div>
            <details class="create-box"><summary>＋ Tambah berita bencana</summary>
                <form method="POST" action="{{ route('admin.disasters.store') }}" enctype="multipart/form-data">@csrf
                    <div class="form-grid">
                        <label class="field">Judul<input name="title" maxlength="255" required></label>
                        <label class="field">Jenis bencana<select name="category_id" required><option value="">Pilih kategori</option>@foreach($categories as $category)<option value="{{ $category->id }}">{{ $category->name }}</option>@endforeach</select></label>
                        <label class="field">Lokasi<input name="location" maxlength="255" required></label>
                        <label class="field">Waktu kejadian<input type="datetime-local" name="occurred_at" value="{{ now('Asia/Jakarta')->format('Y-m-d\TH:i') }}" required></label>
                        <label class="field">Status<select name="status"><option>Dilaporkan</option><option>Dipantau</option><option>Aktif</option><option>Selesai</option></select></label>
                        <label class="field">Foto berita<input type="file" name="photo" accept="image/jpeg,image/png,image/webp" required><small>JPG, PNG, WebP; maksimal 4 MB.</small></label>
                        <label class="field">Latitude (opsional)<input type="number" name="latitude" step="any" min="-90" max="90"></label>
                        <label class="field">Longitude (opsional)<input type="number" name="longitude" step="any" min="-180" max="180"></label>
                        <label class="field full">Keterangan<textarea name="description" maxlength="10000" required></textarea></label>
                    </div><div class="form-actions"><button class="button">Simpan berita</button></div>
                </form>
            </details>
            <div class="record-list">
                @forelse($disasters as $item)
                    <article class="record"><div class="record-top"><div><strong>{{ $item->title }}</strong><div class="record-meta">{{ $item->category_name ?: 'Tanpa kategori' }} · {{ $item->location }} · {{ $item->status }}</div><div class="record-meta">Verifikasi: <strong>{{ $item->verification_status }}</strong></div></div><span class="status-pill">#{{ $item->id }}</span></div>
                        <details data-verification-details><summary>Verifikasi / edit berita</summary>
                            <div class="verification-map-block" data-verification-map data-latitude="{{ $item->latitude ?? '' }}" data-longitude="{{ $item->longitude ?? '' }}">
                                <p><strong>Lokasi dari pelapor:</strong> {{ $item->location }}<br>Pilih titik kejadian yang tepat pada peta sebelum menyetujui laporan.</p>
                                <div class="verification-map" id="verification-map-{{ $item->id }}" aria-label="Peta untuk memilih titik lokasi bencana"></div>
                                <p class="map-coordinate-readout" data-coordinate-readout>@if($item->latitude !== null && $item->longitude !== null) Titik tersimpan: {{ $item->latitude }}, {{ $item->longitude }} @else Belum ada titik lokasi dipilih. @endif</p>
                                <div class="form-actions">
                                    <form class="verification-approve-form" method="POST" action="{{ route('admin.disasters.verify', $item->id) }}">@csrf @method('PUT')<input type="hidden" name="verification_status" value="Disetujui"><input type="hidden" name="latitude" value="{{ $item->latitude ?? '' }}"><input type="hidden" name="longitude" value="{{ $item->longitude ?? '' }}"><button class="button">Setujui &amp; tampilkan</button></form>
                                    <form method="POST" action="{{ route('admin.disasters.verify', $item->id) }}" onsubmit="return confirm('Tolak atau sembunyikan laporan ini dari pengguna?')">@csrf @method('PUT')<input type="hidden" name="verification_status" value="Ditolak"><button class="button danger">Tolak / sembunyikan</button></form>
                                </div>
                            </div><form method="POST" action="{{ route('admin.disasters.update', $item->id) }}" enctype="multipart/form-data">@csrf @method('PUT')
                            <div class="form-grid">
                                <label class="field">Judul<input name="title" value="{{ $item->title }}" required></label>
                                <label class="field">Kategori<select name="category_id" required>@foreach($categories as $category)<option value="{{ $category->id }}" @selected($item->category_id == $category->id)>{{ $category->name }}</option>@endforeach</select></label>
                                <label class="field">Lokasi<input name="location" value="{{ $item->location }}" required></label>
                                <label class="field">Waktu kejadian<input type="datetime-local" name="occurred_at" value="{{ \Illuminate\Support\Carbon::parse($item->occurred_at, 'UTC')->setTimezone('Asia/Jakarta')->format('Y-m-d\TH:i') }}" required></label>
                                <label class="field">Status<select name="status">@foreach(['Dilaporkan','Dipantau','Aktif','Selesai'] as $status)<option @selected($item->status === $status)>{{ $status }}</option>@endforeach</select></label>
                                <label class="field">Ganti foto<input type="file" name="photo" accept="image/jpeg,image/png,image/webp"><small>Biarkan kosong untuk mempertahankan foto saat ini.</small></label>
                                <label class="field">Latitude<input type="number" name="latitude" step="any" value="{{ $item->latitude }}"></label>
                                <label class="field">Longitude<input type="number" name="longitude" step="any" value="{{ $item->longitude }}"></label>
                                <label class="field full">Keterangan<textarea name="description" required>{{ $item->description }}</textarea></label>
                            </div><div class="form-actions"><button class="button">Simpan perubahan</button></div>
                        </form><form class="delete-form" method="POST" action="{{ route('admin.disasters.destroy', $item->id) }}" onsubmit="return confirm('Hapus berita bencana ini?')">@csrf @method('DELETE')<button class="button danger">Hapus berita</button></form></details>
                    </article>
                @empty<p class="empty">Belum ada berita bencana.</p>@endforelse
            </div>
        </section>

        <section class="panel" id="kategori-admin"><div class="panel-head"><div><h2>Kategori bencana</h2><p class="hint">Kategori dipakai oleh berita dan tips keselamatan.</p></div></div>
            <details class="create-box"><summary>＋ Tambah kategori</summary><form method="POST" action="{{ route('admin.categories.store') }}">@csrf<div class="form-grid"><label class="field">Nama kategori<input name="name" required maxlength="100"></label><label class="field">Keterangan<input name="description" maxlength="2000"></label></div><div class="form-actions"><button class="button">Tambah kategori</button></div></form></details>
            <div class="record-list">@forelse($categories as $item)<article class="record"><div class="record-top"><div><strong>{{ $item->name }}</strong><div class="record-meta">{{ $item->description }}</div></div></div><details><summary>Edit kategori</summary><form method="POST" action="{{ route('admin.categories.update', $item->id) }}">@csrf @method('PUT')<div class="form-grid"><label class="field">Nama<input name="name" value="{{ $item->name }}" required></label><label class="field">Keterangan<input name="description" value="{{ $item->description }}"></label></div><div class="form-actions"><button class="button">Simpan</button></div></form><form class="delete-form" method="POST" action="{{ route('admin.categories.destroy', $item->id) }}" onsubmit="return confirm('Hapus kategori ini?')">@csrf @method('DELETE')<button class="button danger">Hapus kategori</button></form></details></article>@empty<p class="empty">Belum ada kategori.</p>@endforelse</div>
        </section>

        <section class="panel" id="tips-admin"><div class="panel-head"><div><h2>Tips keselamatan</h2><p class="hint">Konten ini tampil pada halaman Tips &amp; darurat.</p></div></div>
            <details class="create-box"><summary>＋ Tambah tips</summary><form method="POST" action="{{ route('admin.tips.store') }}">@csrf<div class="form-grid"><label class="field">Judul<input name="title" required maxlength="255"></label><label class="field">Kategori<select name="category_id"><option value="">Panduan umum</option>@foreach($categories as $category)<option value="{{ $category->id }}">{{ $category->name }}</option>@endforeach</select></label><label class="field">Tahap<select name="phase"><option>Sebelum</option><option>Saat</option><option>Sesudah</option></select></label><label class="field">Referensi gambar (opsional)<input name="image" maxlength="255" placeholder="URL atau path gambar"></label><label class="field full">Isi tips<textarea name="content" required maxlength="10000"></textarea></label></div><div class="form-actions"><button class="button">Tambah tips</button></div></form></details>
            <div class="record-list">@forelse($tips as $item)<article class="record"><div class="record-top"><div><strong>{{ $item->title }}</strong><div class="record-meta">{{ $item->category_name ?: 'Panduan umum' }} · {{ $item->phase }}</div></div></div><details><summary>Edit tips</summary><form method="POST" action="{{ route('admin.tips.update', $item->id) }}">@csrf @method('PUT')<div class="form-grid"><label class="field">Judul<input name="title" value="{{ $item->title }}" required></label><label class="field">Kategori<select name="category_id"><option value="">Panduan umum</option>@foreach($categories as $category)<option value="{{ $category->id }}" @selected($item->category_id == $category->id)>{{ $category->name }}</option>@endforeach</select></label><label class="field">Tahap<select name="phase">@foreach(['Sebelum','Saat','Sesudah'] as $phase)<option @selected($item->phase === $phase)>{{ $phase }}</option>@endforeach</select></label><label class="field">Referensi gambar<input name="image" value="{{ $item->image }}"></label><label class="field full">Isi<textarea name="content" required>{{ $item->content }}</textarea></label></div><div class="form-actions"><button class="button">Simpan perubahan</button></div></form><form class="delete-form" method="POST" action="{{ route('admin.tips.destroy', $item->id) }}" onsubmit="return confirm('Hapus tips ini?')">@csrf @method('DELETE')<button class="button danger">Hapus tips</button></form></details></article>@empty<p class="empty">Belum ada tips.</p>@endforelse</div>
        </section>

        <section class="panel" id="kontak-admin"><div class="panel-head"><div><h2>Nomor darurat</h2><p class="hint">Pastikan nomor yang dimasukkan benar dan aktif sebelum ditampilkan ke publik.</p></div></div>
            <details class="create-box"><summary>＋ Tambah kontak darurat</summary><form method="POST" action="{{ route('admin.contacts.store') }}">@csrf<div class="form-grid"><label class="field">Nama layanan<input name="name" required maxlength="255"></label><label class="field">Instansi<input name="agency" maxlength="150"></label><label class="field">Nomor telepon<input name="phone" required maxlength="30"></label><label class="field">Alamat<input name="address" maxlength="255"></label><label class="field full">Keterangan<textarea name="description" maxlength="3000"></textarea></label></div><div class="form-actions"><button class="button">Tambah kontak</button></div></form></details>
            <div class="record-list">@forelse($contacts as $item)<article class="record"><div class="record-top"><div><strong>{{ $item->agency ?: $item->name }} · {{ $item->phone }}</strong><div class="record-meta">{{ $item->description }}</div></div></div><details><summary>Edit kontak</summary><form method="POST" action="{{ route('admin.contacts.update', $item->id) }}">@csrf @method('PUT')<div class="form-grid"><label class="field">Nama layanan<input name="name" value="{{ $item->name }}" required></label><label class="field">Instansi<input name="agency" value="{{ $item->agency }}"></label><label class="field">Nomor telepon<input name="phone" value="{{ $item->phone }}" required></label><label class="field">Alamat<input name="address" value="{{ $item->address }}"></label><label class="field full">Keterangan<textarea name="description">{{ $item->description }}</textarea></label></div><div class="form-actions"><button class="button">Simpan perubahan</button></div></form><form class="delete-form" method="POST" action="{{ route('admin.contacts.destroy', $item->id) }}" onsubmit="return confirm('Hapus nomor darurat ini?')">@csrf @method('DELETE')<button class="button danger">Hapus kontak</button></form></details></article>@empty<p class="empty">Belum ada kontak darurat.</p>@endforelse</div>
        </section>

        <section class="panel" id="informasi-admin"><div class="panel-head"><div><h2>Informasi umum</h2><p class="hint">Kelola artikel/informasi umum yang disimpan pada tabel general_information.</p></div></div>
            <details class="create-box"><summary>＋ Tambah informasi</summary><form method="POST" action="{{ route('admin.information.store') }}">@csrf<div class="form-grid"><label class="field">Judul<input name="title" required maxlength="255"></label><label class="field">Waktu publikasi<input type="datetime-local" name="published_at"></label><label class="field full">URL gambar (opsional)<input name="image" maxlength="255"></label><label class="field full">Isi informasi<textarea name="content" required maxlength="20000"></textarea></label></div><div class="form-actions"><button class="button">Tambah informasi</button></div></form></details>
            <div class="record-list">@forelse($information as $item)<article class="record"><div class="record-top"><div><strong>{{ $item->title }}</strong><div class="record-meta">{{ $item->published_at ?: 'Belum dijadwalkan' }}</div></div></div><details><summary>Edit informasi</summary><form method="POST" action="{{ route('admin.information.update', $item->id) }}">@csrf @method('PUT')<div class="form-grid"><label class="field">Judul<input name="title" value="{{ $item->title }}" required></label><label class="field">Waktu publikasi<input type="datetime-local" name="published_at" value="{{ $item->published_at ? \Illuminate\Support\Carbon::parse($item->published_at, 'UTC')->setTimezone('Asia/Jakarta')->format('Y-m-d\TH:i') : '' }}"></label><label class="field full">URL gambar<input name="image" value="{{ $item->image }}"></label><label class="field full">Isi<textarea name="content" required>{{ $item->content }}</textarea></label></div><div class="form-actions"><button class="button">Simpan perubahan</button></div></form><form class="delete-form" method="POST" action="{{ route('admin.information.destroy', $item->id) }}" onsubmit="return confirm('Hapus informasi ini?')">@csrf @method('DELETE')<button class="button danger">Hapus informasi</button></form></details></article>@empty<p class="empty">Belum ada informasi umum.</p>@endforelse</div>
        </section>

        <section class="panel" id="pengguna-admin"><div class="panel-head"><div><h2>Akun dan role</h2><p class="hint">Promosikan pengguna tepercaya menjadi admin. Role akun yang sedang dipakai tidak dapat diubah dari panel ini.</p></div></div>
            <div class="table-wrap"><table><thead><tr><th>Nama</th><th>Email</th><th>Role</th><th>Ganti role / akun</th></tr></thead><tbody>@forelse($users as $item)<tr><td>{{ $item->name }}</td><td>{{ $item->email }}</td><td><span class="status-pill">{{ $item->role }}</span></td><td>@if($item->id !== auth()->id())<form class="role-form" method="POST" action="{{ route('admin.users.role', $item->id) }}">@csrf @method('PUT')<select name="role"><option value="user" @selected($item->role !== 'admin')>Pengguna</option><option value="admin" @selected($item->role === 'admin')>Admin</option></select><button class="button secondary">Simpan</button></form>@if($item->role !== 'admin')<form method="POST" action="{{ route('admin.users.destroy', $item->id) }}" onsubmit="return confirm('Hapus akun pengguna ini?')">@csrf @method('DELETE')<button class="button danger">Hapus akun</button></form>@endif @else<span>Akun aktif</span>@endif</td></tr>@empty<tr><td colspan="4">Belum ada akun.</td></tr>@endforelse</tbody></table></div>
        </section>

        <section class="panel" id="pengumuman-admin"><div class="panel-head"><div><h2>Notifikasi dan pengumuman</h2><p class="hint">Pengumuman dengan user_id NULL akan terlihat untuk seluruh pengguna yang notifikasinya aktif.</p></div></div>
            <details class="create-box"><summary>＋ Kirim pengumuman global</summary><form method="POST" action="{{ route('admin.announcements.store') }}">@csrf<div class="form-grid"><label class="field">Judul<input name="title" required maxlength="255"></label><label class="field">Jenis<input name="type" value="Informasi" required maxlength="50"></label><label class="field full">Pesan<textarea name="message" required maxlength="5000"></textarea></label></div><div class="form-actions"><button class="button">Kirim pengumuman</button></div></form></details>
            <div class="record-list">@forelse($notifications as $item)<article class="record"><div class="record-top"><div><strong>{{ $item->title }}</strong><div class="record-meta">{{ $item->type }} · {{ $item->user_id ? 'Pengguna #' . $item->user_id : 'Semua pengguna' }} · {{ $item->created_at }}</div><p>{{ $item->message }}</p></div><form method="POST" action="{{ route('admin.notifications.destroy', $item->id) }}" onsubmit="return confirm('Hapus notifikasi ini?')">@csrf @method('DELETE')<button class="button danger">Hapus</button></form></div></article>@empty<p class="empty">Belum ada notifikasi.</p>@endforelse</div>
        </section>
    </main>
</div>
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
<script>
document.querySelectorAll('[data-verification-details]').forEach((details) => {
    details.addEventListener('toggle', () => {
        if (!details.open) return;
        const block = details.querySelector('[data-verification-map]');
        if (!block || block.dataset.mapInitialized === 'true') return;

        const mapElement = block.querySelector('.verification-map');
        const approveForm = block.querySelector('.verification-approve-form');
        const latitudeInput = approveForm.querySelector('[name="latitude"]');
        const longitudeInput = approveForm.querySelector('[name="longitude"]');
        const readout = block.querySelector('[data-coordinate-readout]');
        const existingLatitude = Number(block.dataset.latitude);
        const existingLongitude = Number(block.dataset.longitude);
        const hasExistingPoint = block.dataset.latitude !== '' && block.dataset.longitude !== ''
            && Number.isFinite(existingLatitude) && Number.isFinite(existingLongitude);
        const map = L.map(mapElement).setView(
            hasExistingPoint ? [existingLatitude, existingLongitude] : [-2.5, 118],
            hasExistingPoint ? 10 : 4
        );

        L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
            maxZoom: 19,
            attribution: '&copy; OpenStreetMap contributors'
        }).addTo(map);

        let marker = hasExistingPoint ? L.marker([existingLatitude, existingLongitude]).addTo(map) : null;
        map.on('click', (event) => {
            const { lat, lng } = event.latlng;
            if (marker) marker.setLatLng(event.latlng);
            else marker = L.marker(event.latlng).addTo(map);

            latitudeInput.value = lat.toFixed(7);
            longitudeInput.value = lng.toFixed(7);
            readout.textContent = `Titik dipilih: ${lat.toFixed(6)}, ${lng.toFixed(6)}`;
        });

        block.dataset.mapInitialized = 'true';
        window.setTimeout(() => map.invalidateSize(), 100);
    });
});
</script>
</body>
</html>
