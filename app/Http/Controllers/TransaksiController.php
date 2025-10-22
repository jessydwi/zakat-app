<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\TransaksiZakat;

class TransaksiController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'muzakki_id' => 'required|exists:users,id',
            'jenis_zakat_id' => 'required|exists:jenis_zakat,id',
            'nominal' => 'required|numeric|min:1000',
            'metode' => 'required|string',
            'kontak' => 'required|string',
            'tanggal' => 'required|date',
        ]);

        TransaksiZakat::create($request->only([
            'muzakki_id',
            'jenis_zakat_id',
            'nominal',
            'metode',
            'kontak',
            'tanggal',
        ]));

        return redirect()->route('muzaki.dashboard')->with('success', 'Pembayaran zakat berhasil disimpan.');
    }
}
