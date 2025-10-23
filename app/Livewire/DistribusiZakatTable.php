<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\DistribusiZakat;

class DistribusiZakatTable extends Component
{
    public $jenis = null; // default

    public function mount($jenis = null)
    {
        $this->jenis = $jenis;
    }

    public function render()
    {
        $distribusi = DistribusiZakat::with(['mustahik', 'jenisBantuan'])
            ->when($this->jenis, function ($query) {
                $query->whereHas('jenisBantuan', fn($q) => $q->where('slug', $this->jenis));
            })
            ->latest()
            ->get();

        return view('livewire.distribusi-zakat-table', [
            'distribusi' => $distribusi,
            'jenis' => $this->jenis,
        ]);
    }
}
