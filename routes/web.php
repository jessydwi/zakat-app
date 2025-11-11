<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\ManajemenZakatController;
use App\Http\Controllers\Admin\TransaksiZakatController;
use App\Http\Controllers\Admin\DistribusiZakatController;
use App\Http\Controllers\Admin\ManajemenMustahikController;
use App\Http\Controllers\Admin\LaporanZakatController;
use App\Http\Controllers\Admin\PengaturanController;
use App\Http\Controllers\Admin\KetentuanZakatController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Muzakki\MuzakiController;
use App\Http\Controllers\Muzakki\TransaksiController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// 🔒 Guest Routes
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthenticatedSessionController::class, 'create'])->name('login');
    Route::post('/login', [AuthenticatedSessionController::class, 'store']);
});

// 🔁 Redirect root to login
Route::get('/', fn () => redirect()->route('login'));

// 🏠 Default dashboard (fallback)
Route::get('/dashboard', fn () => view('dashboard'))
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

// 👤 Profile Routes
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// 🛡️ Admin Routes
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [AdminController::class, 'index'])->name('dashboard');
    Route::get('/manajemen-zakat', [ManajemenZakatController::class, 'index'])->name('manajemen-zakat.index');
    Route::get('/zakat/create', [TransaksiZakatController::class, 'create'])->name('zakat.create');
    Route::resource('transaksi', TransaksiZakatController::class);
    Route::post('transaksi/{id}/konfirmasi', [TransaksiZakatController::class, 'konfirmasi'])->name('transaksi.konfirmasi');
    Route::resource('distribusi', DistribusiZakatController::class);
    Route::get('/distribusi/cetak', [DistribusiZakatController::class, 'cetak'])->name('distribusi.cetak');
    Route::get('/manajemen-mustahik', [ManajemenMustahikController::class, 'index'])->name('manajemen-mustahik.index');
    Route::resource('mustahik', ManajemenMustahikController::class);
    Route::get('/laporan', [LaporanZakatController::class, 'index'])->name('laporan.index');
    Route::resource('users', UserController::class);
    Route::get('/pengaturan', [PengaturanController::class, 'index'])->name('pengaturan.index');
    Route::get('/ketentuan', [KetentuanZakatController::class, 'index'])->name('ketentuan.index');
    Route::post('/ketentuan', [KetentuanZakatController::class, 'store'])->name('ketentuan.store');
    Route::delete('/ketentuan/{id}', [KetentuanZakatController::class, 'destroy'])->name('ketentuan.destroy');
});

// 🙋 Muzakki Routes (role-based)
Route::middleware(['auth', 'role:muzakki'])->prefix('muzakki')->name('muzakki.')->group(function () {
    Route::get('/dashboard', [MuzakiController::class, 'dashboard'])->name('dashboard');
    Route::get('/bayar-zakat', [MuzakiController::class, 'formPembayaran'])->name('bayar');
    Route::get('/kalkulator-zakat', [MuzakiController::class, 'kalkulator'])->name('kalkulator');
    Route::get('/riwayat', [MuzakiController::class, 'riwayat'])->name('riwayat');
    Route::get('/informasi-zakat', [MuzakiController::class, 'informasi'])->name('informasi');
    Route::post('/transaksi/store', [TransaksiController::class, 'store'])->name('transaksi.store');
});

// 📦 Publik & Misc
Route::get('/home', fn () => view('publish'))->name('publish');
Route::get('/welcome', fn () => view('welcome'))->name('welcome');

// 🔐 Auth scaffolding
require __DIR__.'/auth.php';
