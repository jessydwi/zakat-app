<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\DistribusiZakat;
use App\Models\Mustahik;
use App\Models\JenisBantuan;
use App\Http\Requests\DistribusiZakatRequest;

class DistribusiZakatController extends Controller
{
    public function index(Request $request)
    {
        $query = DistribusiZakat::with(['mustahik.kategori', 'jenisBantuan']);

        if ($request->filled('bulan')) {
            $query->whereMonth('tanggal', $request->bulan);
        }

        if ($request->filled('tahun')) {
            $query->whereYear('tanggal', $request->tahun);
        }

        if ($request->filled('jenis')) {
            $query->whereHas('jenisBantuan', fn($q) => $q->where('slug', $request->jenis));
        }

        return view('admin.distribusi.index', [
            'distribusi' => $query->latest()->get(),
            'jenis' => $request->jenis,
        ]);
    }

    public function create(Request $request)
    {
        return view('admin.distribusi.create', [
            'mustahiks' => Mustahik::all(),
            'jenisBantuans' => JenisBantuan::all(),
            'slug' => optional(JenisBantuan::find($request->jenis_bantuan_id))->slug,
        ]);
    }

    public function store(DistribusiZakatRequest $request)
    {
        DistribusiZakat::create([
            'mustahik_id' => $request->mustahik_id,
            'jenis_bantuan_id' => $request->jenis_bantuan_id,
            'jumlah' => $request->jumlah,
            'tanggal' => $request->tanggal,
            'status' => 'disalurkan',
            'detail_json' => json_encode($request->detail),
        ]);

        return redirect()->route('admin.distribusi.index')->with('success', 'Distribusi berhasil disimpan.');
    }

    public function show($id)
    {
        $distribusi = DistribusiZakat::with(['mustahik.kategori', 'jenisBantuan'])->findOrFail($id);
        return view('admin.distribusi.show', compact('distribusi'));
    }

    public function edit($id)
    {
        $distribusi = DistribusiZakat::findOrFail($id);
        $mustahiks = Mustahik::all();
        $jenisBantuans = JenisBantuan::all();
        $slug = optional($distribusi->jenisBantuan)->slug;

        return view('admin.distribusi.edit', compact('distribusi', 'mustahiks', 'jenisBantuans', 'slug'));
    }
public function update(DistribusiZakatRequest $request, $id)
{
    $distribusi = DistribusiZakat::findOrFail($id);
    $slug = optional(JenisBantuan::find($request->jenis_bantuan_id))->slug;

    $detail = match ($slug) {
        'sembako' => [
            'jumlah_paket' => $request->detail['jumlah_paket'] ?? null,
            'jenis_barang' => $request->detail['jenis_barang'] ?? null,
        ],
        'modal-usaha' => [
            'jenis_usaha' => $request->detail['jenis_usaha'] ?? null,
            'modal' => $request->detail['modal'] ?? null,
            'pendampingan' => $request->detail['pendampingan'] ?? null,
        ],
        'beasiswa' => [
            'nama_siswa' => $request->detail['nama_siswa'] ?? null,
            'jenjang' => $request->detail['jenjang'] ?? null,
            'nominal' => $request->detail['nominal'] ?? null,
        ],
        'kesehatan' => [
            'nama_pasien' => $request->detail['nama_pasien'] ?? null,
            'jenis_pengobatan' => $request->detail['jenis_pengobatan'] ?? null,
            'biaya' => $request->detail['biaya'] ?? null,
        ],
        'uang-tunai' => [
            'nama_penerima' => $request->detail['nama_penerima'] ?? null,
            'nominal' => $request->detail['nominal'] ?? null,
            'tujuan' => $request->detail['tujuan'] ?? null,
        ],
        default => [],
    };

    $distribusi->update([
        'mustahik_id' => $request->mustahik_id,
        'jenis_bantuan_id' => $request->jenis_bantuan_id,
        'jumlah' => $request->jumlah,
        'tanggal' => $request->tanggal,
        'status' => $request->status ?? 'disalurkan',
        'detail_json' => json_encode($detail),
    ]);

    return redirect()->route('admin.distribusi.index')->with('success', 'Distribusi berhasil diperbarui.');
}

    public function destroy($id)
    {
        $distribusi = DistribusiZakat::findOrFail($id);
        $distribusi->delete();

        return redirect()->route('admin.distribusi.index')->with('success', 'Distribusi berhasil dihapus.');
    }

    public function cetak()
    {
        $distribusi = DistribusiZakat::with(['mustahik.kategori', 'jenisBantuan'])->latest()->get();
        return view('admin.distribusi.cetak', compact('distribusi'));
    }
}


