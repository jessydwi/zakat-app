<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\TransaksiZakat;
use App\Models\Muzakki;
use App\Models\JenisZakat;
use App\Models\MetodePembayaran;
use App\Models\BuktiPembayaran; // tambahkan ini
use App\Models\Notifikasi;
use App\Models\User;
use Carbon\Carbon;

class TransaksiZakatController extends Controller
{
    // 📥 Tampilkan semua transaksi zakat
    public function index()
    {
        $transaksi = TransaksiZakat::with(['muzakki', 'jenisZakat', 'metodePembayaran'])
            ->orderByDesc('tanggal')
            ->get();

        return view('admin.transaksi.index', compact('transaksi'));
    }

    // ➕ Tampilkan form input zakat
    public function create()
    {
        $muzakki = Muzakki::all();
        $jenisZakat = JenisZakat::select('id', 'nama_jenis')->get();
        $metode = MetodePembayaran::select('id', 'nama_metode')->get();
        

        return view('admin.transaksi.create', compact('muzakki', 'jenisZakat', 'metode'));
    }

 
    // 💾 Simpan transaksi baru
    public function store(Request $request)
    {
        $request->validate([
            'muzakki_id'      => 'required|exists:muzakki,id',
            'nama'            => 'required|string|max:255',
            'jenis_kelamin'   => 'required|in:Laki-laki,Perempuan',
            'alamat'          => 'nullable|string|max:255',
            'pekerjaan'       => 'nullable|string|max:255',
            'kontak'          => 'required|string|max:50',
            'jenis_zakat_id'  => 'required|exists:jenis_zakat,id',
            'metode_id'       => 'required|exists:metode_pembayaran,id',
            'nominal'         => 'required|numeric|min:1000',
            'tanggal'         => 'required|date',
            'bukti_pembayaran' => 'required|file|mimes:jpg,jpeg,png,pdf|max:2048',
        ]);

        // 🔍 Ambil nama jenis zakat dari database
        $jenisZakat = JenisZakat::find($request->jenis_zakat_id);
        $jenis = strtolower($jenisZakat->nama_jenis); // contoh: 'maal', 'fidyah', 'infak'

        // 🔍 Susun detail sesuai jenis zakat
        $detail = [];
        if ($jenis === 'maal') {
            $detail = [
                'emas'      => $request->emas,
                'tabungan'  => $request->tabungan,
                'aset_lain' => $request->aset_lain,
                'hutang'    => $request->hutang,
                'nominal'   => $request->nominal,
            ];
        } elseif ($jenis === 'fidyah') {
            $detail = [
                'jumlah_hari'    => $request->jumlah_hari,
                'nominal_fidyah' => $request->nominal_fidyah,
                'nominal'        => $request->nominal,
            ];
        } elseif ($jenis === 'infak') {
            $detail = [
                'tujuan_sedekah' => $request->tujuan_sedekah,
                'nominal'        => $request->nominal,
            ];
        } else {
            $detail = [
                'nominal' => $request->nominal,
            ];
        }

        // 💾 Simpan transaksi
        $transaksi = TransaksiZakat::create([
            'muzakki_id'     => $request->muzakki_id,
            'nama'           => $request->nama,
            'jenis_kelamin'  => $request->jenis_kelamin,
            'alamat'         => $request->alamat,
            'pekerjaan'      => $request->pekerjaan,
            'kontak'         => $request->kontak,
            'jenis_zakat_id' => $request->jenis_zakat_id,
            'metode_id'      => $request->metode_id,
            'nominal'        => $request->nominal,
            'tanggal'        => Carbon::parse($request->tanggal),
            'status'         => 'menunggu',
            'detail'         => $detail, // ✅ tersimpan sebagai JSONB
        ]);

            // 📎 Simpan bukti pembayaran jika ada file
        if ($request->hasFile('bukti_pembayaran')) {
            $path = $request->file('bukti_pembayaran')->store('bukti', 'public');

            BuktiPembayaran::updateOrCreate(
                ['transaksi_id' => $transaksi->id],
                ['file_path' => $path, 'tanggal_upload' => now()]
            );
        }

        // 🔔 Kirim notifikasi ke semua admin
        $admins = User::where('role', 'admin')->get();
        foreach ($admins as $admin) {
            Notifikasi::create([
                'user_id' => $admin->id,
                'judul'   => 'Transaksi Baru',
                'pesan'   => 'Ada transaksi zakat dari ' . $request->nama . ' yang belum dikonfirmasi.',
                'tanggal' => now(),
            ]);
        }

        return redirect()->route('admin.transaksi.index')
            ->with('success', 'Transaksi zakat berhasil ditambahkan.');
    }


    // ✅ Konfirmasi pembayaran
    public function konfirmasi($id)
    {
        $transaksi = TransaksiZakat::findOrFail($id);
        $transaksi->update(['status' => 'terbayar']);

        return redirect()->back()->with('success', 'Transaksi berhasil dikonfirmasi.');
    }
}
