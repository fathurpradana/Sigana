@extends('auth.layout')

@section('title', 'Atur Ulang Kata Sandi | SIGANA')

@section('form')
    <h2 class="form-title">Atur ulang kata sandi</h2>
    <p class="form-description">Buat kata sandi baru untuk akun SIGANA Anda.</p>

    <form method="POST" action="{{ route('password.update') }}">
        @csrf

        <input type="hidden" name="token" value="{{ $token }}">

        <div class="field">
            <label for="email">Email</label>
            <input id="email" type="email" name="email"
                   value="{{ old('email', $email) }}"
                   autocomplete="email" required>
        </div>

        <div class="field">
            <label for="password">Kata sandi baru</label>
            <input id="password" type="password" name="password"
                   placeholder="Minimal 8 karakter"
                   autocomplete="new-password" required>
        </div>

        <div class="field">
            <label for="password_confirmation">Ulangi kata sandi baru</label>
            <input id="password_confirmation" type="password"
                   name="password_confirmation"
                   placeholder="Masukkan ulang kata sandi"
                   autocomplete="new-password" required>
        </div>

        <button class="submit-button" type="submit">Simpan kata sandi baru</button>
    </form>
@endsection