<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\TransaksiZakat;

class ZakatTable extends Component
{
    public function render()
    {
        $transaksi = TransaksiZakat::with('muzakki', 'jenisZakat')->latest()->get();

        return view('livewire.zakat-table', compact('transaksi'));
    }
}

