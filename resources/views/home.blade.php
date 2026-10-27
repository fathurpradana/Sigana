<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Beranda Tamu | SIGANA</title>

    <style>
        * { box-sizing: border-box; }

        body {
            min-height: 100vh;
            margin: 0;
            padding: 24px;
            display: grid;
            place-items: center;
            background: #f4f4f1;
            color: #183b42;
            font-family: Arial, sans-serif;
        }

        main {
            width: min(100%, 700px);
            padding: 48px;
            border-radius: 20px;
            background: white;
            box-shadow: 0 8px 30px rgb(0 0 0 / 7%);
        }

        h1 { margin: 0 0 12px; color: #105361; }
        p { line-height: 1.6; color: #526365; }

        a {
            display: inline-block;
            margin-top: 18px;
            padding: 13px 24px;
            border-radius: 30px;
            background: #105361;
            color: white;
            font-weight: bold;
            text-decoration: none;
        }
    </style>
    <link rel="stylesheet" href="{{ asset('css/sigana-theme.css') }}?v=3">
    <script src="{{ asset('js/sigana-theme.js') }}" defer></script>
</head>
<body>
    <main>
        <h1>Selamat datang di SIGANA</h1>
        <p>
            Anda sedang mengakses SIGANA sebagai tamu. Informasi publik dapat
            ditampilkan di halaman ini.
        </p>
        <a href="{{ route('login') }}">Masuk ke akun</a>
    </main>
</body>
</html>