@extends('layouts.admin')

@section('title', 'Dashboard Admin')

@section('content')
<div class="space-y-10">

    <!-- Sambutan -->
    <div class="bg-white p-6 rounded-lg shadow text-center">
        <h1 class="text-3xl font-bold text-gray-800 mb-2">Selamat Datang, Admin!</h1>
        <p class="text-lg text-gray-600">Gunakan dashboard ini untuk mengelola data zakat, muzakki, dan mustahiq.</p>
    </div>

    <!-- Statistik Zakat -->
    <div>
        <h2 class="text-xl font-bold text-green-800 mb-4">Statistik Total Zakat</h2>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <div class="bg-white rounded-xl shadow-md p-6 border-l-4 border-green-500">
                <h3 class="text-lg font-semibold text-green-700">Zakat Fitrah</h3>
                <p class="text-2xl font-bold text-gray-800">Rp {{ number_format($zakatFitrah, 0, ',', '.') }}</p>
            </div>
            <div class="bg-white rounded-xl shadow-md p-6 border-l-4 border-green-500">
                <h3 class="text-lg font-semibold text-green-700">Zakat Mal</h3>
                <p class="text-2xl font-bold text-gray-800">Rp {{ number_format($zakatMal, 0, ',', '.') }}</p>
            </div>
            <div class="bg-white rounded-xl shadow-md p-6 border-l-4 border-green-500">
                <h3 class="text-lg font-semibold text-green-700">Zakat Fidyah</h3>
                <p class="text-2xl font-bold text-gray-800">Rp {{ number_format($zakatFidyah, 0, ',', '.') }}</p>
            </div>
        </div>
    </div>

    <!-- Jumlah Muzakki dan Mustahiq -->
    <div>
        <h2 class="text-xl font-bold text-green-800 mb-4">Data Muzakki & Mustahiq</h2>
        <div class="grid grid-cols-2 gap-6">
            <div class="bg-white rounded-xl shadow-md p-6">
                <h3 class="text-lg font-semibold text-green-700">Jumlah Muzakki</h3>
                <p class="text-2xl font-bold text-gray-800">{{ $jumlahMuzaki }}</p>
            </div>
            <div class="bg-white rounded-xl shadow-md p-6">
                <h3 class="text-lg font-semibold text-green-700">Jumlah Mustahiq</h3>
                <p class="text-2xl font-bold text-gray-800">{{ $jumlahMustahiq }}</p>
            </div>
        </div>
    </div>

    <!-- Grafik Pemasukan Zakat -->
    <div>
        <h2 class="text-xl font-bold text-green-800 mb-4">Grafik Pemasukan Zakat per Bulan</h2>
        <div class="bg-white rounded-xl shadow-md p-6">
            <canvas id="grafikZakat" height="100"></canvas>
        </div>
    </div>

    <!-- Transaksi Terbaru -->
    <div>
        <h2 class="text-xl font-bold text-green-800 mb-4">Transaksi Terbaru</h2>
        <div class="bg-white rounded-xl shadow-md p-6">
            @forelse ($transaksiTerbaru as $transaksi)
                <div class="border-b py-2">
                    <p class="text-sm text-gray-700">
                        <strong>{{ $transaksi->muzakki->nama ?? 'Muzakki' }}</strong> membayar
                        <strong>{{ $transaksi->jenisZakat->nama_jenis ?? 'Zakat' }}</strong>
                        sebesar <strong>Rp{{ number_format($transaksi->nominal, 0, ',', '.') }}</strong>
                        pada {{ \Carbon\Carbon::parse($transaksi->tanggal)->translatedFormat('d F Y H:i') }}
                    </p>
                </div>
            @empty
                <p class="text-gray-500">Tidak ada transaksi baru.</p>
            @endforelse
        </div>
    </div>

</div>

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
                backgroundColor: 'rgba(34,197,94,0.6)',
                borderColor: 'rgba(34,197,94,1)',
                borderWidth: 1
            }]
        },
        options: {
            scales: {
                y: { beginAtZero: true }
            }
        }
    });
</script>
@endsection
