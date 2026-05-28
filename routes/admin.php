<?php

use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\Admin\CalonController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\FakultasController;
use App\Http\Controllers\Admin\InformasiController;
use App\Http\Controllers\Admin\KategoriController;
use App\Http\Controllers\Admin\LogController;
use App\Http\Controllers\Admin\PeriodeController;
use App\Http\Controllers\Admin\UserController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Admin Panel Routes
|--------------------------------------------------------------------------
|
| Prefix: /admin
| Name:   admin.*
| Guard:  admin (session-based)
|
*/

// ── Auth (Guest) ──────────────────────────────────────────────
Route::middleware('guest:admin')->group(function () {
    Route::get('login', [AuthController::class, 'showLoginForm'])->name('login');
    Route::post('login', [AuthController::class, 'login'])->name('login.submit');
});

// ── Authenticated ─────────────────────────────────────────────
Route::middleware('admin')->group(function () {
    Route::post('logout', [AuthController::class, 'logout'])->name('logout');

    // Dashboard
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

    // Master Data — Periode
    Route::resource('periode', PeriodeController::class)->except(['show']);

    // Master Data — Fakultas
    Route::resource('fakultas', FakultasController::class)->except(['show']);

    // Master Data — Kategori Pemilihan (Election Categories)
    Route::resource('kategori', KategoriController::class)->except(['show']);

    // Pemilihan Aktif — Calon / Paslon
    Route::resource('calon', CalonController::class)->except(['show']);

    // Informasi Lainnya (single form)
    Route::get('informasi', [InformasiController::class, 'index'])->name('informasi.index');
    Route::put('informasi', [InformasiController::class, 'update'])->name('informasi.update');

    // Akun Admin — Users
    Route::resource('users', UserController::class)->except(['show']);

    // Log Aktivitas (read-only)
    Route::get('logs', [LogController::class, 'index'])->name('logs.index');
});
