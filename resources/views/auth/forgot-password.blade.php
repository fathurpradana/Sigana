@extends('auth.layout')

@section('title', 'Lupa Kata Sandi | SIGANA')

@section('form')
    <h2 class="form-title">Lupa kata sandi?</h2>
    <p class="form-description">
        Masukkan email akun Anda. Laravel akan mengirimkan link untuk mengatur ulang kata sandi.
    </p>

    <form method="POST" action="{{ route('password.email') }}">
        @csrf

        <div class="field">
            <label for="email">Email</label>
            <input id="email" type="email" name="email"
                   value="{{ old('email') }}"
                   placeholder="nama@email.com"
                   autocomplete="email" required autofocus>
        </div>

        <button class="submit-button" type="submit">Kirim link reset</button>
    </form>

    <a class="text-link" href="{{ route('login') }}">Kembali ke halaman masuk</a>
@endsection