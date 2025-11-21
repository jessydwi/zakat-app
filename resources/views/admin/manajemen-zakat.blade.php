@extends('layouts.admin')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-emerald-50 via-white to-blue-50 p-6">
    <div class="max-w-7xl mx-auto space-y-8">

        {{-- Statistik Ringkas --}}
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
            <x-stat-card 
                title="Total Zakat Masuk" 
                :value="number_format($totalZakatMasuk, 0, ',', '.') . ' (' . $transaksiMasuk->count() . ' transaksi)'" 
                icon="fas fa-money-bill-wave" 
                color="emerald" 
                subtitle="Zakat yang sudah diterima dan dikonfirmasi"
            />
            <x-stat-card 
                title="Belum Terkonfirmasi" 
                :value="number_format($nominalBelumTerkonfirmasi, 0, ',', '.') . ' (' . $belumTerkonfirmasi . ' transaksi)'" 
                icon="fas fa-hourglass-half" 
                color="amber" 
                subtitle="Menunggu verifikasi admin"
            />
            <x-stat-card 
                title="Distribusi ke Mustahik" 
                :value="number_format($totalDistribusi, 0, ',', '.') . ' (' . $jumlahDistribusi . ' distribusi)'" 
                icon="fas fa-hand-holding-usd" 
                color="blue" 
                subtitle="Zakat yang telah disalurkan"
            />
            <x-stat-card 
                title="Sisa Zakat" 
                :value="number_format(max($totalZakatMasuk - $totalDistribusi, 0), 2, ',', '.')"
                icon="fas fa-wallet" 
                color="purple" 
                subtitle="Dana zakat yang masih tersedia"
            />
        </div>

        {{-- Grafik Zakat Masuk --}}
        <div class="bg-white rounded-2xl shadow-xl p-8 hover:shadow-2xl transition-all duration-300 border border-gray-100">
            <div class="flex items-center gap-3 mb-6">
                <i class="fas fa-chart-line text-emerald-600 text-2xl"></i>
                <h2 class="text-2xl font-bold text-emerald-800">Grafik Zakat Masuk Bulanan</h2>
            </div>
            <div class="bg-gray-50 rounded-xl p-4">
                @livewire('zakat-grafik')
            </div>
        </div>

        {{-- Daftar Pembayaran Zakat --}}
        <div class="bg-white rounded-2xl shadow-xl p-8 hover:shadow-2xl transition-all duration-300 border border-gray-100">
            <div class="flex items-center justify-between mb-6">
                <div class="flex items-center gap-3">
                    <i class="fas fa-list-ul text-emerald-600 text-2xl"></i>
                    <h2 class="text-2xl font-bold text-emerald-800">Daftar Pembayaran Zakat</h2>
                </div>
                <a href="{{ route('admin.transaksi.create') }}" class="bg-gradient-to-r from-emerald-500 to-teal-600 text-white px-6 py-3 rounded-lg hover:from-emerald-600 hover:to-teal-700 transition-all duration-300 transform hover:scale-105 shadow-lg hover:shadow-xl">
                    <i class="fas fa-plus mr-2"></i> Tambah Pembayaran
                </a>
            </div>
            <div class="bg-gray-50 rounded-xl p-4">
                @livewire('zakat-table')
            </div>
        </div>

        {{-- Konfirmasi Pembayaran --}}
        <div class="bg-white rounded-2xl shadow-xl p-8 hover:shadow-2xl transition-all duration-300 border border-gray-100">
            <div class="flex items-center gap-3 mb-2">
                <i class="fas fa-check-circle text-yellow-500 text-2xl"></i>
                <h2 class="text-2xl font-bold text-yellow-700">Detail Transaksi Menunggu Konfirmasi</h2>
            </div>
            <p class="text-sm text-gray-500 mb-4">
                Berikut adalah daftar {{ $belumTerkonfirmasi }} transaksi yang belum dikonfirmasi oleh admin.
            </p>
            <div class="bg-gray-50 rounded-xl p-4">
                @livewire('zakat-konfirmasi')
            </div>
        </div>

        {{-- Distribusi Zakat --}}
        <div class="bg-white rounded-2xl shadow-xl p-8 hover:shadow-2xl transition-all duration-300 border border-gray-100">
            <div class="flex items-center justify-between mb-2">
                <div class="flex items-center gap-3">
                    <i class="fas fa-share text-blue-600 text-2xl"></i>
                    <h2 class="text-2xl font-bold text-blue-800">Distribusi Zakat ke Mustahik</h2>
                </div>
                <a href="{{ route('admin.distribusi.create') }}" class="bg-gradient-to-r from-blue-500 to-indigo-600 text-white px-6 py-3 rounded-lg hover:from-blue-600 hover:to-indigo-700 transition-all duration-300 transform hover:scale-105 shadow-lg hover:shadow-xl">
                    <i class="fas fa-plus mr-2"></i> Tambah Distribusi
                </a>
            </div>
            <p class="text-sm text-gray-500 mb-4">
                Total distribusi: {{ $jumlahDistribusi }} mustahik menerima bantuan sebesar Rp{{ number_format($totalDistribusi, 0, ',', '.') }}.
            </p>
            <div class="bg-gray-50 rounded-xl p-4">
                @livewire('distribusi-zakat-table')
            </div>
        </div>

        {{-- Cetak Bukti & Laporan --}}
        <div class="bg-white rounded-2xl shadow-xl p-8 hover:shadow-2xl transition-all duration-300 border border-gray-100">
            <div class="flex items-center gap-3 mb-6">
                <i class="fas fa-print text-gray-600 text-2xl"></i>
                <h2 class="text-2xl font-bold text-gray-800">Cetak Bukti & Laporan</h2>
            </div>
            <div class="bg-gray-50 rounded-xl p-4">
                @livewire('zakat-laporan')
            </div>
        </div>

        {{-- Modal Detail Mustahik --}}
        <div id="mustahikDetailModal" class="fixed inset-0 bg-black bg-opacity-50 hidden items-center justify-center z-50 transition-opacity duration-300">
            <div class="bg-white p-8 rounded-2xl shadow-2xl max-w-lg w-full mx-4 transform scale-95 transition-transform duration-300">
                <div class="flex items-center gap-3 mb-6">
                    <i class="fas fa-user text-blue-600 text-2xl"></i>
                    <h3 class="text-xl font-bold text-blue-800">Detail Mustahik</h3>
                </div>
                <div id="mustahikDetailContent" class="space-y-3">
                    <p><strong>Nama:</strong> <span class="text-gray-700">Pak Ahmad</span></p>
                    <p><strong>Kategori:</strong> <span class="text-gray-700">Fakir</span></p>
                    <p><strong>Alamat:</strong> <span class="text-gray-700">Jl. Contoh No. 123</span></p>
                    <p><strong>Jumlah bantuan terakhir:</strong> <span class="text-gray-700">Rp500.000</span></p>
                </div>
                <div class="mt-6 flex justify-end">
                    <button onclick="closeMustahikDetail()" class="bg-gray-600 text-white px-6 py-2 rounded-lg hover:bg-gray-700 transition-all duration-300 transform hover:scale-105">
                        <i class="fas fa-times mr-2"></i> Tutup
                    </button>
                </div>
            </div>
        </div>

    </div>
</div>

<!-- Font Awesome CDN -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

<script>
    // Function to open modal (assuming it's called from Livewire or elsewhere)
    function openMustahikDetail() {
        document.getElementById('mustahikDetailModal').classList.remove('hidden');
        document.getElementById('mustahikDetailModal').classList.add('flex');
        setTimeout(() => {
            document.querySelector('#mustahikDetailModal > div').classList.remove('scale-95');
            document.querySelector('#mustahikDetailModal > div').classList.add('scale-100');
        }, 10);
    }

    // Function to close modal
    function closeMustahikDetail() {
        document.querySelector('#mustahikDetailModal > div').classList.remove('scale-100');
        document.querySelector('#mustahikDetailModal > div').classList.add('scale-95');
        setTimeout(() => {
            document.getElementById('mustahikDetailModal').classList.remove('flex');
            document.getElementById('mustahikDetailModal').classList.add('hidden');
        }, 300);
    }
</script>
@endsection