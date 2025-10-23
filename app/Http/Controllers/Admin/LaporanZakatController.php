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

        $totalMasuk = TransaksiZakat::whereBetween('tanggal', [$start, $end])
            ->where('status', 'terbayar')
            ->sum('nominal');

        $totalDistribusi = DistribusiZakat::whereBetween('tanggal', [$start, $end])
            ->sum('jumlah');

        $rekapDistribusi = DistribusiZakat::with(['mustahik', 'jenisBantuan'])
            ->whereBetween('tanggal', [$start, $end])
            ->orderBy('tanggal', 'desc')
            ->get();

        return view('admin.laporan-zakat.index', compact('totalMasuk', 'totalDistribusi', 'rekapDistribusi', 'start', 'end'));
    }
}
