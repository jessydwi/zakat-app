<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\TransaksiZakat;
use Illuminate\Support\Facades\Auth;

class ZakatKonfirmasi extends Component
{
    public function konfirmasi($id)
    {
        $transaksi = TransaksiZakat::findOrFail($id);
        $user = Auth::user();

        // Validasi: pastikan user punya relasi amil
        if (!$user || !$user->amil) {
            session()->flash('error', 'User ini belum terdaftar sebagai amil.');
            return;
        }

        // Update status dan amil_id
        $transaksi->update([
            'status' => 'terbayar',
            'amil_id' => $user->amil->id,
        ]);

        session()->flash('success', 'Transaksi berhasil dikonfirmasi oleh ' . $user->nama);
    }

    public function render()
    {
        $pending = TransaksiZakat::with('muzakki')->where('status', 'menunggu')->get();

        return view('livewire.zakat-konfirmasi', compact('pending'));
    }
}
