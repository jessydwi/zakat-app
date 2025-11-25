<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
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
use App\Http\Controllers\Admin\ProfileController;
use App\Http\Controllers\Muzaki\MuzakiController;
use App\Http\Controllers\Muzaki\TransaksiController;
use App\Http\Controllers\Muzaki\NotifikasiController;
use App\Http\Controllers\PublishController;
use App\Http\Controllers\DashboardController;



/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// 🔑 Login
Route::get('/login', [AuthenticatedSessionController::class, 'create'])
    ->middleware('guest')
    ->name('login');
Route::post('/login', [AuthenticatedSessionController::class, 'store'])
    ->middleware('guest');

// Root → login
Route::get('/', fn () => redirect()->route('login'));

// 📊 Dashboard (hanya untuk user aktif & terverifikasi)
Route::middleware(['auth', 'verified', 'check.active'])->group(function () {
    Route::get('/dashboard', [\App\Http\Controllers\DashboardController::class, 'index'])->name('dashboard');
});

// 👤 Profil user
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});


// Group route khusus admin
Route::prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [AdminController::class, 'index'])->name('dashboard');
    Route::resource('manajemen-zakat', ManajemenZakatController::class);


    // Detail transfer (custom)
    Route::get('/transaksi/detail-transfer', [TransaksiZakatController::class, 'detailTransfer'])
        ->name('transaksi.detail-transfer');

    // Konfirmasi transfer (custom)
    Route::post('/transaksi/konfirmasi-transfer', [TransaksiZakatController::class, 'konfirmasiTransfer'])
        ->name('transaksi.konfirmasi-transfer');


    Route::resource('transaksi', TransaksiZakatController::class);
    Route::post('transaksi/{id}/konfirmasi', [TransaksiZakatController::class, 'konfirmasi'])->name('admin.transaksi.konfirmasi');

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
    Route::get('laporan-zakat/export-pdf', [LaporanZakatController::class, 'exportPdf'])->name('laporan-zakat.export-pdf');
    Route::get('laporan-zakat/export-rekap-distribusi-pdf', [LaporanZakatController::class, 'exportDistribusiRekapPdf'])->name('laporan-zakat.export-rekap-distribusi-pdf');


    Route::get('/pengaturan', [PengaturanController::class, 'index'])->name('pengaturan.index');
    Route::get('/ketentuan', [KetentuanZakatController::class, 'index'])->name('ketentuan.index');
    Route::post('/ketentuan', [KetentuanZakatController::class, 'store'])->name('ketentuan.store');
    Route::delete('/ketentuan/{ketentuan}', [KetentuanZakatController::class, 'destroy'])->name('ketentuan.destroy');
    Route::post('/pengaturan/update', [PengaturanController::class, 'update'])->name('pengaturan.update');

    Route::get('/notifikasi', [NotificationController::class, 'index'])->name('notifikasi.index');
    Route::post('/notifikasi/baca/{id}', [NotificationController::class, 'markAsRead'])->name('notifikasi.baca');
    Route::get('/notifikasi/{id}', [NotificationController::class, 'show'])->name('notifikasi.show');

    Route::get('/zakat/{id}', [LaporanZakatController::class, 'show'])->name('zakat.show');
    Route::get('/profile', [ProfileController::class, 'index'])->name('profile.index');
    Route::post('/profile/update', [ProfileController::class, 'update'])->name('profile.update');

    Route::patch('/users/{id}/deactivate', [UserController::class, 'deactivate'])->name('users.deactivate');
    Route::patch('/users/{id}/activate', [UserController::class, 'activate'])->name('users.activate');




});

// 🙋 Muzakki Routes (role-based)
Route::middleware(['auth'])->prefix('muzaki')->name('muzaki.')->group(function () {
    Route::get('/dashboard', [MuzakiController::class, 'dashboard'])->name('dashboard');
    Route::get('/bayar-zakat', [MuzakiController::class, 'formPembayaran'])->name('bayar');
    Route::get('/kalkulator-zakat', [MuzakiController::class, 'kalkulator'])->name('kalkulator');
    Route::post('/kalkulator-zakat/hitung', [MuzakiController::class, 'hitung'])->name('kalkulator.hitung');
    Route::get('/riwayat', [MuzakiController::class, 'riwayat'])->name('riwayat');
    Route::get('/informasi-zakat', [MuzakiController::class, 'informasi'])->name('informasi');
    Route::get('/transaksi/create', [TransaksiController::class, 'create'])->name('transaksi.create');
    Route::post('/transaksi/store', [TransaksiController::class, 'store'])->name('transaksi.store');
    Route::get('/profil', [MuzakiController::class, 'profil'])->name('profil');
    Route::post('/profil', [MuzakiController::class, 'updateProfil'])->name('profil.update');
    Route::match(['get','post'], '/transaksi/detail-transfer', [MuzakiController::class, 'detailTransfer'])->name('transaksi.detail-transfer');
    Route::get('/bukti/{id}', [MuzakiController::class, 'showBukti'])->name('bukti');
});

// 📦 Publik & Misc
Route::get('/publish', function () {
    return view('publish');
})->name('publish');

Route::get('/publish', [PublishController::class, 'index'])->name('publish');


// Route::get('/publish', fn () => view('publish'))->name('publish');
Route::get('/home', fn () => view('publish'))->name('publish');
Route::get('/welcome', fn () => view('welcome'))->name('welcome');

// Autentikasi Breeze
require __DIR__.'/auth.php';