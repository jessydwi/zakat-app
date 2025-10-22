<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Mustahik;
use App\Models\KategoriMustahik;
use Illuminate\Http\Request;

class ManajemenMustahikController extends Controller
{
    public function index()
    {
        $mustahikList = Mustahik::with('kategori')->latest()->paginate(10);
        return view('admin.mustahik.index', compact('mustahikList'));
    }

    public function create()
    {
        $kategoriList = KategoriMustahik::all();
        return view('admin.mustahik.create', compact('kategoriList'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:100',
            'alamat' => 'required|string',
            'kategori_id' => 'required|exists:kategori_mustahik,id',
            'no_hp' => 'nullable|string|max:20',
            'status_penyaluran' => 'required|string',
        ]);

        Mustahik::create($request->all());
        return redirect()->route('admin.mustahik.index')->with('success', 'Mustahik berhasil ditambahkan.');
    }

    public function edit(Mustahik $mustahik)
    {
        $kategoriList = KategoriMustahik::all();
        return view('admin.mustahik.edit', compact('mustahik', 'kategoriList'));
    }

    public function update(Request $request, Mustahik $mustahik)
    {
        $request->validate([
            'nama' => 'required|string|max:100',
            'alamat' => 'required|string',
            'kategori_id' => 'required|exists:kategori_mustahik,id',
            'no_hp' => 'nullable|string|max:20',
            'status_penyaluran' => 'required|string',
        ]);

        $mustahik->update($request->all());
        return redirect()->route('admin.mustahik.index')->with('success', 'Mustahik berhasil diperbarui.');
    }

    public function destroy(Mustahik $mustahik)
    {
        $mustahik->delete();
        return back()->with('success', 'Mustahik berhasil dihapus.');
    }
}

