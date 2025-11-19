<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller; // ✅ Tambahkan ini
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
        $q->whereRaw("nama_jenis ILIKE '%fitrah%'");
        })->where('status', 'terbayar')->sum('nominal');

        $zakatMal = TransaksiZakat::whereHas('jenisZakat', function ($q) {
            $q->whereRaw("nama_jenis ILIKE '%mal%'");
        })->where('status', 'terbayar')->sum('nominal');

        $zakatFidyah = TransaksiZakat::whereHas('jenisZakat', function ($q) {
            $q->whereRaw("nama_jenis ILIKE '%fidyah%'");
        })->where('status', 'terbayar')->sum('nominal');

        $infak = TransaksiZakat::whereHas('jenisZakat', function ($q) {
            $q->whereRaw("nama_jenis ILIKE '%infak%'");
        })->where('status', 'terbayar')->sum('nominal');


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
        $transaksiTerbaru = TransaksiZakat::select([
        'id','muzakki_id','nama','jenis_zakat_id','metode_id',
        'nominal','tanggal','status','amil_id','created_at'
    ])
    ->orderByDesc('tanggal')
    ->limit(5)
    ->with(['muzakki','jenisZakat','metodePembayaran','amil.user'])
    ->get();

        return view('admin.dashboard', compact(
            'zakatFitrah',
            'zakatMal',
            'zakatFidyah',
            'jumlahMuzaki',
            'jumlahMustahiq',
            'grafikZakat',
            'infak',
            'transaksiTerbaru',
        ));
    }
}
