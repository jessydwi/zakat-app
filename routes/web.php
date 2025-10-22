<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\MuzakiController;
use App\Http\Controllers\TransaksiController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// Route login
Route::get('/login', [AuthenticatedSessionController::class, 'create'])
    ->middleware('guest')
    ->name('login');

Route::post('/login', [AuthenticatedSessionController::class, 'store'])
    ->middleware('guest');

// Redirect root URL langsung ke halaman login
Route::get('/', function () {
    return redirect()->route('login');
});

// Dashboard umum (untuk semua user login dan terverifikasi)
Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

// Group route untuk user login
Route::middleware('auth')->group(function () {
    // Profil user
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Group route khusus admin
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [AdminController::class, 'index'])->name('dashboard');

    // Tambahan route admin bisa kamu letakkan di sini
    // Route::resource('/zakat', ZakatController::class);
    // Route::get('/laporan', [LaporanController::class, 'index'])->name('laporan');
});

Route::middleware(['auth'])->group(function () {
    Route::get('/muzaki/dashboard', [MuzakiController::class, 'dashboard'])->name('muzaki.dashboard');
    Route::get('/bayar-zakat', [MuzakiController::class, 'formPembayaran'])->name('muzaki.bayar');
    Route::get('/kalkulator-zakat', [MuzakiController::class, 'kalkulator'])->name('muzaki.kalkulator');
    Route::get('/riwayat', [MuzakiController::class, 'riwayat'])->name('muzaki.riwayat');
    Route::get('/informasi-zakat', [MuzakiController::class, 'informasi'])->name('muzaki.informasi');
    Route::post('/transaksi/store', [TransaksiController::class, 'store'])->name('transaksi.store');
});

// Autentikasi Breeze
require __DIR__.'/auth.php';
