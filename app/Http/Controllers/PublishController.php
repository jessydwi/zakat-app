<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Muzakki;
use App\Models\Mustahik;
use App\Models\TransaksiZakat;
use Illuminate\Support\Facades\DB;

class PublishController extends Controller
{
    public function index()
    {
        // Total nominal zakat berdasarkan jenis
        $zakatFitrah = $this->getTotalNominal('zakat fitrah');
        $zakatMal    = $this->getTotalNominal('zakat mal');
        $zakatFidyah = $this->getTotalNominal('zakat fidyah');
        $infak       = $this->getTotalNominal('infak');

        // Jumlah muzakki dan mustahiq
        $jumlahMuzaki   = Muzakki::count();
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

        // Rekapan untuk tampilan publik
        $rekapan = [
            'fitrah' => [
                'muzakki' => $this->getDistinctCount('zakat fitrah'),
                'beras'   => 0, // Ganti jika kamu punya kolom beras
                'uang'    => $zakatFitrah,
            ],
            'fidyah' => [
                'muzakki' => $this->getDistinctCount('zakat fidyah'),
                'uang'    => $zakatFidyah,
            ],
            'infaq' => [
                'donatur' => $this->getDistinctCount('infak'),
                'uang'    => $infak,
            ],
        ];

        return view('publish', compact(
            'zakatFitrah',
            'zakatMal',
            'zakatFidyah',
            'infak',
            'jumlahMuzaki',
            'jumlahMustahiq',
            'grafikZakat',
            'transaksiTerbaru',
            'rekapan'
        ));
    }

    // Helper untuk total nominal
    private function getTotalNominal(string $jenis)
    {
        return TransaksiZakat::whereHas('jenisZakat', fn($q) =>
            $q->whereRaw("LOWER(nama_jenis) = ?", [strtolower($jenis)])
        )->sum('nominal');
    }

    // Helper untuk jumlah muzakki/donatur unik
    private function getDistinctCount(string $jenis)
    {
        return TransaksiZakat::whereHas('jenisZakat', fn($q) =>
            $q->whereRaw("LOWER(nama_jenis) = ?", [strtolower($jenis)])
        )->distinct('muzakki_id')->count('muzakki_id');
    }
}