@extends('auth.layout')

@section('title', 'Masuk | SIGANA')

@section('form')
    <nav class="tabs" aria-label="Navigasi akun">
        <span class="tab active">Masuk</span>
        <a class="tab" href="{{ route('register') }}">Daftar</a>
    </nav>

    <form method="POST" action="{{ route('login') }}">
        @csrf

        <div class="field">
            <label for="email">Email</label>
            <input id="email" type="email" name="email"
                   value="{{ old('email') }}"
                   placeholder="nama@email.com"
                   autocomplete="email" required autofocus>
        </div>

        <div class="field">
            <label for="password">Kata sandi</label>
            <input id="password" type="password" name="password"
                   placeholder="Masukkan kata sandi"
                   autocomplete="current-password" required>
        </div>

        <a class="text-link" href="{{ route('password.request') }}"
           style="text-align:right; margin: -4px 0 20px;">
            Lupa kata sandi?
        </a>

        <button class="submit-button" type="submit">Masuk</button>
    </form>

    <div style="display:flex;align-items:center;gap:14px;margin:22px 0;color:#7b8583;font-size:13px;">
        <span style="height:1px;flex:1;background:#e1e4e0"></span>
        atau
        <span style="height:1px;flex:1;background:#e1e4e0"></span>
    </div>

    <a class="guest-button" href="{{ route('guest.home') }}">
        Lanjutkan sebagai tamu
    </a>
@endsection