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
use App\Http\Controllers\Admin\NotificationController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Muzaki\MuzakiController;
use App\Http\Controllers\Muzaki\TransaksiController;

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
Route::prefix('admin')->name('admin.')->group(function () {
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
    Route::get('/laporan/{id}', [LaporanZakatController::class, 'show'])->name('laporan-zakat.show');
    Route::get('/laporan/{id}/edit', [LaporanZakatController::class, 'edit'])->name('laporan-zakat.edit');
    Route::put('/laporan/{id}', [LaporanZakatController::class, 'update'])->name('laporan-zakat.update');
    Route::delete('/laporan/{id}', [LaporanZakatController::class, 'destroy'])->name('laporan-zakat.destroy');
    Route::get('laporan-zakat/distribusi/{id}', [LaporanZakatController::class, 'showDistribusi'])->name('laporan-zakat.show-distribusi');
    Route::get('laporan-zakat/distribusi/{id}/edit', [LaporanZakatController::class, 'editDistribusi'])->name('laporan-zakat.edit-distribusi');
    Route::put('laporan-zakat/distribusi/{id}', [LaporanZakatController::class, 'updateDistribusi'])->name('laporan-zakat.update-distribusi');
    Route::delete('laporan-zakat/distribusi/{id}', [LaporanZakatController::class, 'destroyDistribusi'])->name('laporan-zakat.destroy-distribusi');


    Route::get('/pengaturan', [PengaturanController::class, 'index'])->name('pengaturan.index');
    Route::get('/ketentuan', [KetentuanZakatController::class, 'index'])->name('ketentuan.index');
    Route::post('/ketentuan', [KetentuanZakatController::class, 'store'])->name('ketentuan.store');
    Route::delete('/ketentuan/{ketentuan}', [KetentuanZakatController::class, 'destroy'])->name('ketentuan.destroy');
    Route::post('/pengaturan/update', [PengaturanController::class, 'update'])->name('pengaturan.update');

    Route::get('/notifikasi', [NotificationController::class, 'index'])->name('notifikasi.index');
    Route::post('/notifikasi/baca/{id}', [NotificationController::class, 'markAsRead'])->name('notifikasi.baca');
    Route::get('/notifikasi/{id}', [NotificationController::class, 'show'])->name('notifikasi.show');

    Route::get('/zakat/{id}', [LaporanZakatController::class, 'show'])->name('zakat.show');



});

// 🙋 Muzakki Routes (role-based)
Route::prefix('muzaki')->name('muzaki.')->group(function () {
    Route::get('/dashboard', [MuzakiController::class, 'dashboard'])->name('dashboard');
    Route::get('/bayar-zakat', [MuzakiController::class, 'formPembayaran'])->name('bayar');
    Route::get('/kalkulator-zakat', [MuzakiController::class, 'kalkulator'])->name('kalkulator');
    Route::get('/riwayat', [MuzakiController::class, 'riwayat'])->name('riwayat');
    Route::get('/informasi-zakat', [MuzakiController::class, 'informasi'])->name('informasi');
    Route::post('/transaksi/store', [TransaksiController::class, 'store'])->name('transaksi.store');
});

Route::get('/publish', function () {
    return view('publish');
})->name('publish');

// Autentikasi Breeze
require __DIR__.'/auth.php';
