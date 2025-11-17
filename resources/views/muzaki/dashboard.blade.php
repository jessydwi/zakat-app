@extends('layouts.muzaki')

@section('title', 'Dashboard Muzaki')

@section('content')
<div class="bg-gradient-to-b from-green-50 to-gray-50 py-10 px-6 rounded-2xl shadow-inner space-y-10 animate-fade-in-up">

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

<!-- Statistik -->
<section class="bg-white p-8 rounded-2xl shadow-sm hover:shadow-md border border-green-100 transition">
    <h2 class="text-2xl font-bold text-green-800 mb-8 flex items-center gap-3">
        <i class="fas fa-chart-line text-green-600 text-xl"></i>
        Statistik Total Zakat
    </h2>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">

        <!-- Card Item -->
        <div class="group bg-gradient-to-br from-green-50 to-white rounded-2xl border border-green-100 p-6 shadow-sm hover:shadow-lg transition-all duration-300">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-500">Zakat Fitrah</p>
                    <h3 class="text-3xl font-extrabold text-green-700 mt-1">
                        Rp {{ number_format($zakatFitrah, 0, ',', '.') }}
                    </h3>
                </div>
                <div class="w-14 h-14 flex items-center justify-center rounded-full bg-green-100 group-hover:bg-green-200 transition">
                    <i class="fas fa-bowl-rice text-green-600 text-2xl"></i>
                </div>
            </div>
        </div>

        <div class="group bg-gradient-to-br from-green-50 to-white rounded-2xl border border-green-100 p-6 shadow-sm hover:shadow-lg transition-all duration-300">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-500">Zakat Mal</p>
                    <h3 class="text-3xl font-extrabold text-green-700 mt-1">
                        Rp {{ number_format($zakatMal, 0, ',', '.') }}
                    </h3>
                </div>
                <div class="w-14 h-14 flex items-center justify-center rounded-full bg-green-100 group-hover:bg-green-200 transition">
                    <i class="fas fa-coins text-green-600 text-2xl"></i>
                </div>
            </div>
        </div>

        <div class="group bg-gradient-to-br from-green-50 to-white rounded-2xl border border-green-100 p-6 shadow-sm hover:shadow-lg transition-all duration-300">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-500">Zakat Fidyah</p>
                    <h3 class="text-3xl font-extrabold text-green-700 mt-1">
                        Rp {{ number_format($zakatFidyah, 0, ',', '.') }}
                    </h3>
                </div>
                <div class="w-14 h-14 flex items-center justify-center rounded-full bg-green-100 group-hover:bg-green-200 transition">
                    <i class="fas fa-bread-slice text-green-600 text-2xl"></i>
                </div>
            </div>
        </div>

        <div class="group bg-gradient-to-br from-green-50 to-white rounded-2xl border border-green-100 p-6 shadow-sm hover:shadow-lg transition-all duration-300">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-500">Infak</p>
                    <h3 class="text-3xl font-extrabold text-green-700 mt-1">
                        Rp {{ number_format($zakatInfak, 0, ',', '.') }}
                    </h3>
                </div>
                <div class="w-14 h-14 flex items-center justify-center rounded-full bg-green-100 group-hover:bg-green-200 transition">
                    <i class="fas fa-hand-holding-heart text-green-600 text-2xl"></i>
                </div>
            </div>
        </div>

        <div class="group bg-gradient-to-br from-green-50 to-white rounded-2xl border border-green-100 p-6 shadow-sm hover:shadow-lg transition-all duration-300 md:col-span-2 xl:col-span-1">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-500">Total Semua Zakat</p>
                    <h3 class="text-3xl font-extrabold text-green-700 mt-1">
                        Rp {{ number_format($totalZakat, 0, ',', '.') }}
                    </h3>
                </div>
                <div class="w-14 h-14 flex items-center justify-center rounded-full bg-green-100 group-hover:bg-green-200 transition">
                    <i class="fas fa-sack-dollar text-green-600 text-2xl"></i>
                </div>
            </div>
        </div>

    </div>
</section>

    <!-- Riwayat Transaksi -->
    <section class="bg-white p-8 rounded-2xl shadow-sm hover:shadow-md border border-green-100 transition">
        <h2 class="text-2xl font-bold text-green-800 mb-4 flex items-center gap-2">
            <i class="fas fa-receipt text-green-600"></i>
            Riwayat Transaksi Terakhir
        </h2>

        <ul class="space-y-3">
            @foreach($riwayatZakat as $r)
                <li class="p-4 bg-green-50 rounded-xl border border-green-200 flex justify-between">
                    <div>
                        <strong>{{ $r->jenisZakat->nama_jenis }}</strong><br>
                        <span class="text-gray-600 text-sm">{{ $r->tanggal }}</span>
                    </div>

                    <span class="font-bold text-green-700">
                        Rp {{ number_format($r->nominal, 0, ',', '.') }}
                    </span>
                </li>
            @endforeach
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
.animate-fade-in-up { animation: fadeInUp 0.6s ease-out; }
</style>

@endsection
