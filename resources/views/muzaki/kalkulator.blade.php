@extends('layouts.muzaki')

@section('title', 'Kalkulator Zakat')

@section('content')
<div class="bg-gradient-to-br from-green-50 to-white p-8 rounded-2xl shadow-xl max-w-3xl mx-auto fade-in">
    <h2 class="text-3xl font-extrabold text-green-700 mb-8 text-center flex items-center justify-center gap-3">
        <i class="fas fa-calculator text-green-600"></i>
        Kalkulator Zakat
    </h2>

    <!-- Tabs -->
    <div class="flex justify-center gap-4 mb-10">
        <button type="button" onclick="switchTab('maal')" id="tabMaal"
            class="tab-btn active-tab">
            <i class="fas fa-coins mr-2"></i> Zakat Maal
        </button>
        <button type="button" onclick="switchTab('penghasilan')" id="tabPenghasilan"
            class="tab-btn">
            <i class="fas fa-briefcase mr-2"></i> Zakat Penghasilan
        </button>
    </div>

    <form id="formKalkulator" class="space-y-6">
        <!-- Zakat Maal -->
        <div id="formMaal" class="space-y-4">
            @foreach ([
                'emas' => 'Nilai emas, perak, dan/atau permata',
                'tabungan' => 'Uang tunai, tabungan, deposito',
                'aset' => 'Kendaraan, rumah, aset lain',
                'hutang' => 'Jumlah hutang/cicilan (opsional)'
            ] as $id => $label)
            <div>
                <label for="{{ $id }}" class="block text-sm font-semibold text-gray-700 mb-2">{{ $label }}</label>
                <div class="relative">
                    <span class="absolute left-3 top-1/2 -translate-y-1/2 text-gray-500">Rp</span>
                    <input type="number" id="{{ $id }}"
                           class="w-full border border-gray-300 rounded-xl pl-10 pr-3 py-2 focus:ring-2 focus:ring-green-400 focus:border-green-400 transition"
                           placeholder="Masukkan nominal" {{ $id !== 'hutang' ? 'required' : '' }}>
                </div>
            </div>
            @endforeach
        </div>

        <!-- Zakat Penghasilan -->
        <div id="formPenghasilan" class="hidden space-y-4">
            <label for="penghasilan" class="block text-sm font-semibold text-gray-700 mb-2">Total Penghasilan Bulanan</label>
            <div class="relative">
                <span class="absolute left-3 top-1/2 -translate-y-1/2 text-gray-500">Rp</span>
                <input type="number" id="penghasilan"
                       class="w-full border border-gray-300 rounded-xl pl-10 pr-3 py-2 focus:ring-2 focus:ring-green-400 focus:border-green-400 transition"
                       placeholder="Masukkan nominal penghasilan" required>
            </div>
        </div>

        <!-- Tombol -->
        <div class="flex justify-between items-center pt-6 border-t border-gray-200">
            <button type="button" onclick="resetForm()"
                    class="flex items-center gap-2 bg-gray-200 text-gray-700 px-6 py-2.5 rounded-lg hover:bg-gray-300 transition-all duration-200 font-medium shadow-sm">
                <i class="fas fa-rotate-left"></i> Reset
            </button>
            <button type="button" onclick="hitungZakat()"
                    class="flex items-center gap-2 bg-gradient-to-r from-green-600 to-emerald-600 text-white px-6 py-2.5 rounded-lg hover:from-green-700 hover:to-emerald-700 transition-all duration-200 font-medium shadow-lg hover:shadow-xl transform hover:-translate-y-0.5">
                <i class="fas fa-check-circle"></i> Hitung Zakat
            </button>
        </div>

        <!-- Hasil -->
        <div id="hasilZakatWrapper" class="mt-8 hidden animate-fade-in-up">
            <div class="bg-green-50 border border-green-200 rounded-xl p-5 flex flex-col sm:flex-row items-center justify-between gap-4 shadow-inner">
                <div>
                    <p class="text-sm text-gray-600">Jumlah zakat yang harus dibayarkan:</p>
                    <p id="hasilZakat" class="text-3xl font-extrabold text-green-700 mt-1"></p>
                </div>
                <a href="{{ route('muzaki.bayar') }}"
                   class="inline-flex items-center gap-2 bg-gradient-to-r from-green-600 to-emerald-600 text-white px-6 py-3 rounded-lg hover:from-green-700 hover:to-emerald-700 transition-all duration-200 font-medium shadow-md hover:shadow-lg">
                    <i class="fas fa-hand-holding-heart"></i> Bayar Sekarang
                </a>
            </div>
        </div>
    </form>

    <p class="mt-8 text-sm text-gray-500 text-center leading-relaxed">
        💡 Informasi yang Anda masukkan digunakan hanya untuk simulasi.  
        Perhitungan sesuai ketentuan <span class="font-semibold text-green-700">syariah zakat 2.5%</span>.
    </p>
</div>

<!-- Style tambahan -->
<style>
    .tab-btn {
        @apply px-6 py-2.5 rounded-full font-semibold text-gray-600 bg-gray-100 hover:bg-green-100 hover:text-green-700 shadow transition-all duration-300;
    }
    .active-tab {
        @apply bg-green-600 text-white shadow-lg scale-105;
    }
    .fade-in {
        animation: fadeIn 0.5s ease-in-out;
    }
    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(10px); }
        to { opacity: 1; transform: translateY(0); }
    }
    .animate-fade-in-up {
        animation: fadeInUp 0.5s ease-out;
    }
    @keyframes fadeInUp {
        from { opacity: 0; transform: translateY(15px); }
        to { opacity: 1; transform: translateY(0); }
    }
</style>

<script>
    function switchTab(tab) {
        const formMaal = document.getElementById('formMaal');
        const formPenghasilan = document.getElementById('formPenghasilan');
        const tabMaal = document.getElementById('tabMaal');
        const tabPenghasilan = document.getElementById('tabPenghasilan');

        // Reset visual
        tabMaal.classList.remove('active-tab');
        tabPenghasilan.classList.remove('active-tab');
        formMaal.classList.add('hidden');
        formPenghasilan.classList.add('hidden');

        // Aktifkan tab yang dipilih
        if (tab === 'maal') {
            tabMaal.classList.add('active-tab');
            formMaal.classList.remove('hidden');
        } else {
            tabPenghasilan.classList.add('active-tab');
            formPenghasilan.classList.remove('hidden');
        }

        // Reset hasil
        document.getElementById('hasilZakatWrapper').classList.add('hidden');
    }

    function resetForm() {
        ['emas', 'tabungan', 'aset', 'hutang', 'penghasilan'].forEach(id => {
            const el = document.getElementById(id);
            if (el) el.value = '';
        });
        document.getElementById('hasilZakatWrapper').classList.add('hidden');
    }

    function hitungZakat() {
        const isMaal = !document.getElementById('formMaal').classList.contains('hidden');
        let zakat = 0;

        if (isMaal) {
            const emas = parseFloat(document.getElementById('emas').value) || 0;
            const tabungan = parseFloat(document.getElementById('tabungan').value) || 0;
            const aset = parseFloat(document.getElementById('aset').value) || 0;
            const hutang = parseFloat(document.getElementById('hutang').value) || 0;
            const total = emas + tabungan + aset - hutang;
            zakat = total > 0 ? total * 0.025 : 0;
        } else {
            const penghasilan = parseFloat(document.getElementById('penghasilan').value) || 0;
            zakat = penghasilan * 0.025;
        }

        document.getElementById('hasilZakat').innerText = formatRupiah(zakat);
        document.getElementById('hasilZakatWrapper').classList.remove('hidden');
    }

    function formatRupiah(angka) {
        return 'Rp ' + angka.toFixed(0).replace(/\B(?=(\d{3})+(?!\d))/g, '.');
    }
</script>
@endsection
