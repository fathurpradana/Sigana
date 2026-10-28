<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DisasterController;
use App\Http\Controllers\TipsController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DisasterReportController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\AdminDashboardController;
use App\Http\Controllers\AdminController;
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
    Route::get('/', function (DashboardController $dashboard) {
        if (auth()->user()->role === 'admin') {
            return redirect()->route('admin.dashboard');
        }

        return $dashboard->index();
    })->name('dashboard');

    Route::prefix('admin')->name('admin.')->middleware('admin')->group(function () {
        Route::get('/', [AdminDashboardController::class, 'index'])->name('dashboard');
        Route::get('/kelola', [AdminController::class, 'index'])->name('manage');
        Route::post('/bencana', [AdminController::class, 'storeDisaster'])->name('disasters.store');
        Route::put('/bencana/{id}/verifikasi', [AdminController::class, 'verifyDisaster'])->whereNumber('id')->name('disasters.verify');
        Route::put('/bencana/{id}', [AdminController::class, 'updateDisaster'])->whereNumber('id')->name('disasters.update');
        Route::delete('/bencana/{id}', [AdminController::class, 'destroyDisaster'])->whereNumber('id')->name('disasters.destroy');
        Route::post('/kategori', [AdminController::class, 'storeCategory'])->name('categories.store');
        Route::put('/kategori/{id}', [AdminController::class, 'updateCategory'])->whereNumber('id')->name('categories.update');
        Route::delete('/kategori/{id}', [AdminController::class, 'destroyCategory'])->whereNumber('id')->name('categories.destroy');
        Route::post('/tips', [AdminController::class, 'storeTip'])->name('tips.store');
        Route::put('/tips/{id}', [AdminController::class, 'updateTip'])->whereNumber('id')->name('tips.update');
        Route::delete('/tips/{id}', [AdminController::class, 'destroyTip'])->whereNumber('id')->name('tips.destroy');
        Route::post('/kontak-darurat', [AdminController::class, 'storeContact'])->name('contacts.store');
        Route::put('/kontak-darurat/{id}', [AdminController::class, 'updateContact'])->whereNumber('id')->name('contacts.update');
        Route::delete('/kontak-darurat/{id}', [AdminController::class, 'destroyContact'])->whereNumber('id')->name('contacts.destroy');
        Route::post('/informasi', [AdminController::class, 'storeInformation'])->name('information.store');
        Route::put('/informasi/{id}', [AdminController::class, 'updateInformation'])->whereNumber('id')->name('information.update');
        Route::delete('/informasi/{id}', [AdminController::class, 'destroyInformation'])->whereNumber('id')->name('information.destroy');
        Route::put('/pengguna/{id}/role', [AdminController::class, 'updateUserRole'])->whereNumber('id')->name('users.role');
        Route::delete('/pengguna/{id}', [AdminController::class, 'destroyUser'])->whereNumber('id')->name('users.destroy');
        Route::post('/pengumuman', [AdminController::class, 'storeAnnouncement'])->name('announcements.store');
        Route::delete('/notifikasi/{id}', [AdminController::class, 'destroyNotification'])->whereNumber('id')->name('notifications.destroy');
    });
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
    Route::get('/profil/edit', [ProfileController::class, 'edit'])->name('profil.edit');
    Route::get('/profil/foto', [ProfileController::class, 'photo'])->name('profil.photo');
    Route::put('/profil', [ProfileController::class, 'update'])->name('profil.update');
    Route::post('/profil/notifikasi', [ProfileController::class, 'updateNotificationPreference'])
    ->name('profil.notifications');
});

Route::post('/notifikasi/dibaca', [NotificationController::class, 'markAllRead'])->name('notifications.read-all');
Route::post('/notifikasi/{id}/dibaca', [NotificationController::class, 'markRead'])->whereNumber('id')->name('notifications.read');
Route::get('/notifikasi/{id}/buka', [NotificationController::class, 'open'])->whereNumber('id')->name('notifications.open');

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

Route::middleware('auth')->group(function () {
    Route::get('/bantuan/lapor', function () {
        return view('bantuan.index', [
            'categories' => DB::table('disaster_categories')->orderBy('name')->get(),
            'page' => 'report',
        ]);
    })->name('bantuan.report.form');

    Route::post('/bantuan/laporan', [DisasterReportController::class, 'store'])
        ->name('bantuan.report');
});

Route::get('/profil', [ProfileController::class, 'show'])->name('profil.index');

Route::get('/tentang', function () {
    $information = DB::table('general_information')
        ->where(function ($query) {
            $query->whereNull('published_at')->orWhere('published_at', '<=', now());
        })
        ->orderByDesc('published_at')
        ->orderByDesc('id')
        ->get();

    return view('tentang', compact('information'));
})->name('tentang.index');