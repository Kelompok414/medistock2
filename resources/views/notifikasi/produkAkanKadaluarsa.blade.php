@extends('layouts.app')

@section('content')

<!-- Container utama dengan background abu-abu muda, tinggi minimum layar penuh, dan padding -->
<div class="d-flex flex-column" style="background-color: #F5F5F5; min-height: 100vh; padding: 20px;">
    
    <!-- Bagian navigasi tab untuk pindah halaman notifikasi -->
    <div class="mb-4" style="min-width: 800px;">
        <table class="table" style="background-color: #FFFFFF; border-collapse: separate; border-spacing: 0; width: 100%; min-width: 800px;">
            <thead>
                <tr style="background-color: #279B48; color: #FFFFFF;">
                    <!-- Tab Semua Notifikasi -->
                    <th style="padding: 12px; text-align: center; border-radius: 16px 0 0 16px; font-weight: 400;">
                        <a href="{{ url('/notifikasi') }}" style="text-decoration: none; color:white;">Semua Notifikasi</a>
                    </th>
                    <!-- Tab Produk Kadaluarsa -->
                    <th style="padding: 12px; text-align: center; font-weight: 400;">
                        <a href="{{ url('/produkkadaluarsa') }}" style="text-decoration: none; color:white;">Produk Kadaluarsa</a>
                    </th>
                    <!-- Tab Produk Akan Kadaluarsa -->
                    <th style="padding: 12px; text-align: center; font-weight: 400; background-color: rgb(159, 198, 170);">
                        <a href="{{ url('/produkakankadaluarsa') }}" style="text-decoration: none; color:black;">Produk Akan Kadaluarsa</a>
                    </th>
                    <!-- Tab Produk Habis (aktif dengan background berbeda) -->
                    <th style="padding: 12px; text-align: center; border-bottom: 4px; border-radius: 0 16px 16px 0; font-weight: 400;"">
                        <a href="{{ url('/produkhabis') }}" style="text-decoration: none; color:white;">Produk Habis</a>
                    </th>
                </tr>
            </thead>
        </table>
    </div>

    <!-- Daftar notifikasi produk akan kadaluarsa -->
    <div class="d-flex flex-column gap-3" style="min-width: 800px;">
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
@endsection
