<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\TransaksiZakat;

class ZakatKonfirmasi extends Component
{
    public function konfirmasi($id)
    {
        TransaksiZakat::where('id', $id)->update(['status' => 'terbayar']);
    }

    public function render()
    {
        $pending = TransaksiZakat::with('muzakki')->where('status', 'menunggu')->get();

        return view('livewire.zakat-konfirmasi', compact('pending'));
    }
}

