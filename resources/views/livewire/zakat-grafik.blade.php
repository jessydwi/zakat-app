<div class="bg-white rounded-xl shadow p-6">
    <h2 class="text-lg font-semibold text-emerald-800 mb-4">Grafik Zakat Masuk Bulanan</h2>
    <canvas id="grafikZakat" height="100"></canvas>
</div>

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function () {
    const ctx = document.getElementById('grafikZakat').getContext('2d');
    new Chart(ctx, {
        type: 'bar',
        data: {
            labels: @json(array_column($dataGrafik, 'bulan')),
            datasets: [{
                label: 'Zakat Masuk',
                data: @json(array_column($dataGrafik, 'total')),
                backgroundColor: 'rgba(16, 185, 129, 0.6)',
                borderColor: 'rgba(16, 185, 129, 1)',
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        callback: function(value) {
                            return 'Rp' + value.toLocaleString('id-ID');
                        }
                    }
                }
            }
        }
    });
});
</script>
@endpush
