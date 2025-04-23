@extends('layouts.app')

@section('content')
<div class="d-flex">
    <!-- Sidebar -->
    <div class="bg-white p-3" style="width: 220px; min-height: 100vh; border-right: 1px solid #e0e0e0;">
        <h5 class="mb-4">Menu</h5>
        <ul class="nav flex-column">
            <li class="nav-item mb-2">
                <a class="nav-link" href="#"><i class="bi bi-house-door me-2"></i>Dashboard</a>
            </li>
            <li class="nav-item mb-2">
                <a class="nav-link" href="#"><i class="bi bi-box-seam me-2"></i>Inventaris</a>
            </li>
            <li class="nav-item mb-2">
                <a class="nav-link" href="#"><i class="bi bi-bag-plus me-2"></i>Pembelian</a>
            </li>
            <li class="nav-item mb-2">
                <a class="nav-link active fw-bold text-success" href="#"><i class="bi bi-bar-chart me-2"></i>Laporan</a>
            </li>
        </ul>
        <div class="mt-auto pt-5">
            <a href="#" class="btn btn-outline-danger w-100">Log Out</a>
            <div class="mt-4 text-center text-muted">
                <strong>Andre</strong><br><small>Admin</small>
            </div>
        </div>
    </div>

    <!-- Main Content -->
    <div class="flex-grow-1 p-4">
        <div class="d-flex justify-content-between mb-4">
            <div class="card flex-fill me-3">
                <div class="card-body text-center">
                    <h6 class="text-muted">Total Transaksi</h6>
                    <h1>{{ $laporan->total_transaksi ?? '0' }}</h1>
                    <small class="text-success">
                        ↑ {{ $laporan->persentase_bulan ?? '0%' }} dari bulan lalu
                    </small>
                </div>
            </div>
            <div class="card flex-fill me-3">
                <div class="card-body text-center">
                    <h6 class="text-muted">Obat Terlaris</h6>
                    <h4>{{ $laporan->obat_terlaris ?? '-' }}</h4>
                    <small class="text-success">{{ $laporan->total_terjual ?? '0' }} total terjual</small>
                </div>
            </div>
            <div class="card flex-fill">
                <div class="card-body text-center">
                    <h6 class="text-muted">Stok Rendah</h6>
                    <h4 class="text-danger">{{ $laporan->stok_rendah ?? '0' }} Obat</h4>
                    <small class="text-danger">Perlu segera diisi</small>
                </div>
            </div>
        </div>

        <div class="card p-4">
            <h5 class="mb-4">Tren Penjualan Obat</h5>
            <div class="btn-group mb-3" role="group">
                <button type="button" class="btn btn-outline-secondary">Tahun ini</button>
                <button type="button" class="btn btn-success active">Bulan ini</button>
                <button type="button" class="btn btn-outline-secondary">Minggu ini</button>
                <button type="button" class="btn btn-outline-secondary">Hari ini</button>
            </div>

            <!-- Chart placeholder -->
            <canvas id="penjualanChart" height="100"></canvas>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    const ctx = document.getElementById('penjualanChart').getContext('2d');
    const chart = new Chart(ctx, {
        type: 'line',
        data: {
            labels: ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Aug', 'Sep', 'Okt', 'Nov', 'Des'],
            datasets: [{
                label: 'Transaksi',
                data: [20, 15, 25, 30, 40, 45, 50, 70, 90, 120, 0, 0],
                borderColor: 'green',
                borderWidth: 2,
                fill: false,
                tension: 0.3,
                pointBackgroundColor: 'green'
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: { display: false },
                tooltip: { enabled: true }
            },
            scales: {
                y: { beginAtZero: true }
            }
        }
    });
</script>
@endpush
