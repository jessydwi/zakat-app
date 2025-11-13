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
    public function store(Request $request)
    {
        $request->validate([
            'jenis_zakat_id' => 'required|exists:jenis_zakat,id',
            'metode_id'      => 'required|exists:metode_pembayaran,id',
            'tanggal'        => 'required|date',
            'kontak'         => 'required|string|max:100',
            'nominal'        => 'required|numeric|min:1000',
        ]);

        // Ambil muzakki_id dari relasi user login
        $muzakkiId = auth()->user()->muzakki->id ?? null;

        if (!$muzakkiId) {
            return redirect()->back()->withErrors(['muzakki_id' => 'Data muzakki tidak ditemukan.']);
        }

        $detail = $request->except([
            '_token','jenis_zakat_id','metode_id','tanggal','kontak','nominal'
        ]);

        TransaksiZakat::create([
            'muzakki_id'     => $muzakkiId,
            'jenis_zakat_id' => $request->jenis_zakat_id,
            'metode_id'      => $request->metode_id,
            'tanggal'        => $request->tanggal,
            'kontak'         => $request->kontak,
            'nominal'        => $request->nominal,
            'status'         => 'pending',
            'detail'         => json_encode($detail),
        ]);

        return redirect()->route('muzaki.dashboard')
            ->with('success', 'Pembayaran zakat berhasil disimpan.');
    }
}
