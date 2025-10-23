<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\KetentuanZakat;

class KetentuanZakatController extends Controller
{
    public function index() {
        $data = KetentuanZakat::orderBy('jenis_zakat')->get()->groupBy('jenis_zakat');
        return view('admin.pengaturan.ketentuan', compact('data'));
    }

   public function store(Request $request) {
    $request->validate([
        'jenis_zakat' => 'required|in:fitrah,penghasilan,mal',
    ]);

    if ($request->jenis_zakat === 'penghasilan') {
        // Validasi tambahan untuk penghasilan
        $request->validate([
            'satuan' => 'required|string|max:20',
            'nilai' => 'required|numeric|min:0',
            'nilai_uang' => 'nullable|numeric|min:0',
            'satuan_tahun' => 'required|string|max:20',
            'nilai_tahun' => 'required|numeric|min:0',
            'satuan_bulan' => 'required|string|max:20',
            'nilai_bulan' => 'required|numeric|min:0',
            'keterangan' => 'nullable|string|max:255',
        ]);

        KetentuanZakat::create([
            'jenis_zakat' => 'penghasilan',
            'parameter' => 'persentase',
            'satuan' => $request->satuan,
            'nilai' => $request->nilai,
            'nilai_uang' => $request->nilai_uang,
            'keterangan' => $request->keterangan,
        ]);

        KetentuanZakat::create([
            'jenis_zakat' => 'penghasilan',
            'parameter' => 'nisab_tahun',
            'satuan' => $request->satuan_tahun,
            'nilai' => $request->nilai_tahun,
            'nilai_uang' => null,
            'keterangan' => $request->keterangan,
        ]);

        KetentuanZakat::create([
            'jenis_zakat' => 'penghasilan',
            'parameter' => 'nisab_bulan',
            'satuan' => $request->satuan_bulan,
            'nilai' => $request->nilai_bulan,
            'nilai_uang' => null,
            'keterangan' => $request->keterangan,
        ]);
    } elseif ($request->jenis_zakat === 'fitrah' || $request->jenis_zakat === 'mal') {
        // Validasi untuk fitrah dan mal
        $request->validate([
            'parameter' => 'required|string|max:50',
            'satuan' => 'required|string|max:20',
            'nilai' => 'required|numeric|min:0',
            'nilai_uang' => 'nullable|numeric|min:0',
            'keterangan' => 'nullable|string|max:255',
        ]);

        KetentuanZakat::create([
            'jenis_zakat' => $request->jenis_zakat,
            'parameter' => $request->parameter,
            'satuan' => $request->satuan,
            'nilai' => $request->nilai,
            'nilai_uang' => $request->nilai_uang,
            'keterangan' => $request->keterangan,
        ]);
    }

    return back()->with('success', 'Ketentuan berhasil ditambahkan.');
}

    public function update(Request $request, KetentuanZakat $ketentuan) {
        $request->validate([
            'parameter' => 'required|string|max:50',
            'satuan' => 'required|string|max:20',
            'nilai' => 'required|numeric|min:0',
            'nilai_uang' => 'nullable|numeric|min:0',
            'keterangan' => 'nullable|string|max:255',
        ]);

        $ketentuan->update($request->all());
        return back()->with('success', 'Ketentuan berhasil diperbarui.');
    }
    
    public function edit(KetentuanZakat $ketentuan) {
        return view('admin.pengaturan.ketentuan_edit', compact('ketentuan'));
    }


    public function destroy(KetentuanZakat $ketentuan) {
        $ketentuan->delete();
        return back()->with('success', 'Ketentuan berhasil dihapus.');
    }
}
