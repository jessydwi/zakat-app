<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\DistribusiZakat;
use App\Models\Mustahik;
use App\Models\JenisBantuan;

class DistribusiZakatController extends Controller
{
    public function index(Request $request)
    {
        $query = DistribusiZakat::with(['mustahik.kategori', 'jenisBantuan']);

        // Filter bulan
        if ($request->filled('bulan')) {
            $query->whereMonth('tanggal', $request->bulan);
        }

        // Filter tahun
        if ($request->filled('tahun')) {
            $query->whereYear('tanggal', $request->tahun);
        }

        // Filter jenis bantuan berdasarkan slug
        if ($request->filled('jenis')) {
            $query->whereHas('jenisBantuan', function ($q) use ($request) {
                $q->where('slug', $request->jenis);
            });
        }

        $distribusi = $query->latest()->get(); // atau ->paginate(10)

        // Kirim juga nilai 'jenis' ke view agar bisa digunakan untuk include tabel dinamis
        return view('admin.distribusi.index', [
            'distribusi' => $distribusi,
            'jenis' => $request->jenis,
        ]);
    }

    public function create()
    {
        return view('admin.distribusi.create');
    }

    public function cetak()
    {
        $distribusi = DistribusiZakat::with(['mustahik.kategori', 'jenisBantuan'])->latest()->get();
        return view('admin.distribusi.cetak', compact('distribusi'));
    }
}
