<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Muzakki;
use App\Models\Mustahik;
use App\Models\TransaksiZakat;
use Illuminate\Support\Facades\DB;

class AdminController extends Controller
{
    public function index()
    {
        // Total zakat berdasarkan jenis (dengan join ke jenis_zakat)
        $zakatFitrah = TransaksiZakat::whereHas('jenisZakat', function ($q) {
            $q->where('nama_jenis', 'fitrah');
        })->sum('nominal');

        $zakatMal = TransaksiZakat::whereHas('jenisZakat', function ($q) {
            $q->where('nama_jenis', 'mal');
        })->sum('nominal');

        $zakatFidyah = TransaksiZakat::whereHas('jenisZakat', function ($q) {
            $q->where('nama_jenis', 'fidyah');
        })->sum('nominal');

        // Jumlah muzakki dan mustahiq
        $jumlahMuzaki = Muzakki::count();
        $jumlahMustahiq = Mustahik::count();

        // Grafik pemasukan zakat per bulan
        $grafikZakat = TransaksiZakat::select(
        DB::raw("EXTRACT(MONTH FROM tanggal) AS bulan"),
        DB::raw("SUM(nominal) AS total")
        )
        ->whereYear('tanggal', now()->year)
        ->groupBy(DB::raw("EXTRACT(MONTH FROM tanggal)"))
        ->orderBy(DB::raw("EXTRACT(MONTH FROM tanggal)"))
        ->get();

        // Transaksi terbaru
        $transaksiTerbaru = TransaksiZakat::with('muzakki', 'jenisZakat')
            ->latest('tanggal')
            ->take(5)
            ->get();

        return view('admin.dashboard', compact(
            'zakatFitrah',
            'zakatMal',
            'zakatFidyah',
            'jumlahMuzaki',
            'jumlahMustahiq',
            'grafikZakat',
            'transaksiTerbaru'
        ));
    }
}
