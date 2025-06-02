@extends('layouts.app')

@section('content')
<!-- Container utama dengan background abu-abu muda, tinggi minimal 100vh (layar penuh), padding 20px -->
<div class="d-flex flex-column" style="background-color: #F5F5F5; min-height: 100vh; padding: 20px;">
    
    <!-- Bagian navigasi tab -->
    <div class="mb-4" style="min-width: 800px;">
        <table class="table" style="background-color: #FFFFFF; border-collapse: separate; border-spacing: 0; width: 100%; min-width: 800px;">
            <thead>
                <tr style="background-color: #279B48; color: #FFFFFF;">
                    <!-- Tab Semua Notifikasi -->
                    <th style="padding: 12px; text-align: center; border-radius: 16px 0 0 16px; font-weight: 400;">
                        <a href="{{ url('/notifikasi') }}" style="text-decoration: none; color:white;">Semua Notifikasi</a>
                    </th>
                    <!-- Tab Produk Kadaluarsa (aktif, diberi background hijau muda dan teks hitam) -->
                    <th style="padding: 12px; text-align: center; font-weight: 400; background-color: rgb(159, 198, 170);">
                        <a href="{{ url('/produkkadaluarsa') }}" style="text-decoration: none; color:black;">Produk Kadaluarsa</a>
                    </th>
                    <!-- Tab Produk Akan Kadaluarsa -->
                    <th style="padding: 12px; text-align: center; font-weight: 400;">
                        <a href="{{ url('/produkakankadaluarsa') }}" style="text-decoration: none; color:white;">Produk Akan Kadaluarsa</a>
                    </th>
                    <!-- Tab Produk Habis -->
                    <th style="padding: 12px; text-align: center; border-bottom: 4px; border-radius: 0 16px 16px 0; font-weight: 400;"">
                        <a href="{{ url('/produkhabis') }}" style="text-decoration: none; color:white;">Produk Habis</a>
                    </th>
                </tr>
            </thead>
        </table>
    </div>

    <!-- Daftar produk yang sudah kadaluarsa -->
    <div class="d-flex flex-column gap-3" style="min-width: 800px;">
        <!-- Looping menampilkan setiap batch obat yang sudah expired -->
        @foreach($expiredBatches as $batch)
            <div class="d-flex align-items-center justify-content-between bg-white p-3 rounded shadow-sm">
                <div class="d-flex align-items-center">
                    <!-- Icon silang merah dalam lingkaran merah muda sebagai tanda expired -->
                    <div class="me-3" style="width: 48px; height: 48px; background-color: #FFECEC; color: red; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 24px;">
                        ✖
                    </div>
                    <div>
                        <!-- Nama obat dan pesan expired -->
                        <div class="fw-bold">{{ $batch->medicine->name }} Telah Kadaluarsa</div>
                        <!-- Jumlah tablet yang perlu dimusnahkan -->
                        <div class="text-muted">{{ $batch->quantity }} tablet perlu dilakukan pemusnahan.</div>
                    </div>
                </div>
            </div>
        @endforeach
@endsection