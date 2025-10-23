<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\TransaksiZakat;
use App\Models\JenisZakat;
use App\Models\MetodePembayaran;

class TransaksiController extends Controller
{
    public function create()
    {
        $jenisZakat = JenisZakat::all();
        $metodePembayaran = MetodePembayaran::all();

        return view('transaksi.form', compact('jenisZakat', 'metodePembayaran'));
    }

public function store(Request $request)
{
    $request->validate([
        'muzakki_id' => 'required|exists:muzakki,id',
        'jenis_zakat_id' => 'required|exists:jenis_zakat,id',
        'metode_id' => 'required|exists:metode_pembayaran,id',
        'tanggal' => 'required|date',
        'kontak' => 'required|string|max:100',
    ]);

    // Ambil nominal dari form dinamis
    $nominal = $request->nominal ?? 0;

    // Simpan semua data tambahan ke kolom detail
    $detail = $request->except(['_token', 'muzakki_id', 'jenis_zakat_id', 'metode_id', 'tanggal']);

    TransaksiZakat::create([
        'muzakki_id' => $request->muzakki_id,
        'jenis_zakat_id' => $request->jenis_zakat_id,
        'metode_id' => $request->metode_id,
        'tanggal' => $request->tanggal,
        'nominal' => $nominal,
        'status' => 'pending',
        'detail' => json_encode($detail),
    ]);

    return redirect()->route('muzaki.dashboard')->with('success', 'Pembayaran zakat berhasil disimpan.');
}
}
