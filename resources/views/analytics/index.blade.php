@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 bg-white shadow-md rounded-lg py-6 max-w-7xl">

    {{-- Dropdown untuk memilih range laporan --}}
    <select id="rangeSelect"
        style="width: 350px; border: 1px solid #d1d5db; padding: 0.5rem 0.75rem; border-radius: 0.375rem; font-size: 0.875rem; color: #374151; outline: none;"
        class="mb-4">
        <option value="mingguan">Laporan Mingguan</option>
        <option value="bulanan">Laporan Bulanan</option>
        <option value="tahunan">Laporan Tahunan</option>
    </select>

    {{-- Grafik Tren Penjualan --}}
    <div class="mb-6 bg-white shadow-md rounded-lg p-4" style="height: 260px;">
        <h2 class="text-lg font-semibold mb-2">Tren Penjualan</h2>
        <canvas id="trendChart" class="w-full h-full"></canvas>
    </div>

    {{-- Flex container untuk side-by-side Top dan Bottom --}}
    <div class="flex flex-wrap md:flex-nowrap gap-4">

        {{-- Top 5 Produk Terlaris --}}
        <div class="bg-white shadow-md rounded-lg p-4 flex-1 md:w-1/2 w-full max-w-full overflow-hidden border border-gray-200" style="height: 250px;">
            <h2 class="text-lg font-semibold mb-2">5 Produk Paling Laris</h2>
            <canvas id="topChart" class="w-full h-full"></canvas>
        </div>

        {{-- Bottom 5 Produk Paling Tidak Laku --}}
        <div class="bg-white shadow-md rounded-lg p-4 flex-1 md:w-1/2 w-full max-w-full overflow-hidden border border-gray-200" style="height: 250px;">
            <h2 class="text-lg font-semibold mb-2">5 Produk Paling Tidak Laku</h2>
            <canvas id="leastChart" class="w-full h-full"></canvas>
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
                    beginAtZero: true,
                    ticks: { stepSize: 1 }
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
                    beginAtZero: true,
                    ticks: { stepSize: 1 }
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

    document.addEventListener('DOMContentLoaded', function () {
        fetchTrendData('mingguan'); // default load
        document.getElementById('rangeSelect').addEventListener('change', function () {
            fetchTrendData(this.value);
        });
    });
</script>
@endsection
