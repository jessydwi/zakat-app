<?php

namespace App\Http\Controllers\Muzaki;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\TransaksiZakat;
use App\Models\JenisZakat;
use App\Models\MetodePembayaran;
use App\Models\Muzakki;

class MuzakiController extends Controller
{
    // ✅ Dashboard Muzaki
public function dashboard()
{
    $user = Auth::user();

    if ($user->role !== 'muzaki') {
        abort(403, 'Unauthorized');
    }

    // Ambil data muzakki
    $muzakki = Muzakki::where('user_id', $user->id)->first();
    if (!$muzakki) {
        return back()->with('error', 'Data muzakki tidak ditemukan.');
    }

    $muzakkiId = $muzakki->id;

    // Total zakat berdasarkan jenis (hanya yang sudah terkonfirmasi)
    $zakatFitrah = TransaksiZakat::where('muzakki_id', $muzakkiId)
        ->whereHas('jenisZakat', fn($q) => $q->where('nama_jenis', 'fitrah'))
        ->where('status', 'terbayar')
        ->sum('nominal');

    $zakatMal = TransaksiZakat::where('muzakki_id', $muzakkiId)
        ->whereHas('jenisZakat', fn($q) => $q->where('nama_jenis', 'mal'))
        ->where('status', 'terbayar')
        ->sum('nominal');

    $zakatFidyah = TransaksiZakat::where('muzakki_id', $muzakkiId)
        ->whereHas('jenisZakat', fn($q) => $q->where('nama_jenis', 'fidyah'))
        ->where('status', 'terbayar')
        ->sum('nominal');

    $zakatInfak = TransaksiZakat::where('muzakki_id', $muzakkiId)
        ->whereHas('jenisZakat', fn($q) => $q->where('nama_jenis', 'infak'))
        ->where('status', 'terbayar')
        ->sum('nominal');


    // Total zakat semua jenis
    $totalZakat = $zakatFitrah + $zakatMal + $zakatFidyah + $zakatInfak;

    // Jumlah penerima manfaat (opsional)
    $totalPenerima = DB::table('mustahik')->count();

    // Grafik zakat pribadi per bulan (hanya yang terkonfirmasi)
$grafikZakat = TransaksiZakat::select(
    DB::raw("EXTRACT(MONTH FROM tanggal) AS bulan"),
    DB::raw("SUM(nominal) AS total")
)
->where('muzakki_id', $muzakkiId)
->where('status', 'terkonfirmasi')
->whereYear('tanggal', now()->year)
->groupBy(DB::raw("EXTRACT(MONTH FROM tanggal)"))
->orderBy(DB::raw("EXTRACT(MONTH FROM tanggal)"))
->get();

    // Riwayat transaksi zakat pribadi (semua status)
    $riwayatZakat = TransaksiZakat::with('jenisZakat')
        ->where('muzakki_id', $muzakkiId)
        ->latest('tanggal')
        ->take(5)
        ->get();

    return view('muzaki.dashboard', compact(
        'zakatFitrah',
        'zakatMal',
        'zakatFidyah',
        'zakatInfak',
        'totalZakat',
        'totalPenerima',
        'riwayatZakat'
    ));
}


    // ✅ Form Pembayaran Zakat
    public function formPembayaran()
    {
        $user = Auth::user();

        if ($user->role !== 'muzaki') {
            abort(403, 'Unauthorized');
        }

        $jenisZakat = JenisZakat::all();
        $metodePembayaran = MetodePembayaran::where('status_aktif', true)->get();

        return view('muzaki.form-pembayaran', compact('jenisZakat', 'metodePembayaran'));
    }

    // ✅ Simpan Pembayaran Zakat
    public function storePembayaran(Request $request)
    {
        $user = Auth::user();

        if ($user->role !== 'muzaki') {
            abort(403, 'Unauthorized');
        }

        $request->validate([
            'jenis_zakat_id' => 'required|exists:jenis_zakat,id',
            'metode_id'      => 'required|exists:metode_pembayaran,id',
            'tanggal'        => 'required|date',
            'kontak'         => 'required|string|max:100',
            'nominal'        => 'required|numeric|min:1',
        ]);

        $muzakki = Muzakki::where('user_id', $user->id)->first();
        if (!$muzakki) {
            return back()->withErrors(['muzakki_id' => 'Data muzakki tidak ditemukan.']);
        }

        $detail = $request->except([
            '_token','jenis_zakat_id','metode_id','tanggal','kontak','nominal'
        ]);

        TransaksiZakat::create([
            'muzakki_id'     => $muzakki->id,   // ✅ gunakan id dari tabel muzakki
            'jenis_zakat_id' => $request->jenis_zakat_id,
            'metode_id'      => $request->metode_id,
            'tanggal'        => $request->tanggal,
            'kontak'         => $request->kontak,
            'nominal'        => $request->nominal,
            'status'         => 'menunggu',
            'detail'         => json_encode($detail),
        ]);

        return redirect()->route('muzaki.dashboard')
            ->with('success', 'Pembayaran zakat berhasil disimpan. Tunggu konfirmasi dari admin.');
    }

    // ✅ Kalkulator Zakat
    public function kalkulator()
    {
        $user = Auth::user();

        if ($user->role !== 'muzaki') {
            abort(403);
        }

        $jenisZakat = JenisZakat::all();

        return view('muzaki.kalkulator', compact('jenisZakat'));
    }

    // ✅ Riwayat Transaksi Zakat
    public function riwayat()
    {
        $user = auth()->user();

        // Pastikan user punya relasi ke tabel muzakki
        $muzakki = Muzakki::where('user_id', $user->id)->first();

        if (!$muzakki) {
            return back()->with('error', 'Data muzakki tidak ditemukan.');
        }

        // Ambil semua transaksi milik muzakki ini
        $riwayat = TransaksiZakat::with('jenisZakat')
                    ->where('muzakki_id', $muzakki->id)
                    ->orderBy('tanggal', 'DESC')
                    ->get();

        return view('muzaki.riwayat', compact('riwayat'));
    }

    // ✅ Informasi & Edukasi
    public function informasi()
    {
        $user = Auth::user();

        if ($user->role !== 'muzaki') {
            abort(403);
        }

        return view('muzaki.informasi');
    }

    // ✅ Profil Muzaki
    public function profil()
    {
    $user = Auth::user();

    if ($user->role !== 'muzaki') {
        abort(403);
    }

    // Ambil data muzakki
    $muzakki = Muzakki::where('user_id', $user->id)->first();

    if (!$muzakki) {
        return back()->with('error', 'Data muzakki tidak ditemukan.');
    }

    return view('muzaki.profil', compact('user', 'muzakki'));
    }


public function updateProfil(Request $request)
{
    $user = Auth::user();

    if ($user->role !== 'muzaki') {
        abort(403, 'Akses ditolak');
    }

    // VALIDASI (nama input HARUS sama dengan form)
    $request->validate([
        'email'         => 'required|email|unique:users,email,' . $user->id,
        'nama'          => 'required|string|max:100',
        'email_muzakki' => 'required|email',
        'no_hp'         => 'required|string|max:50',
        'pekerjaan'     => 'required|string|max:100',
        'alamat'        => 'required|string|max:255',
    ]);

    // UPDATE tabel users
    $user->update([
        'email' => $request->email,
        'name'  => $request->nama,
    ]);

    // Pastikan relasi muzakki ada
    if (!$user->muzakki) {
        return back()->with('error', 'Data Muzakki tidak ditemukan.');
    }

    // UPDATE tabel muzakki
    $user->muzakki->update([
        'email'     => $request->email_muzakki,
        'no_hp'     => $request->no_hp,
        'pekerjaan' => $request->pekerjaan,
        'alamat'    => $request->alamat,
    ]);

    return back()->with('success', 'Profil berhasil diperbarui!');
}
}
