<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\TransaksiZakat;
use App\Models\DistribusiZakat;
use Illuminate\Http\Request;

class LaporanZakatController extends Controller
{
    public function index(Request $request)
    {
        $start = $request->start ?? now()->startOfMonth()->toDateString();
        $end = $request->end ?? now()->endOfMonth()->toDateString();

        // Hitung total zakat masuk
        $totalMasuk = TransaksiZakat::whereBetween('tanggal', [$start, $end])
            ->where('status', 'terbayar')
            ->sum('nominal');

        // Hitung total zakat disalurkan
        $totalDistribusi = DistribusiZakat::whereBetween('tanggal', [$start, $end])
            ->sum('jumlah');

        // Ambil detail zakat masuk
        $rekapMasuk = TransaksiZakat::whereBetween('tanggal', [$start, $end])
            ->where('status', 'terbayar')
            ->orderBy('tanggal', 'desc')
            ->get();

        // Ambil detail zakat distribusi
        $rekapDistribusi = DistribusiZakat::with(['mustahik', 'jenisBantuan'])
            ->whereBetween('tanggal', [$start, $end])
            ->orderBy('tanggal', 'desc')
            ->get();

        return view('admin.laporan-zakat.index', compact(
            'totalMasuk',
            'totalDistribusi',
            'rekapMasuk',
            'rekapDistribusi',
            'start',
            'end'
        ));
    }
}
