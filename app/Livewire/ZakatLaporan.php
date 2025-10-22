<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\TransaksiZakat;

class ZakatLaporan extends Component
{
    public $start, $end;

    public function render()
    {
        $laporan = TransaksiZakat::whereBetween('tanggal', [$this->start, $this->end])->get();

        return view('livewire.zakat-laporan', compact('laporan'));
    }
}

