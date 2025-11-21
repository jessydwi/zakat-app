<?php

namespace App\Http\Controllers\Muzaki;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\TransaksiZakat;
use App\Models\JenisZakat;
use App\Models\MetodePembayaran;
use App\Models\BuktiPembayaran;
use App\Models\Muzakki;
use Illuminate\Support\Facades\Auth;

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
public function store(Request $request)
    {
        $user = Auth::user();
        if (!$user || $user->role !== 'muzaki') {
            abort(403);
        }

        // Ambil muzakki (prioritaskan nilai yang ada, fallback ke auth)
        $muzakki = $user->muzakki ?? Muzakki::where('user_id', $user->id)->first();
        if (!$muzakki) {
            return back()->with('error', 'Data muzakki tidak ditemukan.');
        }

        // Karena popup JS mengirim nama fields sedikit berbeda, ambil dengan fallback
        $nama           = $request->input('nama') ?? $request->input('nama_lengkap');
        $jenis_kelamin  = $request->input('jenis_kelamin') ?? $request->input('jenis_kelamin');
        $kontak         = $request->input('kontak') ?? $request->input('kontak');
        $jenis_zakat_id = $request->input('jenis_zakat_id');
        $metode_id      = $request->input('metode_id');
        $tanggal        = $request->input('tanggal') ?? now()->toDateString();

        // Untuk nominal: bisa datang dari 'nominal' (form utama) atau 'nominalTransfer' (popup)
        $nominal = null;
        if ($request->filled('nominalTransfer')) {
            $nominal = (float) $request->input('nominalTransfer');
        } elseif ($request->filled('nominal')) {
            // nominal bisa datang sebagai string "Rp XX" (dari fidyah format) atau number
            $raw = $request->input('nominal');
            // Hapus karakter selain digit
            $clean = preg_replace('/[^\d]/', '', (string) $raw);
            $nominal = $clean === '' ? 0 : (float) $clean;
        }

        // Validasi dasar — pastikan mandatory fields terpenuhi
        $validateRules = [
            'jenis_zakat_id' => 'required|exists:jenis_zakat,id',
            'metode_id'      => 'required|exists:metode_pembayaran,id',
            'tanggal'        => 'required|date',
        ];
        // Bukti pembayaran boleh null (popup transfer tidak mengirim file)
        $request->validate($validateRules);

        // Jika nominal belum tersedia (mis. user tidak mengisi), validasikan dari jenis zakat
        if ($nominal === null || $nominal <= 0) {
            // Coba untuk kasus maal: user bisa mengirim emas/tabungan/aset_lain/hutang
            $jenis = JenisZakat::find($jenis_zakat_id);
            $namaJenis = $jenis ? strtolower($jenis->nama_jenis) : '';

            if (str_contains($namaJenis, 'maal')) {
                $request->validate([
                    'emas'      => 'required|numeric|min:0',
                    'tabungan'  => 'required|numeric|min:0',
                    'aset_lain' => 'required|numeric|min:0',
                    'hutang'    => 'nullable|numeric|min:0',
                ]);
                $nominal = (($request->input('emas',0) + $request->input('tabungan',0) + $request->input('aset_lain',0))
                            - ($request->input('hutang',0))) * 0.025;
            } elseif (str_contains($namaJenis, 'fidyah')) {
                $request->validate([
                    'jumlah_hari' => 'required|numeric|min:1',
                    // nominal per hari bisa datang lewat field 'nisab_harian' atau 'nominal'
                ]);
                $perHari = $request->input('nisab_harian') ?? $request->input('nominal') ?? 0;
                // jika perHari berupa format Rp, bersihkan:
                if (is_string($perHari)) {
                    $perHari = (float) preg_replace('/[^\d]/', '', $perHari);
                }
                $nominal = (int) $request->input('jumlah_hari') * (float) $perHari;
            } else {
                // infak / fitrah: harus kirim nominal
                $request->validate([
                    'nominal' => 'required|numeric|min:1000',
                ]);
                $nominal = (float) $request->input('nominal');
            }
        }

        // Detail — simpan semua input non-standar sebagai JSON
        $detail = $request->except([
            '_token', '_method', 'nama', 'nama_lengkap', 'jenis_kelamin', 'kontak',
            'jenis_zakat_id', 'metode_id', 'tanggal', 'bukti_pembayaran', 'nominal', 'nominalTransfer'
        ]);

        // Simpan transaksi
        $transaksi = TransaksiZakat::create([
            'nama'           => $nama,
            'jenis_kelamin'  => $jenis_kelamin,
            'muzakki_id'     => $muzakki->id,
            'jenis_zakat_id' => $jenis_zakat_id,
            'metode_id'      => $metode_id,
            'tanggal'        => $tanggal,
            'kontak'         => $kontak,
            'nominal'        => $nominal,
            'status'         => 'menunggu', // default
            'detail'         => json_encode($detail),
        ]);

        // Jika ada file bukti_pembayaran pada request (form utama)
        if ($request->hasFile('bukti_pembayaran')) {
            $file = $request->file('bukti_pembayaran');
            $namaFile = 'bukti_' . time() . '.' . $file->getClientOriginalExtension();
            $file->storeAs('public/bukti', $namaFile);

            BuktiPembayaran::create([
                'transaksi_id' => $transaksi->id,
                'file_path'         => $namaFile,
            ]);
        }

        return redirect()->route('muzaki.riwayat')->with('success', 'Pembayaran zakat berhasil disimpan! Menunggu verifikasi admin.');
    }
}