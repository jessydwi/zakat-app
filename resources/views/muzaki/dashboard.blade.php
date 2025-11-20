@extends('layouts.muzaki')

@section('title', 'Dashboard Muzaki')

@section('content')
<div class="bg-gradient-to-b from-green-50 to-gray-50 py-10 px-6 rounded-2xl shadow-inner space-y-10 animate-fade-in-up">

    <!-- Statistik -->
    <section class="bg-white p-8 rounded-2xl shadow-sm hover:shadow-md border border-green-100 transition">
        <h2 class="text-2xl font-bold text-green-800 mb-8 flex items-center gap-3">
            <i class="fas fa-chart-line text-green-600 text-xl"></i>
            Statistik Total Zakat
        </h2>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">

            <!-- Zakat Fitrah -->
            <x-dashboard.card 
                title="Zakat Fitrah"
                value="{{ number_format($zakatFitrah ?? 0, 0, ',', '.') }}"
                icon="fa-bowl-rice" 
            />

            <!-- Zakat Mal -->
            <x-dashboard.card 
                title="Zakat Mal"
                value="{{ number_format($zakatMal ?? 0, 0, ',', '.') }}"
                icon="fa-coins" 
            />

            <!-- Fidyah -->
            <x-dashboard.card 
                title="Zakat Fidyah"
                value="{{ number_format($zakatFidyah ?? 0, 0, ',', '.') }}"
                icon="fa-bread-slice" 
            />

            <!-- Infak -->
            <x-dashboard.card 
                title="Infak"
                value="{{ number_format($zakatInfak ?? 0, 0, ',', '.') }}"
                icon="fa-hand-holding-heart" 
            />

            <!-- Total Semua -->
            <x-dashboard.card 
                title="Total Semua Zakat"
                value="{{ number_format($totalZakat ?? 0, 0, ',', '.') }}"
                icon="fa-sack-dollar"
                class="md:col-span-2 xl:col-span-1"
            />

        </div>
    </section>

    <!-- Riwayat -->
    <section class="bg-white p-8 rounded-2xl shadow-sm hover:shadow-md border border-green-100 transition">
        <h2 class="text-2xl font-bold text-green-800 mb-6 flex items-center gap-2">
            <i class="fas fa-receipt text-green-600"></i>
            Riwayat Transaksi Terakhir
        </h2>

        @if($riwayatZakat->isEmpty())
            <p class="text-gray-500 text-center italic">Belum ada riwayat transaksi.</p>
        @else
            <ul class="space-y-3">
                @foreach($riwayatZakat as $r)
                    <li class="p-4 bg-green-50 rounded-xl border border-green-200 flex justify-between items-center">
                        <div>
                            <strong>
                                {{ $r->jenisZakat->nama_jenis ?? 'Tidak diketahui' }}
                            </strong>
                            <div class="text-gray-600 text-sm">
                                {{ $r->tanggal ? date('d M Y', strtotime($r->tanggal)) : '-' }}
                            </div>
                        </div>

                        <span class="font-bold text-green-700">
                            Rp {{ number_format($r->nominal ?? 0, 0, ',', '.') }}
                        </span>
                    </li>
                @endforeach
            </ul>
        @endif
    </section>


        <!-- Tentang Zakat -->
    <section class="bg-white p-8 rounded-2xl shadow-sm hover:shadow-md border border-green-100 transition">
        <h2 class="text-2xl font-bold text-green-800 mb-4 flex items-center gap-2">
            <i class="fas fa-hand-holding-heart text-green-600"></i>
            Tentang Zakat, Infak, dan Sedekah
        </h2>

        <p class="text-gray-700 leading-relaxed text-justify">
            <strong>Zakat</strong> adalah kewajiban harta bagi umat Islam yang mampu...
        </p>

        <p class="mt-4 text-sm text-gray-500 italic border-l-4 border-green-400 pl-4">
            “Ambillah zakat dari sebagian harta mereka...”
            <span class="block mt-1">— (QS. At-Taubah: 103)</span>
        </p>
    </section>

    <!-- Keutamaan -->
    <section class="bg-white p-8 rounded-2xl shadow-sm hover:shadow-md border border-green-100 transition">
        <h2 class="text-2xl font-bold text-green-800 mb-4 flex items-center gap-2">
            <i class="fas fa-star text-yellow-500"></i>
            Keutamaan Menunaikan Zakat
        </h2>

        <ul class="list-disc pl-6 text-gray-700 space-y-2 leading-relaxed">
            <li>Menyucikan jiwa dan harta</li>
            <li>Menolong fakir miskin</li>
            <li>Menumbuhkan solidaritas sosial</li>
            <li>Mendatangkan keberkahan</li>
        </ul>
    </section>

        <!-- Tombol -->
    <div class="text-center mt-10">
        <a href="{{ route('muzaki.bayar') }}"
           class="inline-flex items-center gap-2 bg-green-600 text-white px-8 py-3 rounded-full text-lg font-semibold shadow hover:bg-green-700 hover:shadow-md transition-all duration-300">
            <i class="fas fa-hand-holding-dollar"></i>
            Bayar Zakat Sekarang
        </a>
    </div>

</div>

<!-- Animasi -->
<style>
@keyframes fadeInUp {
    from { opacity: 0; transform: translateY(15px); }
    to { opacity: 1; transform: translateY(0); }
}
.animate-fade-in-up {
    animation: fadeInUp 0.6s ease-out;
}
</style>

@endsection
