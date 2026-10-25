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
                <form method="POST" action="{{ route('profil.update') }}">
                    @csrf
                    @method('PUT')
                <div class="fields">
                    <label>
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
                        <input type="text" value="Belum tersedia pada tabel users" disabled><small>Kota belum memiliki kolom di database.</small>
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
</body>
</html>