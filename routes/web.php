<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DisasterController;
use App\Http\Controllers\TipsController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DisasterReportController;
use App\Http\Controllers\NotificationController;
use Illuminate\Support\Facades\DB;
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
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
    Route::get('/profil/edit', [ProfileController::class, 'edit'])->name('profil.edit');
    Route::get('/profil/foto', [ProfileController::class, 'photo'])->name('profil.photo');
    Route::put('/profil', [ProfileController::class, 'update'])->name('profil.update');
    Route::post('/notifikasi/dibaca', [NotificationController::class, 'markAllRead'])->name('notifications.read-all');
    Route::get('/notifikasi/{id}/buka', [NotificationController::class, 'open'])->whereNumber('id')->name('notifications.open');
    Route::post('/profil/notifikasi', [ProfileController::class, 'updateNotificationPreference'])
    ->name('profil.notifications');
});

Route::get('/beranda', [DashboardController::class, 'index'])->name('guest.home');

Route::get('/bencana', [DisasterController::class, 'index'])->name('bencana.index');
Route::get('/bencana/{id}', [DisasterController::class, 'show'])->whereNumber('id')->name('bencana.detail');

Route::get('/tips', [TipsController::class, 'index'])->name('tips.index');

Route::get('/bantuan', function () {
    return view('bantuan.index', [
        'categories' => DB::table('disaster_categories')->orderBy('name')->get(),
        'page' => 'help',
    ]);
})->name('bantuan.index');

Route::get('/bantuan/lapor', function () {
    return view('bantuan.index', [
        'categories' => DB::table('disaster_categories')->orderBy('name')->get(),
        'page' => 'report',
    ]);
})->name('bantuan.report.form');

Route::post('/bantuan/laporan', [DisasterReportController::class, 'store'])
    ->name('bantuan.report');

Route::get('/profil', [ProfileController::class, 'show'])->name('profil.index');

Route::view('/tentang', 'tentang')->name('tentang.index');