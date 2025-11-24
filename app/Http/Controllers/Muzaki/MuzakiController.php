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
use App\Models\Notifikasi;

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
        $userId = $user->id;

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

        $jumlahNotifikasiBelumDibaca = Notifikasi::where('user_id', $userId)
            ->whereNull('status_baca')
            ->count();

        return view('muzaki.dashboard', compact(
            'zakatFitrah', 'zakatMal', 'zakatFidyah', 'zakatInfak', 'totalZakat', 'riwayatZakat', 'jumlahNotifikasiBelumDibaca'
        ));
    }

public function kalkulator()
{
    $user = Auth::user();
    if ($user->role !== 'muzaki') abort(403);

    // Tampilkan halaman. Jika ingin menampilkan nisab di UI, kirimkan juga nilai defaultnya.
    $nisabBulanan = 7140498; // SK BAZNAS 2025
    return view('muzaki.kalkulator', compact('nisabBulanan'));
}

public function hitung(Request $request)
{
    // Jenis wajib ada dan valid
    $request->validate([
        'jenis' => 'required|in:maal,penghasilan',
    ]);

    $jenis  = $request->input('jenis');
    $zakat  = 0.0;
    $total  = 0.0;
    $nisab  = null;
    $wajib  = false;

    if ($jenis === 'maal') {
        // Input wajib untuk total harta, hutang opsional
        $request->validate([
            'emas'        => 'required|numeric|min:0',
            'tabungan'    => 'required|numeric|min:0',
            'aset'        => 'required|numeric|min:0',
            'hutang'      => 'nullable|numeric|min:0',
            // opsional: tentukan nisab langsung (rupiah) ATAU harga emas per gram
            'nisab'       => 'nullable|numeric|min:0',
            'harga_emas'  => 'nullable|numeric|min:0',
        ]);

        // Bersihkan angka
        $emas     = (float) ($request->input('emas', 0));
        $tabungan = (float) ($request->input('tabungan', 0));
        $aset     = (float) ($request->input('aset', 0));
        $hutang   = (float) ($request->input('hutang', 0));

        // Total harta kena zakat
        $total = $emas + $tabungan + $aset - $hutang;
        if ($total < 0) $total = 0.0;

        // Tentukan nisab maal:
        // 1) Jika nisab rupiah diberikan → pakai itu
        // 2) Jika harga emas/gram diberikan → 85 gram × harga/gram
        // 3) Jika tidak ada keduanya → tetap cek zakat 2.5% (tanpa threshold)
        if ($request->filled('nisab')) {
            $nisab = (float) $request->input('nisab');
            
        } elseif ($request->filled('harga_emas')) {
            $nisab = 85.0 * (float) $request->input('harga_emas');
        }

        if ($nisab !== null) {
            $wajib = $total >= $nisab;
            $zakat = $wajib ? ($total * 0.025) : 0.0;
        } else {
            // Tanpa nisab tersedia, tampilkan zakat 2.5% sebagai simulasi
            $zakat = $total * 0.025;
            $wajib = $zakat > 0;
        }
    } elseif ($jenis === 'penghasilan') {
        // Wajib ada penghasilan
        $request->validate([
            'penghasilan' => 'required|numeric|min:0',
            // opsi override nisab bulanan
            'nisab'       => 'nullable|numeric|min:0',
        ]);

        $penghasilan = (float) ($request->input('penghasilan', 0));
        $total       = $penghasilan;

        // Nisab bulanan default sesuai SK BAZNAS 2025
        $defaultNisabBulanan = 7140498;
        $nisab = $request->filled('nisab')
            ? (float) $request->input('nisab')
            : $defaultNisabBulanan;

        // Wajib zakat hanya jika penghasilan >= nisab bulanan
        $wajib = $penghasilan >= $nisab;
        $zakat = $wajib ? ($penghasilan * 0.025) : 0.0;
    }

    // Format hasil (pembulatan pada output tampilan saja)
    $zakatRounded      = (int) round($zakat);
    $formattedZakat    = 'Rp ' . number_format($zakatRounded, 0, ',', '.');
    $totalRounded      = (int) round($total);
    $formattedTotal    = 'Rp ' . number_format($totalRounded, 0, ',', '.');
    $nisabRounded      = $nisab !== null ? (int) round($nisab) : null;
    $formattedNisab    = $nisabRounded !== null ? 'Rp ' . number_format($nisabRounded, 0, ',', '.') : null;

    return response()->json([
        'success'          => true,
        'jenis'            => $jenis,
        'total'            => $totalRounded,
        'formatted_total'  => $formattedTotal,
        'nisab'            => $nisabRounded,
        'formatted_nisab'  => $formattedNisab,
        'wajib'            => $wajib,
        'zakat'            => $zakatRounded,
        'formatted'        => $formattedZakat,
    ]);
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
    public function store(Request $request)
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
            $file->storeAs('bukti', $namaFile, 'public');

            BuktiPembayaran::create([
                'transaksi_id' => $transaksi->id,
                'file'         => $namaFile,
            ]);
        }

        return redirect()->route('muzaki.riwayat')
            ->with('success', 'Pembayaran zakat berhasil disimpan! Menunggu verifikasi admin.');
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
            
        $transaksi = $bukti->transaksi; // ambil transaksi terkait

            $path = storage_path('app/' . $bukti->file_path);

        return view('muzaki.bukti', compact('bukti', 'transaksi'));
        return response()->file($path);
    }


public function detailTransfer(Request $request)
{
    $validated = $request->validate([
        'idTransaksi'     => 'required|string',
        'bankTujuan'      => 'required|string',
        'nomorRekening'   => 'required|string',
        'nominal'         => 'required|numeric|min:1000',
        'muzakki_id'      => 'nullable|integer',
        'nama'            => 'nullable|string',
        'jenis_kelamin'   => 'nullable|string',
        'alamat'          => 'nullable|string',
        'pekerjaan'       => 'nullable|string',
        'kontak'          => 'nullable|string',
        'jenis_zakat_id'  => 'nullable|integer',
        'metode_id'       => 'nullable|integer',
        'tanggal'         => 'nullable|date',
    ]);

    // Simpan ke session agar bisa dipakai di Blade
    session([
        'idTransaksi'     => $validated['idTransaksi'],
        'bankTujuan'      => $validated['bankTujuan'],
        'nomorRekening'   => $validated['nomorRekening'],
        'nominalTransfer' => $validated['nominal'],
        'waktuTransfer'   => now()->format('d M Y · H:i:s') . ' WIB',
    ]);

    return view('muzaki.detail-transfer');
}

    
}
