@extends('layouts.app')

@section('content')

<!-- Container utama dengan warna latar abu-abu muda dan padding -->
<div class="d-flex flex-column" style="background-color: #F5F5F5; min-height: 100vh; padding: 20px;">
    
    <!-- Bagian navigasi tab untuk berpindah antara notifikasi -->
    <div class="mb-4" style="min-width: 800px;">
        <table class="table" style="background-color: #FFFFFF; border-collapse: separate; border-spacing: 0; width: 100%; min-width: 800px;">
            <thead>
                <tr style="background-color: #279B48; color: #FFFFFF;">
                    <!-- Tab Semua Notifikasi -->
                    <th style="padding: 12px; text-align: center; border-radius: 16px 0 0 16px; font-weight: 400; background-color: rgb(159, 198, 170);">
                        <a href="{{ url('/notifikasi') }}" style="text-decoration: none; color:black;">Semua Notifikasi</a>
                    </th>
                    <!-- Tab Produk Kadaluarsa -->
                    <th style="padding: 12px; text-align: center; font-weight: 400;">
                        <a href="{{ url('/produkkadaluarsa') }}" style="text-decoration: none; color:white;">Produk Kadaluarsa</a>
                    </th>
                    <!-- Tab Produk Akan Kadaluarsa -->
                    <th style="padding: 12px; text-align: center; font-weight: 400;">
                        <a href="{{ url('/produkakankadaluarsa') }}" style="text-decoration: none; color:white;">Produk Akan Kadaluarsa</a>
                    </th>
                    <!-- Tab Produk Habis -->
                    <th style="padding: 12px; text-align: center; border-bottom: 4px; border-radius: 0 16px 16px 0; font-weight: 400;">
                        <a href="{{ url('/produkhabis') }}" style="text-decoration: none; color:white;">Produk Habis</a>
                    </th>
                </tr>
            </thead>
        </table>
    </div>

    <!-- Bagian daftar notifikasi yang akan ditampilkan -->
    <div class="d-flex flex-column gap-3" style="min-width: 800px;">
        
        <!-- Loop untuk menampilkan notifikasi produk yang sudah kadaluarsa -->
        @foreach($expiredBatches as $batch)
            <div class="d-flex align-items-center justify-content-between bg-white p-3 rounded shadow-sm">
                <div class="d-flex align-items-center">
                    <!-- Icon silang merah untuk menandakan produk kadaluarsa -->
                    <div class="me-3" style="width: 48px; height: 48px; background-color: #FFECEC; color: red; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 24px;">
                        ✖
                    </div>
                    <div>
                        <!-- Nama obat yang kadaluarsa -->
                        <div class="fw-bold">{{ $batch->medicine->name }} Telah Kadaluarsa</div>
                        <!-- Jumlah produk yang perlu dimusnahkan -->
                        <div class="text-muted">{{ $batch->quantity }} tablet perlu dilakukan pemusnahan.</div>
                    </div>
                </div>
            </div>
        @endforeach

        <!-- Loop untuk menampilkan notifikasi produk yang hampir kadaluarsa -->
        @foreach($nearExpiredBatches as $batch)
            <div class="d-flex align-items-center justify-content-between bg-white p-3 rounded shadow-sm">
                <div class="d-flex align-items-center">
                    <!-- Icon tanda peringatan kuning untuk produk hampir kadaluarsa -->
                    <div class="me-3" style="width: 48px; height: 48px; background-color: #FFF8E1; color: #D9A800; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 24px;">
                        ⚠
                    </div>
                    <div>
                        <!-- Nama obat yang akan kadaluarsa -->
                        <div class="fw-bold">{{ $batch->medicine->name }} Akan Kadaluarsa</div>
                        <!-- Waktu tersisa sebelum kadaluarsa dalam hari -->
                        <div class="text-muted">Dalam {{ intval(now()->diffInDays($batch->expiry_date)) }} hari</div>
                    </div>
                </div>
            </div>
        @endforeach

        <!-- Loop untuk menampilkan notifikasi produk yang habis -->
        @foreach($emptyBatches as $batch)
            <div class="d-flex align-items-center justify-content-between bg-white p-3 rounded shadow-sm">
                <div class="d-flex align-items-center">
                    <!-- Icon keranjang belanja abu-abu untuk produk habis -->
                    <div class="me-3" style="width: 48px; height: 48px; background-color: #EDEDED; color: #333; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 24px;">
                        🛒
                    </div>
                    <div>
                        <!-- Nama obat yang stoknya habis -->
                        <div class="fw-bold">{{ $batch->medicine->name }} Telah Habis</div>
                        <!-- Informasi untuk pengadaan ulang -->
                        <div class="text-muted">Perlu pengadaan obat.</div>
                    </div>
                </div>
            </div>
        @endforeach

        <!-- Jika tidak ada notifikasi sama sekali, tampilkan pesan ini -->
        @if($expiredBatches->isEmpty() && $nearExpiredBatches->isEmpty() && $emptyBatches->isEmpty())
            <div class="alert alert-success text-center">Semua produk dalam kondisi baik dan stok aman.</div>
        @endif
    </div>
</div>

@endsection
