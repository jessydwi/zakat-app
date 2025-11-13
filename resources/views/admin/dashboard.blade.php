@extends('layouts.admin')

@section('title', 'Dashboard Admin')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-green-50 to-blue-50 p-6">
    <div class="max-w-7xl mx-auto space-y-8">

        <!-- Sambutan -->
        <div class="bg-white p-8 rounded-2xl shadow-xl text-center transform hover:scale-105 transition-transform duration-300">
            <div class="flex justify-center mb-4">
                <i class="fas fa-user-shield text-6xl text-green-600"></i>
            </div>
            <h1 class="text-4xl font-bold text-gray-800 mb-2">Selamat Datang, Admin!</h1>
            <p class="text-lg text-gray-600">Gunakan dashboard ini untuk mengelola data zakat, muzakki, dan mustahiq dengan efisien.</p>
        </div>

        <!-- Statistik Zakat -->
        <div>
            <h2 class="text-2xl font-bold text-green-800 mb-6 flex items-center">
                <i class="fas fa-chart-line mr-3 text-green-600"></i>
                Statistik Total Zakat
            </h2>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                <div class="bg-white rounded-2xl shadow-lg p-6 border-l-4 border-green-500 hover:shadow-xl transition-shadow duration-300">
                    <div class="flex items-center mb-4">
                        <i class="fas fa-wheat-awn text-3xl text-green-600 mr-3"></i>
                        <h3 class="text-lg font-semibold text-green-700">Zakat Fitrah</h3>
                    </div>
                    <p class="text-3xl font-bold text-gray-800">Rp {{ number_format($zakatFitrah, 0, ',', '.') }}</p>
                </div>
                <div class="bg-white rounded-2xl shadow-lg p-6 border-l-4 border-green-500 hover:shadow-xl transition-shadow duration-300">
                    <div class="flex items-center mb-4">
                        <i class="fas fa-wallet text-3xl text-green-600 mr-3"></i>
                        <h3 class="text-lg font-semibold text-green-700">Zakat Mal</h3>
                    </div>
                    <p class="text-3xl font-bold text-gray-800">Rp {{ number_format($zakatMal, 0, ',', '.') }}</p>
                </div>
                <div class="bg-white rounded-2xl shadow-lg p-6 border-l-4 border-green-500 hover:shadow-xl transition-shadow duration-300">
                    <div class="flex items-center mb-4">
                        <i class="fas fa-user text-3xl text-green-600 mr-3"></i>
                        <h3 class="text-lg font-semibold text-green-700">Zakat Fidyah</h3>
                    </div>
                    <p class="text-3xl font-bold text-gray-800">Rp {{ number_format($zakatFidyah, 0, ',', '.') }}</p>
                </div>
                <div class="bg-white rounded-2xl shadow-lg p-6 border-l-4 border-blue-500 hover:shadow-xl transition-shadow duration-300">
                    <div class="flex items-center mb-4">
                        <i class="fas fa-heart text-3xl text-blue-600 mr-3"></i>
                        <h3 class="text-lg font-semibold text-blue-700">Infak</h3>
                    </div>
                    <p class="text-3xl font-bold text-gray-800">Rp {{ number_format($infak, 0, ',', '.') }}</p>
                </div>
            </div>
        </div>

        <!-- Jumlah Muzakki dan Mustahiq -->
        <div>
            <h2 class="text-2xl font-bold text-green-800 mb-6 flex items-center">
                <i class="fas fa-users mr-3 text-green-600"></i>
                Data Muzakki & Mustahiq
            </h2>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="bg-white rounded-2xl shadow-lg p-6 hover:shadow-xl transition-shadow duration-300">
                    <div class="flex items-center mb-4">
                        <i class="fas fa-user-plus text-3xl text-green-600 mr-3"></i>
                        <h3 class="text-lg font-semibold text-green-700">Jumlah Muzakki</h3>
                    </div>
                    <p class="text-3xl font-bold text-gray-800">{{ $jumlahMuzaki }}</p>
                </div>
                <div class="bg-white rounded-2xl shadow-lg p-6 hover:shadow-xl transition-shadow duration-300">
                    <div class="flex items-center mb-4">
                        <i class="fas fa-hand-holding-heart text-3xl text-green-600 mr-3"></i>
                        <h3 class="text-lg font-semibold text-green-700">Jumlah Mustahiq</h3>
                    </div>
                    <p class="text-3xl font-bold text-gray-800">{{ $jumlahMustahiq }}</p>
                </div>
            </div>
        </div>

        <!-- Grafik Pemasukan Zakat -->
        <div>
            <h2 class="text-2xl font-bold text-green-800 mb-6 flex items-center">
                <i class="fas fa-chart-bar mr-3 text-green-600"></i>
                Grafik Pemasukan Zakat per Bulan
            </h2>
            <div class="bg-white rounded-2xl shadow-lg p-6 hover:shadow-xl transition-shadow duration-300">
                <canvas id="grafikZakat" height="100"></canvas>
            </div>
        </div>

        <!-- Transaksi Terbaru -->
        <div>
            <h2 class="text-2xl font-bold text-green-800 mb-6 flex items-center">
                <i class="fas fa-clock mr-3 text-green-600"></i>
                Transaksi Terbaru
            </h2>
            <div class="bg-white rounded-2xl shadow-lg p-6 hover:shadow-xl transition-shadow duration-300">
                @forelse ($transaksiTerbaru as $transaksi)
                    <div class="border-b py-4 flex items-center">
                        <div class="flex-shrink-0 mr-4">
                            <i class="fas fa-receipt text-2xl text-green-600"></i>
                        </div>
                        <p class="text-sm text-gray-700">
                            <strong>{{ $transaksi->muzakki->nama ?? 'Muzakki' }}</strong> membayar
                            <strong>{{ $transaksi->jenisZakat->nama_jenis ?? 'Zakat' }}</strong>
                            sebesar <strong>Rp{{ number_format($transaksi->nominal, 0, ',', '.') }}</strong>
                            pada {{ \Carbon\Carbon::parse($transaksi->tanggal)->translatedFormat('d F Y H:i') }}
                        </p>
                    </div>
                @empty
                    <div class="text-center py-8">
                        <i class="fas fa-inbox text-4xl text-gray-400 mb-4"></i>
                        <p class="text-gray-500">Tidak ada transaksi baru.</p>
                    </div>
                @endforelse
            </div>
        </div>

    </div>
</div>

<!-- Font Awesome CDN (Tambahkan di layout utama jika belum ada) -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

<!-- Chart.js -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    const ctx = document.getElementById('grafikZakat').getContext('2d');
    const grafikZakat = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: [
                @foreach($grafikZakat as $data)
                    "{{\Carbon\Carbon::createFromDate(null, $data->bulan)->translatedFormat('F') }}",
                @endforeach
            ],
            datasets: [{
                label: 'Pemasukan Zakat',
                data: [
                    @foreach($grafikZakat as $data)
                        {{ $data->total }},
                    @endforeach
                ],
                backgroundColor: 'rgba(34,197,94,0.8)',
                borderColor: 'rgba(34,197,94,1)',
                borderWidth: 2,
                borderRadius: 8,
                hoverBackgroundColor: 'rgba(34,197,94,1)',
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: {
                    display: true,
                    labels: {
                        font: {
                            size: 14,
                            weight: 'bold'
                        }
                    }
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    grid: {
                        color: 'rgba(0,0,0,0.1)'
                    },
                    ticks: {
                        font: {
                            size: 12
                        }
                    }
                },
                x: {
                    grid: {
                        color: 'rgba(0,0,0,0.1)'
                    },
                    ticks: {
                        font: {
                            size: 12
                        }
                    }
                }
            }
        }
    });
</script>
@endsection