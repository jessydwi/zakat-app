<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\TransaksiZakat;
use App\Models\DistribusiZakat;

class ManajemenZakatController extends Controller
{
    public function index()
    {
        // 🔢 Total zakat masuk (status: terbayar)
        $totalZakatMasuk = TransaksiZakat::where('status', 'terbayar')->sum('nominal');

        // ⏳ Jumlah transaksi belum terkonfirmasi
        $belumTerkonfirmasi = TransaksiZakat::where('status', 'menunggu')->count();
        $nominalBelumTerkonfirmasi = TransaksiZakat::where('status', 'menunggu')->sum('nominal');

        // 💸 Total distribusi ke mustahik
        $totalDistribusi = DistribusiZakat::sum('jumlah');
        $jumlahDistribusi = DistribusiZakat::count();

        // 📥 Semua transaksi zakat masuk (untuk tabel)
        $transaksiMasuk = TransaksiZakat::select([
            'id','muzakki_id','nama','jenis_zakat_id','metode_id',
            'nominal','tanggal','status','amil_id','created_at'
        ])
        ->with(['muzakki','jenisZakat','metodePembayaran','amil.user'])
        ->orderByDesc('tanggal')
        ->get();

        // ⏳ Transaksi yang belum dikonfirmasi (untuk konfirmasi panel)
        $transaksiPending = TransaksiZakat::select([
            'id','muzakki_id','nama','jenis_zakat_id','metode_id',
            'nominal','tanggal','status','amil_id','created_at'
        ])
        ->where('status', 'menunggu')
        ->orderBy('tanggal', 'asc')
        ->with(['muzakki','jenisZakat','metodePembayaran','amil.user'])
        ->get();

        // 🎯 Distribusi zakat ke mustahik (untuk laporan dan rekap)
        $distribusiZakat = DistribusiZakat::with(['mustahik', 'kategoriMustahik', 'jenisBantuan'])
            ->orderByDesc('tanggal')
            ->get();

        // 📊 Grafik bulanan (opsional, jika dipakai)
        $grafikBulanan = TransaksiZakat::selectRaw('EXTRACT(MONTH FROM tanggal) as bulan, SUM(nominal) as total')
            ->where('status', 'terbayar')
            ->groupByRaw('EXTRACT(MONTH FROM tanggal)')
            ->orderByRaw('EXTRACT(MONTH FROM tanggal)')
            ->get();

        $start = now()->startOfMonth()->toDateString();
        $end = now()->endOfMonth()->toDateString();
        $jenis = request()->get('jenis');

        return view('admin.manajemen-zakat', compact(
            'totalZakatMasuk',
            'nominalBelumTerkonfirmasi',
            'belumTerkonfirmasi',
            'totalDistribusi',
            'jumlahDistribusi',
            'transaksiMasuk',
            'transaksiPending',
            'distribusiZakat',
            'grafikBulanan',
            'start',
            'end',
            'jenis'
        ));
    }
}
