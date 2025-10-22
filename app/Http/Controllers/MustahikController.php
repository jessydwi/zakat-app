<?php
namespace App\Http\Controllers;

use App\Models\Mustahik;
use App\Models\KategoriMustahik;
use Illuminate\Http\Request;

class MustahikController extends Controller
{
    public function index()
    {
        $mustahik = Mustahik::with('kategori')->get();
        return view('admin.mustahik.index', compact('mustahik'));
    }

    public function create()
    {
        $kategori = KategoriMustahik::all();
        return view('admin.mustahik.create', compact('kategori'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'alamat' => 'nullable|string',
            'kategori_mustahik_id' => 'required|exists:kategori_mustahik,id',
        ]);

        Mustahik::create($request->all());
        return redirect()->route('admin.mustahik.index')->with('success', 'Mustahik berhasil ditambahkan.');
    }

    public function show($id)
    {
        $mustahik = Mustahik::with('kategori')->findOrFail($id);
        return response()->json([
            'nama' => $mustahik->nama,
            'kategori' => $mustahik->kategori->nama_kategori ?? '-',
            'alamat' => $mustahik->alamat ?? '-',
            'jumlah_terakhir' => number_format(
                $mustahik->distribusi()->latest()->value('jumlah') ?? 0,
                0, ',', '.'
            ),
        ]);
    }

    public function edit($id)
    {
        $mustahik = Mustahik::findOrFail($id);
        $kategori = KategoriMustahik::all();
        return view('admin.mustahik.edit', compact('mustahik', 'kategori'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'alamat' => 'nullable|string',
            'kategori_mustahik_id' => 'required|exists:kategori_mustahik,id',
        ]);

        $mustahik = Mustahik::findOrFail($id);
        $mustahik->update($request->all());

        return redirect()->route('admin.mustahik.index')->with('success', 'Mustahik berhasil diperbarui.');
    }

    public function destroy($id)
    {
        Mustahik::findOrFail($id)->delete();
        return redirect()->route('admin.mustahik.index')->with('success', 'Mustahik berhasil dihapus.');
    }
}
