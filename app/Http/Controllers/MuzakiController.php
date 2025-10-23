<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\TransaksiZakat;
use App\Models\JenisZakat;

class MuzakiController extends Controller
{
    // ✅ Dashboard Muzaki
    public function dashboard()
    {
        $user = Auth::user();

        // Proteksi akses hanya untuk role muzaki
        if ($user->role !== 'muzaki') {
            abort(403, 'Unauthorized');
        }

        $userId = $user->id;

        // Total zakat pribadi berdasarkan jenis
        $zakatFitrah = TransaksiZakat::where('muzakki_id', $userId)
            ->whereHas('jenisZakat', fn($q) => $q->where('nama_jenis', 'fitrah'))
            ->sum('nominal');

        $zakatMal = TransaksiZakat::where('muzakki_id', $userId)
            ->whereHas('jenisZakat', fn($q) => $q->where('nama_jenis', 'mal'))
            ->sum('nominal');

        $zakatFidyah = TransaksiZakat::where('muzakki_id', $userId)
            ->whereHas('jenisZakat', fn($q) => $q->where('nama_jenis', 'fidyah'))
            ->sum('nominal');

        // Total zakat semua jenis
        $totalZakat = $zakatFitrah + $zakatMal + $zakatFidyah;

        // Jumlah penerima manfaat (opsional)
        $totalPenerima = DB::table('mustahik')->count();

        // Grafik zakat pribadi per bulan
        $grafikZakat = TransaksiZakat::select(
            DB::raw("EXTRACT(MONTH FROM tanggal) AS bulan"),
            DB::raw("SUM(nominal) AS total")
        )
        ->where('muzakki_id', $userId)
        ->whereYear('tanggal', now()->year)
        ->groupBy(DB::raw("EXTRACT(MONTH FROM tanggal)"))
        ->orderBy(DB::raw("EXTRACT(MONTH FROM tanggal)"))
        ->get();

        // Riwayat transaksi zakat pribadi
        $riwayatZakat = TransaksiZakat::with('jenisZakat')
            ->where('muzakki_id', $userId)
            ->latest('tanggal')
            ->take(5)
            ->get();

        return view('muzaki.dashboard', compact(
            'zakatFitrah',
            'zakatMal',
            'zakatFidyah',
            'totalZakat',
            'totalPenerima',
            'grafikZakat',
            'riwayatZakat'
        ));
    }

    // ✅ Form Pembayaran Zakat
    public function formPembayaran()
    {
        $user = Auth::user();

        // Proteksi akses hanya untuk role muzaki
        if ($user->role !== 'muzaki') {
            abort(403, 'Unauthorized');
        }

        $jenisZakat = JenisZakat::all();

        return view('muzaki.form-pembayaran', compact('jenisZakat',));
    }

    public function kalkulator()
    {
        $user = Auth::user();

        if ($user->role !== 'muzaki') {
            abort(403);
        }

        $jenisZakat = JenisZakat::all();

        return view('muzaki.kalkulator', compact('jenisZakat'));
    }

    public function riwayat()
    {
        $user = Auth::user();

        if ($user->role !== 'muzaki') {
            abort(403);
        }

        $riwayat = TransaksiZakat::with('jenisZakat')
                ->where('muzakki_id', $user->id)
                ->orderByDesc('tanggal')
                ->get();

        return view('muzaki.riwayat', compact('riwayat'));
    }

    public function informasi()
    {
        $user = Auth::user();

        if ($user->role !== 'muzaki') {
            abort(403);
        }

        return view('muzaki.informasi');
    }

}
