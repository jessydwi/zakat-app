<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\TransaksiZakat;
use App\Models\Muzakki;
use App\Models\JenisZakat;
use App\Models\MetodePembayaran;
use App\Models\BuktiPembayaran; // tambahkan ini
use App\Models\KetentuanZakat; // ✅ INI WAJIB ADA
use App\Models\Notifikasi;
use App\Models\User;
use Carbon\Carbon;

class TransaksiZakatController extends Controller
{
    // 📥 Tampilkan semua transaksi zakat
    public function index()
    {
        $transaksi = TransaksiZakat::select([
        'id','muzakki_id','nama','jenis_zakat_id','metode_id',
        'nominal','tanggal','status','amil_id','created_at'
        ])
        ->with(['muzakki','jenisZakat','metodePembayaran','amil.user'])
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
    $nisabHarian = KetentuanZakat::where('parameter', 'nisab_harian')->first();

    // Ambil nisab maal dan harga emas dari database
    $nisabMal = KetentuanZakat::where('jenis_zakat', 'mal')->where('parameter', 'nisab')->first();
    $hargaEmas = KetentuanZakat::where('parameter', 'harga_emas')->first();

    return view('admin.transaksi.create', compact('muzakki', 'jenisZakat', 'metode', 'nisabHarian', 'nisabMal', 'hargaEmas'));
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

        $fidyah = KetentuanZakat::where('parameter', 'harga_uang')->first();
        $nominalPerHari = $fidyah->nilai ?? 0;
        $jumlahHari = $request->jumlah_hari;
        $totalFidyah = $jumlahHari * $nominalPerHari;

        // 🔍 Ambil nama jenis zakat dari database
        $jenisZakat = JenisZakat::find($request->jenis_zakat_id);
        $jenis = strtolower($jenisZakat->nama_jenis); // contoh: 'maal', 'fidyah', 'infak'

        $hargaEmas = KetentuanZakat::where('parameter', 'harga_emas')->first();
        $nisabMal = KetentuanZakat::where('jenis_zakat', 'mal')->where('parameter', 'nisab')->first();

        $hargaPerGram = $hargaEmas->nilai ?? 1100000;
        $nisabGram = $nisabMal->nilai ?? 85;
        $nisabMaal = $hargaPerGram * $nisabGram;

        // 🔍 Susun detail sesuai jenis zakat
        $detail = [];
        if ($jenis === 'mal') {
        $totalHarta = ($request->emas ?? 0) + ($request->tabungan ?? 0) + ($request->aset_lain ?? 0) - ($request->hutang ?? 0);
        $zakatMaal = $totalHarta >= $nisabMaal ? $totalHarta * 0.025 : 0;

        $detail = [
            'emas'        => $request->emas,
            'tabungan'    => $request->tabungan,
            'aset_lain'   => $request->aset_lain,
            'hutang'      => $request->hutang,
            'total_harta' => $totalHarta,
            'nisab_maal'  => $nisabMaal,
            'nominal'     => $zakatMaal,
        ];

        // Pastikan nominal yang disimpan sesuai hasil kalkulasi
        $request->merge(['nominal' => $zakatMaal]);

        } elseif ($jenis === 'fidyah') {
            $detail = [
                'jumlah_hari'    => $jumlahHari,
                'nominal_fidyah' => $nominalPerHari,
                'nominal'        => $totalFidyah,
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
<<<<<<< HEAD
{
    $transaksi = TransaksiZakat::findOrFail($id);
=======
    {
        $transaksi = TransaksiZakat::findOrFail($id);
        $transaksi->update(['status' => 'terkonfirmasi']);
>>>>>>> 179287d610194bf813729e6a42cd2200e56b1424

    // Ambil user yang login
    $user = auth()->user();

    // Pastikan user punya relasi amil
    if (!$user || !$user->amil) {
        return back()->withErrors(['error' => 'Hanya amil yang bisa melakukan konfirmasi.']);
    }

    // Simpan status dan amil_id
    $transaksi->update([
        'status' => 'terbayar',
        'amil_id' => $user->amil->id,
    ]);

    return redirect()->back()->with('success', 'Transaksi berhasil dikonfirmasi oleh ' . $user->nama . '.');
}


    public function konfirmasiTransfer(Request $request)
{
    $validated = $request->validate([
        'idTransaksi'     => 'required|string',
        'bankTujuan'      => 'required|string',
        'nomorRekening'   => 'required|string',
        'nominalTransfer' => 'required|integer|min:1000',
        'jenis_zakat_id'  => 'nullable|integer',
        'metode_id'       => 'nullable|integer',
        'tanggal'         => 'nullable|date',
    ]);

    session([
        'idTransaksi'     => $validated['idTransaksi'],
        'bankTujuan'      => $validated['bankTujuan'],
        'nomorRekening'   => $validated['nomorRekening'],
        'nominalTransfer' => $validated['nominalTransfer'],
        'muzakki_id'      => $request->input('muzakki_id'),
        'nama_lengkap'    => $request->input('nama_lengkap'),
        'jenis_kelamin'   => $request->input('jenis_kelamin'),
        'alamat'          => $request->input('alamat'),
        'pekerjaan'       => $request->input('pekerjaan'),
        'kontak'          => $request->input('kontak'),
        'jenis_zakat_id'  => $request->input('jenis_zakat_id'),
        'metode_id'       => $request->input('metode_id'),
        'tanggal'         => $request->input('tanggal'),
        // bukti pembayaran bisa disimpan di storage, bukan session
    ]);

    return redirect()->route('admin.transaksi.detail-transfer');
}

public function detailTransfer()
{
    return view('admin.transaksi.detail-transfer', [
        'idTransaksi'     => session('idTransaksi'),
        'bankTujuan'      => session('bankTujuan'),
        'nomorRekening'   => session('nomorRekening'),
        'nominalTransfer' => session('nominalTransfer'),
        'waktuTransfer'   => now()->format('d M Y · H:i:s') . ' WIB',
    ]);
}
    public function show($id)
    {
        $transaksi = TransaksiZakat::with(['muzakki', 'jenisZakat', 'metodePembayaran', 'buktiPembayaran'])
            ->findOrFail($id);

        return view('admin.transaksi.show', compact('transaksi'));
    }

}
