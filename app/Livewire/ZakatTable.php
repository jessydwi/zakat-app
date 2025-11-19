<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\TransaksiZakat;

class ZakatTable extends Component
{
    public function render()
    {
        $transaksi = TransaksiZakat::select([
        'id','muzakki_id','nama','jenis_zakat_id','metode_id',
        'nominal','tanggal','status','amil_id','created_at'
    ])
    ->with(['muzakki','jenisZakat','amil.user'])
    ->latest()
    ->get();

        return view('livewire.zakat-table', compact('transaksi'));
    }
}

