<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;   // ✅ ini yang hilang
use App\Models\Notifikasi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NotificationController extends Controller
{
    // Menampilkan semua notifikasi milik user yang login
    public function index()
    {
        $notifikasi = [];
        if (!Auth::user()->role === 'admin') {
            $notifikasi = Notifikasi::where('user_id', Auth::id())
                ->latest('created_at') // lebih idiomatik daripada orderBy
                ->get();
        } else {
            $notifikasi = Notifikasi::latest('created_at')->get();
        }

        return view('admin.notifications.index', compact('notifikasi'));
    }

    // Menandai satu notifikasi sebagai dibaca
    public function markAsRead($id)
    {
        $notif = Notifikasi::where('user_id', Auth::id())->findOrFail($id);
        $notif->update(['status_baca' => true]);

        return back()->with('success', 'Notifikasi telah ditandai sebagai dibaca.');
    }

    // Tambah notifikasi baru (bisa dipanggil dari controller lain)
    public static function create($judul, $pesan)
    {
        Notifikasi::create([
            'user_id' => Auth::id(),
            'judul' => $judul,
            'pesan' => $pesan,
            'tanggal' => now(),
        ]);
    }

    public function show($id)
    {
        $notif = Notifikasi::findOrFail($id);
        return view('admin.notifications.show', compact('notif'));
    }
}
