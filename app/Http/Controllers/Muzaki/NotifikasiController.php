<?php

namespace App\Http\Controllers\Muzaki;

use App\Http\Controllers\Controller;
use App\Models\Notifikasi;
use Illuminate\Http\Request;

class NotifikasiController extends Controller
{
    public function index()
    {
        $notifikasi = Notifikasi::where('user_id', auth()->id())
            ->orderBy('tanggal', 'desc')
            ->get();

        return view('muzaki.notifikasi.index', compact('notifikasi'));
    }

    public function show($id)
    {
        $notif = Notifikasi::where('user_id', auth()->id())->findOrFail($id);

        // tandai terbaca
        if (!$notif->status_baca) {
            $notif->update(['status_baca' => 1]);
        }

        return view('muzaki.notifikasi.show', compact('notif'));
    }

    public function baca($id)
    {
        $notif = Notifikasi::where('user_id', auth()->id())->findOrFail($id);
        $notif->update(['status_baca' => 1]);

        return back()->with('success', 'Notifikasi ditandai sebagai dibaca.');
    }
}
