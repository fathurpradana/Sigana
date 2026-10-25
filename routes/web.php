<?php

use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;

Route::middleware('guest')->group(function () {
    Route::get('/login', fn () => view('auth.login'))->name('login');
    Route::post('/login', [AuthController::class, 'login']);

    Route::get('/register', fn () => view('auth.register'))->name('register');
    Route::post('/register', [AuthController::class, 'register']);

    Route::get('/forgot-password', fn () => view('auth.forgot-password'))
        ->name('password.request');

    Route::post('/forgot-password', [AuthController::class, 'sendResetLink'])
        ->name('password.email');

    Route::get('/reset-password/{token}', [AuthController::class, 'showResetForm'])
        ->name('password.reset');

    Route::post('/reset-password', [AuthController::class, 'resetPassword'])
        ->name('password.update');
});

Route::middleware('auth')->group(function () {
    Route::get('/', fn () => view('dashboard'))->name('dashboard');
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
});

Route::get('/beranda', function () {
    return view('dashboard');
})->name('guest.home');

Route::get('/bencana', function () {
    return view('bencana.index');
})->name('bencana.index');

Route::get('/bencana/{slug}', function (string $slug) {
    $dataBencana = [
        'gunung-anak-krakatau' => [
            'kategori' => 'Gunung Meletus',
            'status' => 'Aktif',
            'judul' => 'Gunung Anak Krakatau Kembali Erupsi',
            'waktu' => '6 Okt 2025 · 15.36 WIB',
            'wilayah' => 'Selat Sunda, Lampung',
            'deskripsi' => 'Gunung Anak Krakatau kembali mengalami erupsi yang ditandai dengan keluarnya abu vulkanik dan material dari kawah. Masyarakat diimbau menjauhi kawasan berbahaya dan mengikuti informasi resmi dari petugas dan pihak berwenang.',
            'imbauan' => [
                'Jauhi radius bahaya yang ditetapkan petugas.',
                'Gunakan masker saat abu vulkanik turun.',
                'Pantau informasi resmi dari kanal terpercaya.',
                'Ikuti arahan petugas dan segera menuju tempat aman jika diperlukan.',
                'Hindari aktivitas di sekitar kawah dan kawasan yang berisiko.',
            ],
        ],

        'gempa-ntt' => [
            'kategori' => 'Gempa',
            'status' => 'Dipantau',
            'judul' => 'Gempa Magnitudo 6,3 Guncang NTT',
            'waktu' => '4 Okt 2025 · 08.40 WIB',
            'wilayah' => 'Nusa Tenggara Timur',
            'deskripsi' => 'Gempa dirasakan di sejumlah wilayah Nusa Tenggara Timur. Warga diimbau tetap tenang, memeriksa kondisi bangunan, dan mengikuti informasi resmi.',
            'imbauan' => [
                'Lindungi kepala saat terjadi guncangan.',
                'Jauhi bangunan yang retak atau rusak.',
                'Keluar menuju area terbuka setelah guncangan berhenti.',
                'Pantau informasi resmi dari pihak berwenang.',
            ],
        ],

        'banjir-wilayah' => [
            'kategori' => 'Banjir',
            'status' => 'Aktif',
            'judul' => 'Banjir Melanda Sejumlah Wilayah',
            'waktu' => 'Hari ini',
            'wilayah' => 'Jakarta dan Jawa Barat',
            'deskripsi' => 'Hujan deras menyebabkan genangan di sejumlah wilayah. Warga diminta mengikuti arahan petugas dan mencari tempat aman jika kondisi air meningkat.',
            'imbauan' => [
                'Matikan aliran listrik jika air mulai memasuki rumah.',
                'Pindah ke tempat yang lebih tinggi dan aman.',
                'Hindari berjalan atau berkendara menerobos arus banjir.',
                'Siapkan dokumen penting dan kebutuhan darurat.',
            ],
        ],

        'tsunami-kesiapsiagaan' => [
            'kategori' => 'Tsunami',
            'status' => 'Informasi',
            'judul' => 'Kenali Tanda Peringatan Tsunami',
            'waktu' => 'Informasi kesiapsiagaan',
            'wilayah' => 'Wilayah pesisir',
            'deskripsi' => 'Gempa kuat di wilayah pesisir dapat menjadi salah satu tanda bahaya. Segera menjauh dari pantai dan ikuti peringatan resmi.',
            'imbauan' => [
                'Segera menjauh dari pantai setelah gempa kuat.',
                'Menuju tempat tinggi atau jalur evakuasi.',
                'Ikuti arahan petugas dan peringatan resmi.',
                'Jangan kembali ke pantai sebelum dinyatakan aman.',
            ],
        ],
    ];

    abort_unless(isset($dataBencana[$slug]), 404);

    return view('bencana.detail', [
        'bencana' => $dataBencana[$slug],
    ]);
})->name('bencana.detail');

Route::get('/tips', function () {
    return view('tips.index');
})->name('tips.index');

Route::get('/bantuan', function () {
    return view('bantuan.index');
})->name('bantuan.index');

Route::view('/profil', 'profil')->name('profil.index');
Route::view('/profil/edit', 'profil-edit')->name('profil.edit');

Route::view('/tentang', 'tentang')->name('tentang.index');