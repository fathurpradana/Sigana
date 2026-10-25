@extends('auth.layout')

@section('title', 'Daftar | SIGANA')

@section('form')
    <nav class="tabs" aria-label="Navigasi akun">
        <a class="tab" href="{{ route('login') }}">Masuk</a>
        <span class="tab active">Daftar</span>
    </nav>

    <h2 class="form-title">Buat akun SIGANA</h2>
    <p class="form-description">Daftar untuk mendapatkan informasi dan layanan SIGANA.</p>

    <form method="POST" action="{{ route('register') }}">
        @csrf

        <div class="field">
            <label for="name">Nama lengkap</label>
            <input id="name" type="text" name="name"
                   value="{{ old('name') }}"
                   placeholder="Nama lengkap"
                   autocomplete="name" required>
        </div>

        <div class="field">
            <label for="email">Email</label>
            <input id="email" type="email" name="email"
                   value="{{ old('email') }}"
                   placeholder="nama@email.com"
                   autocomplete="email" required>
        </div>

        <div class="field">
            <label for="password">Kata sandi</label>
            <input id="password" type="password" name="password"
                   placeholder="Minimal 8 karakter"
                   autocomplete="new-password" required>
        </div>

        <div class="field">
            <label for="password_confirmation">Ulangi kata sandi</label>
            <input id="password_confirmation" type="password"
                   name="password_confirmation"
                   placeholder="Masukkan ulang kata sandi"
                   autocomplete="new-password" required>
        </div>

        <button class="submit-button" type="submit">Daftar</button>
    </form>

    <a class="text-link" href="{{ route('login') }}">Sudah punya akun? Masuk</a>
@endsection