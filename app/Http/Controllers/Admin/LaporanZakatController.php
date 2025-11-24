<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\TransaksiZakat;
use App\Models\DistribusiZakat;
use App\Models\Muzakki;
use App\Models\Mustahik;
use App\Models\JenisZakat;
use App\Models\JenisBantuan;
use App\Models\MetodePembayaran;
use App\Models\BuktiPembayaran;
use App\Models\Amil;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Validator;

class LaporanZakatController extends Controller
{
    public function index(Request $request)
    {
        $start = $request->start ?? now()->startOfMonth()->toDateString();
        $end = $request->end ?? now()->endOfMonth()->toDateString();

        $totalMasuk = TransaksiZakat::whereBetween('tanggal', [$start, $end])
            ->where('status', 'terbayar')
            ->sum('nominal');

        $totalDistribusi = DistribusiZakat::whereBetween('tanggal', [$start, $end])
            ->sum('jumlah');

        $rekapMasuk = TransaksiZakat::with(['muzakki', 'jenisZakat', 'metodePembayaran', 'buktiPembayaran'])
            ->whereBetween('tanggal', [$start, $end])
            ->where('status', 'terbayar')
            ->orderBy('tanggal', 'desc')
            ->get();

        $rekapDistribusi = DistribusiZakat::with(['mustahik', 'jenisBantuan'])
            ->whereBetween('tanggal', [$start, $end])
            ->orderBy('tanggal', 'desc')
            ->get();

        return view('admin.laporan-zakat.index', compact(
            'totalMasuk',
            'totalDistribusi',
            'rekapMasuk',
            'rekapDistribusi',
            'start',
            'end'
        ));
    }

    public function show($id)
    {
        $transaksi = TransaksiZakat::with(['muzakki', 'jenisZakat', 'metodePembayaran', 'buktiPembayaran'])
            ->findOrFail($id);

        return view('admin.laporan-zakat.show', compact('transaksi'));
    }

    public function edit($id)
    {
        $transaksi = TransaksiZakat::findOrFail($id);
        $muzakki = Muzakki::all();
        $jenisZakat = JenisZakat::all();
        $metodePembayaran = MetodePembayaran::all();
        $amils = Amil::with('user')->get();

        return view('admin.laporan-zakat.edit', compact('transaksi', 'muzakki', 'jenisZakat', 'metodePembayaran', 'amils'));
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'muzakki_id' => 'required|exists:muzakki,id',
            'nama' => 'nullable|string|max:255',
            'jenis_kelamin' => 'nullable|in:Laki-laki,Perempuan',
            'kontak' => 'nullable|string|max:255',
            'tanggal' => 'required|date',
            'jenis_zakat_id' => 'required|exists:jenis_zakat,id',
            'metode_pembayaran_id' => 'required|exists:metode_pembayaran,id',
            'nominal' => 'required|numeric|min:0',
            'status' => 'required|in:terbayar,pending',
            'detail_json' => 'nullable|json',
            'bukti_pembayaran' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:2048',
            'amil_id' => 'required|exists:amil,id',

        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $transaksi = TransaksiZakat::findOrFail($id);
        $transaksi->update($request->only([
            'muzakki_id', 'nama', 'jenis_kelamin', 'kontak', 'tanggal',
            'jenis_zakat_id', 'metode_pembayaran_id', 'nominal', 'status', 'detail_json', 'amil_id'
        ]));

        // Simpan bukti pembayaran jika ada file
        if ($request->hasFile('bukti_pembayaran')) {
            $path = $request->file('bukti_pembayaran')->store('bukti', 'public');

            BuktiPembayaran::updateOrCreate(
                ['transaksi_id' => $transaksi->id],
                ['file_path' => $path, 'tanggal_upload' => now()]
            );
        }

        return redirect()->route('admin.laporan-zakat.show', $transaksi->id)
            ->with('success', 'Transaksi zakat berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $transaksi = TransaksiZakat::findOrFail($id);
        $transaksi->delete();

        return redirect()->route('admin.laporan.index')
            ->with('success', 'Transaksi zakat berhasil dihapus.');
    }

    // Distribusi
    public function showDistribusi($id)
    {
        $distribusi = DistribusiZakat::with(['mustahik', 'jenisBantuan'])->findOrFail($id);

        return view('admin.laporan-zakat.show-distribusi', compact('distribusi'));
    }

    public function editDistribusi($id)
    {
        $distribusi = DistribusiZakat::findOrFail($id);
        $mustahik = Mustahik::all();
        $jenisBantuan = JenisBantuan::all();

        return view('admin.laporan-zakat.edit-distribusi', compact('distribusi', 'mustahik', 'jenisBantuan'));
    }

    public function updateDistribusi(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'mustahik_id' => 'required|exists:mustahiks,id',
            'tanggal' => 'required|date',
            'jenis_bantuan_id' => 'required|exists:jenis_bantuans,id',
            'jumlah' => 'required|numeric|min:0',
            'detail_json' => 'nullable|json',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $distribusi = DistribusiZakat::findOrFail($id);
        $distribusi->update($request->only([
            'mustahik_id', 'tanggal', 'jenis_bantuan_id', 'jumlah', 'detail_json'
        ]));

        return redirect()->route('admin.laporan-zakat.show-distribusi', $distribusi->id)
            ->with('success', 'Distribusi zakat berhasil diperbarui.');
    }

        public function destroyDistribusi($id)
    {
        $distribusi = DistribusiZakat::findOrFail($id);
        $distribusi->forceDelete(); // 🔥 hapus permanen

        return redirect()->route('admin.laporan.index')
            ->with('success', 'Distribusi zakat berhasil dihapus permanen.');
    }

    public function exportPdf(Request $request)
{
    $start = $request->start ?? now()->startOfMonth()->toDateString();
    $end   = $request->end ?? now()->endOfMonth()->toDateString();

    $rekapMasuk = TransaksiZakat::with([
        'muzakki',
        'jenisZakat',
        'metodePembayaran',
        'amil.user',
        'buktiPembayaran'
    ])
    ->whereBetween('tanggal', [$start, $end])
    ->where('status', 'terbayar')
    ->orderBy('tanggal', 'desc')
    ->get();

    $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('admin.laporan-zakat.pdf', compact('rekapMasuk','start','end'));
    return $pdf->download("rekap-zakat-detail-{$start}-{$end}.pdf");
}

public function exportDistribusiRekapPdf(Request $request)
{
    $start = $request->start ?? now()->startOfMonth()->toDateString();
    $end   = $request->end ?? now()->endOfMonth()->toDateString();

    $rekapDistribusi = DistribusiZakat::with(['mustahik','jenisBantuan'])
        ->whereBetween('tanggal', [$start, $end])
        ->orderBy('tanggal', 'desc')
        ->get();

    $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('admin.laporan-zakat.rekap-distribusi-pdf', compact('rekapDistribusi','start','end'));
    return $pdf->download("rekap-distribusi-zakat-{$start}-{$end}.pdf");
}

}
