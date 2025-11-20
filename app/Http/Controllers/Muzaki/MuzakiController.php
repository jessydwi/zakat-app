<?php

namespace App\Http\Controllers\Muzaki;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
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
        if ($user->role !== 'muzaki') abort(403);

        $muzakki = $user->muzakki;
        if (!$muzakki) return back()->with('error', 'Data muzakki tidak ditemukan.');

        $muzakkiId = $muzakki->id;

        // Total zakat per jenis
        $zakatFitrah = TransaksiZakat::whereRaw('"muzakki_id"::bigint = ?', [$muzakkiId])
            ->where('jenis_zakat_id', 1)
            ->whereRaw("LOWER(status) = 'terbayar'")
            ->sum('nominal');

        $zakatMal = TransaksiZakat::whereRaw('"muzakki_id"::bigint = ?', [$muzakkiId])
            ->where('jenis_zakat_id', 2)
            ->whereRaw("LOWER(status) = 'terbayar'")
            ->sum('nominal');

        $zakatFidyah = TransaksiZakat::whereRaw('"muzakki_id"::bigint = ?', [$muzakkiId])
            ->where('jenis_zakat_id', 3)
            ->whereRaw("LOWER(status) = 'terbayar'")
            ->sum('nominal');

        $zakatInfak = TransaksiZakat::whereRaw('"muzakki_id"::bigint = ?', [$muzakkiId])
            ->where('jenis_zakat_id', 4)
            ->whereRaw("LOWER(status) = 'terbayar'")
            ->sum('nominal');

        $totalZakat = $zakatFitrah + $zakatMal + $zakatFidyah + $zakatInfak;

        $riwayatZakat = TransaksiZakat::with('jenisZakat')
            ->whereRaw('"muzakki_id"::bigint = ?', [$muzakkiId])
            ->latest('tanggal')
            ->take(5)
            ->get();

        return view('muzaki.dashboard', compact(
            'zakatFitrah', 'zakatMal', 'zakatFidyah', 'zakatInfak', 'totalZakat', 'riwayatZakat'
        ));
    }

    // ✅ Form Pembayaran Zakat
    public function formPembayaran()
    {
        $user = Auth::user();
        if ($user->role !== 'muzaki') abort(403);

        $muzakki = $user->muzakki;

        return view('muzaki.form-pembayaran', [
            'jenisZakat' => JenisZakat::all(),
            'metode'     => MetodePembayaran::where('status_aktif', true)->get(),
            'muzakki'    => $muzakki,
            'nisabHarian'=> 15000, // Contoh nilai untuk fidyah
        ]);
    }


    // ✅ Simpan Pembayaran Zakat
    public function storePembayaran(Request $request)
    {
        $user = Auth::user();
        if ($user->role !== 'muzaki') abort(403);

        $muzakki = $user->muzakki;

        // Validasi umum
        $request->validate([
            'nama'           => 'required|string|max:255',
            'jenis_kelamin'  => 'required|in:Laki-laki,Perempuan',
            'kontak'         => 'required|string|max:100',
            'jenis_zakat_id' => 'required|exists:jenis_zakat,id',
            'metode_id'      => 'required|exists:metode_pembayaran,id',
            'tanggal'        => 'required|date',
            'bukti_pembayaran'=> 'nullable|file|mimes:jpg,jpeg,png,pdf|max:2048',
        ]);

        $jenis = JenisZakat::find($request->jenis_zakat_id);
        $namaJenis = strtolower($jenis->nama_jenis);

        // Hitung nominal berdasarkan jenis zakat
        if (str_contains($namaJenis, 'maal')) {
            $request->validate([
                'emas'      => 'required|numeric|min:0',
                'tabungan'  => 'required|numeric|min:0',
                'aset_lain' => 'required|numeric|min:0',
                'hutang'    => 'nullable|numeric|min:0',
            ]);
            $nominal = (($request->emas + $request->tabungan + $request->aset_lain) - ($request->hutang ?? 0)) * 0.025;
        } elseif (str_contains($namaJenis, 'fidyah')) {
            $request->validate([
                'jumlah_hari' => 'required|numeric|min:1',
                'nominal'     => 'required|numeric|min:1000',
            ]);
            $nominal = $request->jumlah_hari * $request->nominal;
        } elseif (str_contains($namaJenis, 'infak')) {
            $request->validate([
                'nominal' => 'required|numeric|min:1000',
                'tujuan_sedekah' => 'required|string',
            ]);
            $nominal = $request->nominal;
        } else {
            // Zakat Fitrah / lain-lain
            $request->validate([
                'nominal' => 'required|numeric|min:1000',
            ]);
            $nominal = $request->nominal;
        }

        // Detail tambahan
        $detail = $request->except([
            '_token','nama','jenis_kelamin','kontak','jenis_zakat_id','metode_id','tanggal','bukti_pembayaran','nominal'
        ]);

        // Simpan transaksi
        $transaksi = TransaksiZakat::create([
            'nama'          => $request->nama,
            'jenis_kelamin' => $request->jenis_kelamin,
            'muzakki_id'     => $muzakki->id,
            'jenis_zakat_id' => $request->jenis_zakat_id,
            'metode_id'      => $request->metode_id,
            'tanggal'        => $request->tanggal,
            'kontak'         => $request->kontak,
            'nominal'        => $nominal,
            'status'         => 'menunggu',
            'detail'         => json_encode($detail),
        ]);

        // Simpan bukti pembayaran jika ada
        if ($request->hasFile('bukti_pembayaran')) {
            $file = $request->file('bukti_pembayaran');
            $namaFile = 'bukti_' . time() . '.' . $file->getClientOriginalExtension();
            $file->storeAs('public/bukti', $namaFile);

            BuktiPembayaran::create([
                'transaksi_id' => $transaksi->id,
                'file'         => $namaFile,
            ]);
        }

        return redirect()->route('muzaki.riwayat')
            ->with('success', 'Pembayaran zakat berhasil disimpan! Menunggu verifikasi admin.');
    }


    // ✅ Informasi & Edukasi
    public function informasi()
    {
        $user = Auth::user();
        if ($user->role !== 'muzaki') abort(403);

        return view('muzaki.informasi');
    }

    // ✅ Profil Muzaki
    public function profil()
    {
        $user = Auth::user();
        if ($user->role !== 'muzaki') abort(403);

        $muzakki = $user->muzakki;
        if (!$muzakki) return back()->with('error', 'Data muzakki tidak ditemukan.');

        return view('muzaki.profil', compact('user', 'muzakki'));
    }

    public function updateProfil(Request $request)
    {
        $user = Auth::user();
        if ($user->role !== 'muzaki') abort(403);

        $request->validate([
            'email'         => 'required|email|unique:users,email,' . $user->id,
            'nama'          => 'required|string|max:100',
            'email_muzakki' => 'required|email',
            'no_hp'         => 'required|string|max:50',
            'pekerjaan'     => 'required|string|max:100',
            'alamat'        => 'required|string|max:255',
        ]);

        $user->update([
            'email' => $request->email,
            'name'  => $request->nama,
        ]);

        if (!$user->muzakki) return back()->with('error', 'Data Muzakki tidak ditemukan.');

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
        if ($user->role !== 'muzaki') abort(403);

        $bukti = BuktiPembayaran::with('transaksi')
            ->where('transaksi_id', $id)
            ->whereHas('transaksi', function ($q) use ($user) {
                $q->where('muzakki_id', $user->muzakki->id);
            })
            ->firstOrFail();

        return view('muzaki.bukti', compact('bukti'));
    }
}
