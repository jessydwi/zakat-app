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

        // 💸 Total distribusi ke mustahik
        $totalDistribusi = DistribusiZakat::sum('jumlah');

        // 📥 Semua transaksi zakat masuk (untuk tabel)
        $transaksiMasuk = TransaksiZakat::with(['muzakki', 'jenisZakat'])
            ->orderByDesc('tanggal')
            ->get();

        // ⏳ Transaksi yang belum dikonfirmasi (untuk konfirmasi panel)
        $transaksiPending = TransaksiZakat::with(['muzakki', 'jenisZakat'])
            ->where('status', 'menunggu')
            ->orderBy('tanggal')
            ->get();

        // 🎯 Distribusi zakat ke mustahik (untuk laporan dan rekap)
        $distribusiZakat = DistribusiZakat::with(['mustahik', 'kategoriMustahik', 'jenisBantuan'])
            ->orderByDesc('tanggal')
            ->get();

        $jenis = request()->get('jenis'); // bisa dari query string atau default


        return view('admin.manajemen-zakat', compact(
            'totalZakatMasuk',
            'belumTerkonfirmasi',
            'totalDistribusi',
            'transaksiMasuk',
            'transaksiPending',
            'distribusiZakat',
            'jenis'
        ));
    }
}
