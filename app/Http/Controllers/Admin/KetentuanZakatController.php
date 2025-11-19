<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\KetentuanZakat;

class KetentuanZakatController extends Controller
{
   public function index() {
    $data = KetentuanZakat::query()
        ->orderBy('jenis_zakat')
        ->get()
        ->fresh()
        ->groupBy('jenis_zakat');

    return view('admin.pengaturan.ketentuan', compact('data'));
}


   public function store(Request $request) {
    $request->validate([
        'jenis_zakat' => 'required|in:fitrah,penghasilan,mal',
    ]);

    if ($request->jenis_zakat === 'penghasilan') {
        // Validasi lengkap untuk penghasilan
        $request->validate([
            'satuan'         => 'required|string|max:20',
            'nilai'          => 'required|numeric|min:0',
            'satuan_tahun'   => 'required|string|max:20',
            'nilai_tahun'    => 'required|numeric|min:0',
            'satuan_bulan'   => 'required|string|max:20',
            'nilai_bulan'    => 'required|numeric|min:0',
            'satuan_harian'  => 'required|string|max:20',
            'nilai_harian'   => 'required|numeric|min:0',
            'keterangan'     => 'nullable|string|max:255',
        ]);

        // Simpan semua parameter penghasilan
        $penghasilanParams = [
            ['parameter' => 'persentase',   'satuan' => $request->satuan,         'nilai' => $request->nilai],
            ['parameter' => 'nisab_tahun',  'satuan' => $request->satuan_tahun,   'nilai' => $request->nilai_tahun],
            ['parameter' => 'nisab_bulan',  'satuan' => $request->satuan_bulan,   'nilai' => $request->nilai_bulan],
            ['parameter' => 'nisab_harian', 'satuan' => $request->satuan_harian,  'nilai' => $request->nilai_harian],
        ];

        foreach ($penghasilanParams as $param) {
            KetentuanZakat::create([
                'jenis_zakat' => 'penghasilan',
                'parameter'   => $param['parameter'],
                'satuan'      => $param['satuan'],
                'nilai'       => $param['nilai'],
                'keterangan'  => $request->keterangan,
            ]);
        }
    } elseif (in_array($request->jenis_zakat, ['fitrah', 'mal'])) {
        // Validasi untuk fitrah dan mal
        $request->validate([
            'parameter'  => 'required|string|max:50',
            'satuan'     => 'required|string|max:20',
            'nilai'      => 'required|numeric|min:0',
            'keterangan' => 'nullable|string|max:255',
        ]);

        KetentuanZakat::create([
            'jenis_zakat' => $request->jenis_zakat,
            'parameter'   => $request->parameter,
            'satuan'      => $request->satuan,
            'nilai'       => $request->nilai,
            'keterangan'  => $request->keterangan,
        ]);
    }

    return back()->with('success', 'Ketentuan berhasil ditambahkan.');
}


    public function update(Request $request, KetentuanZakat $ketentuan) {
        $request->validate([
            'parameter' => 'required|string|max:50',
            'satuan' => 'required|string|max:20',
            'nilai' => 'required|numeric|min:0',
            'keterangan' => 'nullable|string|max:255',
        ]);

        $ketentuan->update($request->all());
        return back()->with('success', 'Ketentuan berhasil diperbarui.');
    }
    
    public function edit(KetentuanZakat $ketentuan) {
        return view('admin.pengaturan.ketentuan_edit', compact('ketentuan'));
    }


    public function destroy(KetentuanZakat $ketentuan)
{
    $ketentuan->forceDelete(); // hapus permanen dari database
    return redirect()->route('admin.ketentuan.index')
        ->with('success', 'Ketentuan berhasil dihapus secara permanen.');
}

}
