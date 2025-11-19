<?php

namespace App\Http\Controllers\Muzaki;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\TransaksiZakat;
use App\Models\JenisZakat;
use App\Models\MetodePembayaran;

class TransaksiController extends Controller
{
    /**
     * Tampilkan form pembayaran zakat
     */
    public function create()
    {
        // Tidak perlu ambil semua muzakki, cukup jenis zakat & metode
        $jenisZakat = JenisZakat::all();
        $metodePembayaran = MetodePembayaran::where('status_aktif', 1)->get();

        return view('muzaki.form-pembayaran', compact('jenisZakat', 'metodePembayaran'));
    }

    /**
     * Simpan transaksi zakat
     */
public function storePembayaran(Request $request)
{
    // Validasi umum
    $request->validate([
        'jenis_zakat_id' => 'required|exists:jenis_zakat,id',
        'metode_id'      => 'required|exists:metode_pembayaran,id',
        'tanggal'        => 'required|date',
        'kontak'         => 'required|string|max:100',
    ]);

    // Ambil jenis zakat untuk validasi lanjutan
    $jenis = JenisZakat::find($request->jenis_zakat_id);
    $namaJenis = strtolower($jenis->nama_jenis);

    // Validasi khusus tiap jenis
    if (str_contains($namaJenis, 'maal')) {
        $request->validate([
            'emas'      => 'required|numeric|min:0',
            'tabungan'  => 'required|numeric|min:0',
            'aset_lain' => 'required|numeric|min:0',
            'hutang'    => 'nullable|numeric|min:0'
        ]);
        // Nominal dihitung otomatis: (emas + tabungan + aset_lain - hutang) * 2.5%
        $nominal = (($request->emas + $request->tabungan + $request->aset_lain) - ($request->hutang ?? 0)) * 0.025;
    } 
    
    elseif (str_contains($namaJenis, 'fidyah')) {
        $request->validate([
            'jumlah_hari' => 'required|numeric|min:1',
            'nominal'     => 'required|numeric|min:1000'
        ]);
        $nominal = $request->jumlah_hari * $request->nominal;
    } 
    
    elseif (str_contains($namaJenis, 'infak')) {
        $request->validate([
            'nominal' => 'required|numeric|min:1000',
            'tujuan_sedekah' => 'required|string'
        ]);
        $nominal = $request->nominal;
    }
    
    else { // FITRAH atau lainnya
        $request->validate([
            'nominal' => 'required|numeric|min:1000',
        ]);
        $nominal = $request->nominal;
    }

    // Ambil muzakki ID
    $muzakkiId = auth()->user()->muzakki->id ?? null;

    if (!$muzakkiId) {
        return back()->withErrors(['muzakki_id' => 'Data muzakki tidak ditemukan.']);
    }

    // Detail selain field utama
    $detail = $request->except([
        '_token','jenis_zakat_id','metode_id','tanggal','kontak','nominal'
    ]);

    // Simpan transaksi
    TransaksiZakat::create([
        'nama'          => $request->nama,
        'jenis_kelamin' => $request->jenis_kelamin,
        'muzakki_id'     => $muzakkiId,
        'jenis_zakat_id' => $request->jenis_zakat_id,
        'metode_id'      => $request->metode_id,
        'tanggal'        => $request->tanggal,
        'kontak'         => $request->kontak,
        'nominal'        => $nominal,
        'status'         => 'menunggu',
        'detail'         => json_encode($detail),
    ]);

return redirect()
        ->route('muzaki.bayar')
        ->with('success', 'Pembayaran berhasil dilakukan! Silakan menunggu konfirmasi dari admin.');
}
}
