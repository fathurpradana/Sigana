<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panel Admin | SIGANA</title>
    <style>
        * { box-sizing: border-box; }
        body { margin: 0; min-height: 100vh; background: #f3f5f2; color: #17343a; font-family: Arial, sans-serif; }
        header { display: flex; justify-content: space-between; align-items: center; gap: 20px; padding: 20px clamp(20px, 5vw, 64px); background: #105461; color: white; }
        header strong { font-size: 20px; letter-spacing: .04em; }
        header span { display: block; margin-top: 4px; color: #d2e4e5; font-size: 13px; }
        header form { margin: 0; }
        button { padding: 10px 16px; border: 1px solid #ffffff70; border-radius: 9px; background: transparent; color: white; font: inherit; cursor: pointer; }
        main { width: min(1100px, 100%); margin: 0 auto; padding: 42px 24px; }
        h1 { margin: 0; font-size: clamp(26px, 4vw, 36px); }
        .intro { margin: 8px 0 28px; color: #6d8184; }
        .cards { display: grid; grid-template-columns: repeat(4, minmax(0, 1fr)); gap: 16px; }
        .card, .notice { border: 1px solid #e0e7e4; border-radius: 16px; background: white; }
        .card { padding: 22px; }
        .card span { display: block; color: #6d8184; font-size: 14px; }
        .card strong { display: block; margin-top: 12px; color: #105461; font-size: 30px; }
        .notice { margin-top: 20px; padding: 24px; }
        .notice h2 { margin: 0 0 8px; font-size: 18px; }
        .notice p { margin: 0; color: #6d8184; line-height: 1.6; }
        .links { display: flex; flex-wrap: wrap; gap: 10px; margin-top: 18px; }
        .links a { padding: 11px 15px; border-radius: 9px; background: #105461; color: white; text-decoration: none; font-size: 14px; }
        @media (max-width: 700px) { .cards { grid-template-columns: repeat(2, minmax(0, 1fr)); } header { padding: 16px; } main { padding: 30px 16px; } }
        @media (max-width: 420px) { .cards { grid-template-columns: 1fr; } }
    </style>
    <link rel="stylesheet" href="{{ asset('css/sigana-theme.css') }}?v=6">
    <script src="{{ asset('js/sigana-theme.js') }}?v=4" defer></script>
</head>
<body>
<header>
    <div><strong>SIGANA · ADMIN</strong><span>Masuk sebagai {{ auth()->user()->name }}</span></div>
    <form method="POST" action="{{ route('logout') }}">@csrf<button type="submit">Keluar</button></form>
</header>
<main>
    <h1>Panel Admin</h1>
    <p class="intro">Ringkasan data dan akses pengelolaan SIGANA.</p>
    <section class="cards" aria-label="Ringkasan administrasi">
        <article class="card"><span>Total pengguna</span><strong>{{ $stats['users'] }}</strong></article>
        <article class="card"><span>Total berita bencana</span><strong>{{ $stats['disasters'] }}</strong></article>
        <article class="card"><span>Laporan menunggu tinjauan</span><strong>{{ $stats['pending_reports'] }}</strong></article>
        <article class="card"><span>Kategori bencana</span><strong>{{ $stats['categories'] }}</strong></article>
    </section>
    <section class="notice">
        <h2>Akses admin</h2>
        <p>Halaman ini hanya dapat dibuka oleh akun dengan role admin. Kelola berita bencana, kategori, tips, nomor darurat, akun, informasi umum, dan pengumuman dari satu panel.</p>
        <nav class="links" aria-label="Tautan admin">
            <a href="{{ route('admin.manage') }}">Buka panel pengelolaan</a>
            <a href="{{ route('bencana.index') }}">Lihat halaman pengguna</a>
        </nav>
    </section>
</main>
</body>
</html>
