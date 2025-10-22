@extends('layouts.muzaki')

@section('title', 'Dashboard Muzaki')

@section('content')
<div class="bg-gradient-to-b from-green-50 to-gray-50 py-10 px-6 rounded-2xl shadow-inner space-y-10 animate-fade-in-up">

    <!-- Tentang Zakat, Infak, Sedekah -->
    <section class="bg-white p-8 rounded-2xl shadow-sm hover:shadow-md border border-green-100 transition">
        <h2 class="text-2xl font-bold text-green-800 mb-4 flex items-center gap-2">
            <i class="fas fa-hand-holding-heart text-green-600"></i>
            Tentang Zakat, Infak, dan Sedekah
        </h2>
        <p class="text-gray-700 leading-relaxed text-justify">
            <strong>Zakat</strong> adalah kewajiban harta bagi umat Islam yang mampu, diberikan kepada golongan yang berhak menerimanya.  
            <strong>Infak</strong> merupakan pemberian sukarela di luar zakat, tanpa batas waktu dan jumlah.  
            <strong>Sedekah</strong> meliputi segala bentuk kebaikan, baik berupa harta maupun non-harta, yang dilakukan dengan niat ikhlas.
        </p>
        <p class="mt-4 text-sm text-gray-500 italic border-l-4 border-green-400 pl-4">
            “Ambillah zakat dari sebagian harta mereka, dengan zakat itu kamu membersihkan dan mensucikan mereka...”  
            <span class="block mt-1">— (QS. At-Taubah: 103)</span>
        </p>
    </section>

    <!-- Keutamaan Zakat -->
    <section class="bg-white p-8 rounded-2xl shadow-sm hover:shadow-md border border-green-100 transition">
        <h2 class="text-2xl font-bold text-green-800 mb-4 flex items-center gap-2">
            <i class="fas fa-star text-yellow-500"></i>
            Keutamaan Menunaikan Zakat
        </h2>
        <ul class="list-disc pl-6 text-gray-700 space-y-2 leading-relaxed">
            <li>Menyucikan jiwa dan harta dari sifat kikir</li>
            <li>Menumbuhkan solidaritas sosial antar sesama</li>
            <li>Menolong fakir miskin serta kaum yang membutuhkan</li>
            <li>Mendatangkan keberkahan dan ketenangan hidup</li>
        </ul>
    </section>

    <!-- Statistik Zakat -->
    <section class="bg-white p-8 rounded-2xl shadow-sm hover:shadow-md border border-green-100 transition">
        <h2 class="text-2xl font-bold text-green-800 mb-6 flex items-center gap-2">
            <i class="fas fa-chart-line text-green-600"></i>
            Statistik Total Zakat
        </h2>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <!-- Zakat Fitrah -->
            <div class="bg-gradient-to-br from-green-50 to-white rounded-2xl shadow-sm border-l-4 border-green-500 p-6 hover:shadow-lg transition-all duration-300">
                <div class="flex items-center justify-between">
                    <div>
                        <h3 class="text-lg font-semibold text-green-700">Zakat Fitrah</h3>
                        <p class="text-2xl font-bold text-gray-800 mt-1">
                            Rp {{ number_format($zakatFitrah, 0, ',', '.') }}
                        </p>
                    </div>
                    <div class="w-12 h-12 bg-green-100 flex items-center justify-center rounded-full">
                        <i class="fas fa-bowl-rice text-green-600 text-xl"></i>
                    </div>
                </div>
            </div>

            <!-- Zakat Mal -->
            <div class="bg-gradient-to-br from-green-50 to-white rounded-2xl shadow-sm border-l-4 border-green-500 p-6 hover:shadow-lg transition-all duration-300">
                <div class="flex items-center justify-between">
                    <div>
                        <h3 class="text-lg font-semibold text-green-700">Zakat Mal</h3>
                        <p class="text-2xl font-bold text-gray-800 mt-1">
                            Rp {{ number_format($zakatMal, 0, ',', '.') }}
                        </p>
                    </div>
                    <div class="w-12 h-12 bg-green-100 flex items-center justify-center rounded-full">
                        <i class="fas fa-coins text-green-600 text-xl"></i>
                    </div>
                </div>
            </div>

            <!-- Zakat Fidyah -->
            <div class="bg-gradient-to-br from-green-50 to-white rounded-2xl shadow-sm border-l-4 border-green-500 p-6 hover:shadow-lg transition-all duration-300">
                <div class="flex items-center justify-between">
                    <div>
                        <h3 class="text-lg font-semibold text-green-700">Zakat Fidyah</h3>
                        <p class="text-2xl font-bold text-gray-800 mt-1">
                            Rp {{ number_format($zakatFidyah, 0, ',', '.') }}
                        </p>
                    </div>
                    <div class="w-12 h-12 bg-green-100 flex items-center justify-center rounded-full">
                        <i class="fas fa-bread-slice text-green-600 text-xl"></i>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Tombol Bayar -->
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
