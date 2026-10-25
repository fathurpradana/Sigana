<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Akun SIGANA')</title>

    <style>
        * { box-sizing: border-box; }

        :root {
            --teal: #105361;
            --teal-dark: #0d4652;
            --text: #183b42;
            --muted: #e7e9e5;
            --page: #f4f4f1;
        }

        html, body {
            width: 100%;
            min-height: 100%;
            margin: 0;
        }

        body {
            min-height: 100vh;
            min-height: 100dvh;
            color: var(--text);
            background: var(--page);
            font-family: Arial, Helvetica, sans-serif;
        }

        .auth-page {
            min-height: 100vh;
            min-height: 100dvh;
            display: grid;
            grid-template-columns: 1fr 1fr;
        }

        .brand-panel {
            display: flex;
            align-items: center;
            justify-content: center;
            padding: clamp(32px, 8vw, 120px);
            background: var(--teal);
            color: #fff;
        }

        .brand-content { width: min(100%, 480px); }

        .brand-icon {
            width: 56px;
            height: 56px;
            display: grid;
            place-items: center;
            margin-bottom: 22px;
            border-radius: 13px;
            background: #fff;
            color: var(--teal);
        }

        .brand-icon svg { width: 31px; height: 31px; }

        .brand-title {
            margin: 0 0 10px;
            font-size: clamp(38px, 5vw, 58px);
            line-height: 1;
        }

        .brand-description {
            max-width: 380px;
            margin: 0;
            color: #d4e4e6;
            font-size: 16px;
            line-height: 1.6;
        }

        .form-panel {
            display: flex;
            align-items: center;
            justify-content: center;
            padding: clamp(28px, 7vw, 100px);
            background: var(--page);
        }

        .form-content { width: min(100%, 430px); }

        .tabs {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 4px;
            padding: 4px;
            margin-bottom: 30px;
            border-radius: 999px;
            background: var(--muted);
        }

        .tab {
            min-height: 46px;
            display: grid;
            place-items: center;
            border-radius: 999px;
            color: #526365;
            text-decoration: none;
            font-size: 14px;
        }

        .tab.active {
            background: white;
            color: var(--teal);
            font-weight: 700;
        }

        .form-title {
            margin: 0 0 8px;
            font-size: 25px;
        }

        .form-description {
            margin: 0 0 24px;
            color: #657574;
            font-size: 14px;
            line-height: 1.5;
        }

        .field { margin-bottom: 18px; }

        .field label {
            display: block;
            margin-bottom: 8px;
            font-size: 14px;
            font-weight: 700;
        }

        .field input {
            width: 100%;
            height: 50px;
            padding: 0 14px;
            border: 1px solid #dfe4e1;
            border-radius: 11px;
            outline: none;
            background: #fff;
            color: var(--text);
            font: inherit;
            font-size: 14px;
        }

        .field input:focus {
            border-color: var(--teal);
            box-shadow: 0 0 0 3px rgb(16 83 97 / 12%);
        }

        .field input::placeholder { color: #9aa6a5; }

        .submit-button, .guest-button {
            width: 100%;
            min-height: 50px;
            display: grid;
            place-items: center;
            border-radius: 999px;
            font: inherit;
            font-size: 14px;
            font-weight: 700;
            cursor: pointer;
        }

        .submit-button {
            border: 0;
            background: var(--teal);
            color: white;
        }

        .submit-button:hover { background: var(--teal-dark); }

        .guest-button {
            border: 1px solid #dfe4e1;
            background: white;
            color: var(--text);
            text-decoration: none;
        }

        .text-link {
            display: block;
            margin-top: 18px;
            color: var(--teal);
            text-align: center;
            text-decoration: none;
            font-size: 13px;
            font-weight: 700;
        }

        .text-link:hover, .tab:hover { text-decoration: underline; }

        .message {
            margin-bottom: 16px;
            padding: 12px 14px;
            border-radius: 10px;
            font-size: 13px;
        }

        .message.error {
            border: 1px solid #f1c6c2;
            background: #fff2f0;
            color: #9d3026;
        }

        .message.success {
            border: 1px solid #b9dfc5;
            background: #effaf2;
            color: #22643b;
        }

        @media (max-width: 760px) {
            .auth-page { grid-template-columns: 1fr; }

            .brand-panel {
                min-height: 220px;
                justify-content: flex-start;
                padding: 30px clamp(24px, 8vw, 60px);
            }

            .brand-icon {
                width: 46px;
                height: 46px;
                margin-bottom: 14px;
            }

            .brand-title { font-size: 36px; }
            .brand-description { font-size: 14px; }

            .form-panel { padding: 36px 24px 48px; }
        }
    </style>
</head>

<body>
    <main class="auth-page">
        <section class="brand-panel">
            <div class="brand-content">
                <div class="brand-icon" aria-hidden="true">
                    <svg viewBox="0 0 32 32" fill="none">
                        <path d="M5 20c3 0 3-8 6-8s3 8 6 8 3-8 6-8"
                              stroke="currentColor" stroke-width="2.2"
                              stroke-linecap="round"/>
                        <circle cx="24" cy="8" r="2.5" fill="#e06445"/>
                    </svg>
                </div>
                <h1 class="brand-title">SIGANA</h1>
                <p class="brand-description">
                    Informasi bencana alam yang terpercaya, dekat dengan Anda.
                </p>
            </div>
        </section>

        <section class="form-panel">
            <div class="form-content">
                @if (session('status'))
                    <div class="message success" role="status">{{ session('status') }}</div>
                @endif

                @if ($errors->any())
                    <div class="message error" role="alert">
                        {{ $errors->first() }}
                    </div>
                @endif

                @yield('form')
            </div>
        </section>
    </main>
</body>
</html>