<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\TransaksiZakat;
use App\Models\Muzakki;
use App\Models\JenisZakat;
use App\Models\MetodePembayaran;
use Carbon\Carbon;

class TransaksiZakatController extends Controller
{
    // 📥 Tampilkan semua transaksi zakat
    public function index()
    {
        $transaksi = TransaksiZakat::with(['muzakki', 'jenisZakat', 'metode'])
            ->orderByDesc('tanggal')
            ->get();

        return view('admin.transaksi.index', compact('transaksi'));
    }

    // ➕ Tampilkan form input zakat
    public function create()
    {
        $muzakki = Muzakki::select('id', 'nama')->get();
        $jenisZakat = JenisZakat::select('id', 'nama_jenis')->get();
        $metode = MetodePembayaran::select('id', 'nama_metode')->get();

        return view('admin.transaksi.create', compact('muzakki', 'jenisZakat', 'metode'));
    }

    // 💾 Simpan transaksi baru
    public function store(Request $request)
    {
        $request->validate([
            'muzakki_id' => 'required|exists:muzakki,id',
            'jenis_zakat_id' => 'required|exists:jenis_zakat,id',
            'metode_id' => 'required|exists:metode_pembayaran,id',
            'nominal' => 'required|numeric|min:1000',
            'tanggal' => 'required|date',
        ]);

        TransaksiZakat::create([
            'muzakki_id' => $request->muzakki_id,
            'jenis_zakat_id' => $request->jenis_zakat_id,
            'metode_id' => $request->metode_id,
            'nominal' => $request->nominal,
            'tanggal' => Carbon::parse($request->tanggal),
            'status' => 'menunggu',
        ]);

        return redirect()->route('admin.transaksi.index')->with('success', 'Transaksi zakat berhasil ditambahkan.');
    }

    // ✅ Konfirmasi pembayaran
    public function konfirmasi($id)
    {
        $transaksi = TransaksiZakat::findOrFail($id);
        $transaksi->update(['status' => 'terbayar']);

        return redirect()->back()->with('success', 'Transaksi berhasil dikonfirmasi.');
    }
}
