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
        $user = auth()->user();
        $muzakki = $user->muzakki;

        if (!$muzakki) {
            abort(403, 'Data muzakki tidak ditemukan.');
        }

        $jenisZakat = JenisZakat::all();
        $metodePembayaran = MetodePembayaran::where('status_aktif', 1)->get();

        return view('muzaki.form-pembayaran', compact(
            'jenisZakat',
            'metodePembayaran',
            'user',
            'muzakki'
        ));
    }

    /**
     * Simpan transaksi zakat
     */
    public function storePembayaran(Request $request)
    {
        $muzakki = auth()->user()->muzakki;

        if (!$muzakki) {
            return back()->withErrors(['muzakki' => 'Data muzakki tidak ditemukan.']);
        }

        // Validasi umum
        $request->validate([
            'nama'            => 'required|string|max:255',
            'jenis_kelamin'   => 'required|in:Laki-laki,Perempuan',
            'kontak'          => 'required|string|max:100',
            'jenis_zakat_id'  => 'required|exists:jenis_zakat,id',
            'metode_id'       => 'required|exists:metode_pembayaran,id',
            'tanggal'         => 'required|date',
        ]);

        // Ambil jenis zakat
        $jenis = JenisZakat::find($request->jenis_zakat_id);
        $namaJenis = strtolower($jenis->nama_jenis);

        // Validasi dan perhitungan khusus tiap jenis zakat
        if (str_contains($namaJenis, 'maal')) {
            $request->validate([
                'emas'      => 'required|numeric|min:0',
                'tabungan'  => 'required|numeric|min:0',
                'aset_lain' => 'required|numeric|min:0',
                'hutang'    => 'nullable|numeric|min:0'
            ]);
            $hutang = $request->hutang ?? 0;
            $nominal = (($request->emas + $request->tabungan + $request->aset_lain) - $hutang) * 0.025;
        } elseif (str_contains($namaJenis, 'fidyah')) {
            $request->validate([
                'jumlah_hari' => 'required|numeric|min:1',
                'nominal'     => 'required|numeric|min:1000'
            ]);
            $nominal = $request->jumlah_hari * $request->nominal;
        } elseif (str_contains($namaJenis, 'infak')) {
            $request->validate([
                'nominal'         => 'required|numeric|min:1000',
                'tujuan_sedekah'  => 'required|string'
            ]);
            $nominal = $request->nominal;
        } else { // Zakat Fitrah atau lainnya
            $request->validate([
                'nominal' => 'required|numeric|min:1000',
            ]);
            $nominal = $request->nominal;
        }

        // Ambil detail tambahan
        $detail = $request->except([
            '_token', 'nama', 'jenis_kelamin', 'kontak', 'jenis_zakat_id', 'metode_id', 'tanggal', 'nominal'
        ]);

        // Simpan transaksi
        TransaksiZakat::create([
            'nama'            => $request->nama,
            'jenis_kelamin'   => $request->jenis_kelamin,
            'muzakki_id'      => $muzakki->id,
            'jenis_zakat_id'  => $request->jenis_zakat_id,
            'metode_id'       => $request->metode_id,
            'tanggal'         => $request->tanggal,
            'kontak'          => $request->kontak,
            'nominal'         => $nominal,
            'status'          => 'menunggu',
            'detail'          => json_encode($detail),
        ]);

        return redirect()
            ->route('muzaki.bayar')
            ->with('success', 'Pembayaran berhasil dilakukan! Silakan menunggu konfirmasi dari admin.');
    }
}
