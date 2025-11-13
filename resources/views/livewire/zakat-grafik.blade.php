<div class="bg-white rounded-2xl shadow-xl p-8 hover:shadow-2xl transition-shadow duration-300">
    <div class="flex items-center gap-3 mb-6">
        <i class="fas fa-chart-line text-emerald-600 text-2xl"></i>
        <h2 class="text-lg font-semibold text-emerald-800">Grafik Zakat Masuk Bulanan</h2>
    </div>
    <div class="relative">
        <canvas id="grafikZakat" height="100"></canvas>
    </div>
</div>

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function () {
    const ctx = document.getElementById('grafikZakat').getContext('2d');

    // Membuat gradient untuk bar
    const gradient = ctx.createLinearGradient(0, 0, 0, 400);
    gradient.addColorStop(0, 'rgba(16, 185, 129, 0.8)');
    gradient.addColorStop(1, 'rgba(16, 185, 129, 0.2)');

    new Chart(ctx, {
        type: 'bar',
        data: {
            labels: @json(array_column($dataGrafik, 'bulan')),
            datasets: [{
                label: 'Zakat Masuk',
                data: @json(array_column($dataGrafik, 'total')),
                backgroundColor: gradient,
                borderColor: 'rgba(16, 185, 129, 1)',
                borderWidth: 2,
                borderRadius: 8,
                borderSkipped: false,
                hoverBackgroundColor: 'rgba(16, 185, 129, 1)',
                hoverBorderColor: 'rgba(5, 150, 105, 1)',
                hoverBorderWidth: 3,
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    display: true,
                    labels: {
                        font: {
                            size: 14,
                            weight: 'bold',
                            family: 'Inter, sans-serif'
                        },
                        color: '#065f46',
                        usePointStyle: true,
                        pointStyle: 'rectRounded'
                    }
                },
                tooltip: {
                    backgroundColor: 'rgba(0, 0, 0, 0.8)',
                    titleColor: '#ffffff',
                    bodyColor: '#ffffff',
                    borderColor: 'rgba(16, 185, 129, 1)',
                    borderWidth: 1,
                    cornerRadius: 8,
                    displayColors: false,
                    callbacks: {
                        label: function(context) {
                            return 'Rp' + context.parsed.y.toLocaleString('id-ID');
                        }
                    }
                }
            },
            animation: {
                duration: 1500,
                easing: 'easeOutQuart'
            },
            scales: {
                y: {
                    beginAtZero: true,
                    grid: {
                        color: 'rgba(0, 0, 0, 0.1)',
                        lineWidth: 1
                    },
                    ticks: {
                        font: {
                            size: 12,
                            weight: '500'
                        },
                        color: '#374151',
                        callback: function(value) {
                            return 'Rp' + value.toLocaleString('id-ID');
                        }
                    }
                },
                x: {
                    grid: {
                        display: false
                    },
                    ticks: {
                        font: {
                            size: 12,
                            weight: '500'
                        },
                        color: '#374151'
                    }
                }
            },
            elements: {
                bar: {
                    borderRadius: 8
                }
            }
        }
    });
});
</script>
@endpush