@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 bg-white shadow-md rounded-lg py-6">
    
    {{-- Dropdown untuk memilih range laporan --}}
    <select id="rangeSelect"
        class="w-64 mb-4 px-3 py-2 rounded-md text-sm text-gray-700">
        <option value="mingguan">Laporan Mingguan</option>
        <option value="bulanan">Laporan Bulanan</option>
        <option value="tahunan">Laporan Tahunan</option>
    </select>

    {{-- Grafik Tren Penjualan --}}
    <div class="mb-6 bg-white shadow-md rounded-lg p-4">
        <h2 class="text-lg font-semibold mb-2">Tren Penjualan</h2>
        <div class="h-64">
            <canvas id="trendChart" class="w-full h-full"></canvas>
        </div>
    </div>

    {{-- Grid 2 kolom untuk grafik top & bottom --}}
    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">

        {{-- Top 5 Produk Terlaris --}}
        <div class="bg-white shadow-md rounded-lg p-4">
            <h2 class="text-lg font-semibold mb-2">5 Produk Paling Laris</h2>
            <div class="h-48">
                <canvas id="topChart" class="w-full h-full"></canvas>
            </div>
        </div>

        {{-- Bottom 5 Produk Terjual --}}
        <div class="bg-white shadow-md rounded-lg p-4">
            <h2 class="text-lg font-semibold mb-2">5 Produk Paling Tidak Laku</h2>
            <div class="h-48">
                <canvas id="leastChart" class="w-full h-full"></canvas>
            </div>
        </div>
    </div>
</div>

{{-- Chart.js --}}
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
    const topCtx = document.getElementById('topChart').getContext('2d');
    const leastCtx = document.getElementById('leastChart').getContext('2d');
    const trendCtx = document.getElementById('trendChart').getContext('2d');
    let trendChart;

    // Top Chart
    new Chart(topCtx, {
        type: 'bar',
        data: {
            labels: {!! json_encode($topChartLabels) !!},
            datasets: [{
                label: 'Total Terjual',
                data: {!! json_encode($topChartData) !!},
                backgroundColor: 'rgba(59, 130, 246, 0.7)',
                borderColor: 'rgba(59, 130, 246, 1)',
                borderWidth: 1,
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            scales: {
                y: {
                    beginAtZero: true
                }
            },
            plugins: {
                legend: { display: false }
            }
        }
    });

    // Least Chart
    new Chart(leastCtx, {
        type: 'bar',
        data: {
            labels: {!! json_encode($leastChartLabels) !!},
            datasets: [{
                label: 'Total Terjual',
                data: {!! json_encode($leastChartData) !!},
                backgroundColor: 'rgba(239, 68, 68, 0.7)',
                borderColor: 'rgba(239, 68, 68, 1)',
                borderWidth: 1,
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            scales: {
                y: {
                    beginAtZero: true
                }
            },
            plugins: {
                legend: { display: false }
            }
        }
    });

    // Fungsi ambil data tren penjualan dari endpoint
    function fetchTrendData(range) {
        fetch(`/analytics/trend/${range}`)
            .then(response => response.json())
            .then(data => {
                const labels = data.map(item => item.label);
                const totals = data.map(item => item.total);

                // Hapus chart lama jika ada
                if (trendChart) trendChart.destroy();

                trendChart = new Chart(trendCtx, {
                    type: 'line',
                    data: {
                        labels: labels,
                        datasets: [{
                            label: `Total Penjualan (${range})`,
                            data: totals,
                            fill: true,
                            borderColor: 'rgb(16, 185, 129)',
                            backgroundColor: 'rgba(16, 185, 129, 0.2)',
                            tension: 0.4,
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        scales: {
                            y: {
                                beginAtZero: true
                            }
                        }
                    }
                });
            })
            .catch(error => {
                console.error('Gagal memuat data tren:', error);
            });
    }

    // Inisialisasi saat halaman dimuat
    document.addEventListener('DOMContentLoaded', function () {
        fetchTrendData('mingguan'); // default load
        document.getElementById('rangeSelect').addEventListener('change', function () {
            fetchTrendData(this.value);
        });
    });
</script>
@endsection
