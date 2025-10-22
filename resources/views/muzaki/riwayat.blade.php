@extends('layouts.muzaki')

@section('title', 'Riwayat Pembayaran Zakat')

@section('content')
<div class="max-w-6xl mx-auto bg-white/80 backdrop-blur-sm rounded-2xl shadow-lg p-8 animate-fade-in-up border border-emerald-100">

        <!-- Judul Halaman -->
        <div class="flex items-center justify-between mb-6 border-b border-emerald-100 pb-4">
            <h2 class="text-2xl font-bold text-emerald-800 flex items-center gap-2">
                📜 Riwayat Pembayaran Zakat
            </h2>
            <a href="{{ route('muzaki.bayar') }}"
               class="bg-emerald-600 hover:bg-emerald-700 text-white px-5 py-2.5 rounded-lg font-medium shadow-sm transition-all duration-300">
               + Bayar Zakat
            </a>
        </div>

        <!-- Tabel Riwayat -->
        <div class="overflow-x-auto rounded-xl border border-emerald-100 shadow-sm bg-white/70">
            <table class="min-w-full text-sm">
                <thead class="bg-emerald-100/80 text-emerald-900 uppercase tracking-wide">
                    <tr>
                        <th class="px-6 py-3 text-left font-semibold">Tanggal</th>
                        <th class="px-6 py-3 text-left font-semibold">Jenis Zakat</th>
                        <th class="px-6 py-3 text-left font-semibold">Jumlah (Rp)</th>
                        <th class="px-6 py-3 text-left font-semibold">Status</th>
                        <th class="px-6 py-3 text-left font-semibold">Bukti Pembayaran</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-emerald-50">
                    @forelse($riwayat as $item)
                        <tr class="hover:bg-emerald-50 transition duration-200">
                            <td class="px-6 py-3 text-gray-800">
                                {{ \Carbon\Carbon::parse($item->tanggal)->format('d M Y') }}
                            </td>
                            <td class="px-6 py-3 text-gray-700 font-medium">
                                {{ $item->jenisZakat->nama_jenis }}
                            </td>
                            <td class="px-6 py-3 font-semibold text-gray-900">
                                Rp {{ number_format($item->nominal, 0, ',', '.') }}
                            </td>
                            <td class="px-6 py-3">
                                @if($item->status === 'terkonfirmasi')
                                    <span class="px-3 py-1 text-sm font-semibold text-emerald-800 bg-emerald-100 rounded-full">
                                        ✔️ Terkonfirmasi
                                    </span>
                                @else
                                    <span class="px-3 py-1 text-sm font-semibold text-amber-800 bg-amber-100 rounded-full">
                                        ⏳ Menunggu
                                    </span>
                                @endif
                            </td>
                            <td class="px-6 py-3">
                                <a href="{{ route('transaksi.pdf', $item->id) }}" target="_blank"
                                   class="text-emerald-700 hover:text-emerald-900 font-medium underline-offset-2 hover:underline">
                                    Unduh PDF
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center py-6 text-gray-500">
                                Belum ada riwayat pembayaran zakat.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Catatan -->
        <div class="mt-6 text-sm text-gray-600 bg-emerald-50/80 border border-emerald-100 p-4 rounded-xl">
            <p>💡 <strong>Catatan:</strong> Status pembayaran akan berubah menjadi 
                <span class="text-emerald-700 font-semibold">“Terkonfirmasi”</span> 
                setelah diverifikasi oleh admin.
            </p>
        </div>
</div>

<!-- Animasi Lembut -->
<style>
    @keyframes fadeInUp {
        from { opacity: 0; transform: translateY(15px); }
        to { opacity: 1; transform: translateY(0); }
    }
    .animate-fade-in-up {
        animation: fadeInUp 0.5s ease-out;
    }
</style>
@endsection
