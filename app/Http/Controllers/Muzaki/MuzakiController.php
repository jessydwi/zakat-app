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
use App\Models\BuktiPembayaran;

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

    // Gunakan ID jenis zakat agar 100% akurat
    $zakatFitrah = TransaksiZakat::where('muzakki_id', $muzakkiId)
        ->where('jenis_zakat_id', 1)
        ->whereRaw("LOWER(status) = 'terbayar'")
        ->sum('nominal');

    $zakatMal = TransaksiZakat::where('muzakki_id', $muzakkiId)
        ->where('jenis_zakat_id', 2)
        ->whereRaw("LOWER(status) = 'terbayar'")
        ->sum('nominal');

    $zakatFidyah = TransaksiZakat::where('muzakki_id', $muzakkiId)
        ->where('jenis_zakat_id', 3)
        ->whereRaw("LOWER(status) = 'terbayar'")
        ->sum('nominal');

    $zakatInfak = TransaksiZakat::where('muzakki_id', $muzakkiId)
        ->where('jenis_zakat_id', 4)
        ->whereRaw("LOWER(status) = 'terbayar'")
        ->sum('nominal');

    // Total zakat
    $totalZakat = $zakatFitrah + $zakatMal + $zakatFidyah + $zakatInfak;

    // Riwayat transaksi
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
    $user = Auth::user();

    // Ambil data muzakki berdasarkan user_id
    $muzakki = Muzakki::where('user_id', $user->id)->first();

    if (!$muzakki) {
        return back()->with('error', 'Data muzakki tidak ditemukan.');
    }

    // Ambil transaksi berdasarkan kolom yang benar → muzakki_id
    $riwayat = TransaksiZakat::with(['jenisZakat', 'buktiPembayaran'])
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
        'nama'      => $request->nama,
        'email'     => $request->email_muzakki,
        'no_hp'     => $request->no_hp,
        'pekerjaan' => $request->pekerjaan,
        'alamat'    => $request->alamat,
    ]);

    return back()->with('success', 'Profil berhasil diperbarui!');
}
public function showBukti($id)
{
    $user = Auth::user();

    if ($user->role !== 'muzaki') {
        abort(403);
    }

    $bukti = BuktiPembayaran::with('transaksi')
        ->where('transaksi_id', $id)
        ->whereHas('transaksi', function ($query) use ($user) {
            $query->where('muzakki_id', $user->muzakki->id);
        })
        ->firstOrFail();

    return view('muzaki.bukti', compact('bukti'));
}
}
