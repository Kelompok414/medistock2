@extends('layouts.app')

@section('content')
<!-- Header kosong berwarna hijau -->
<div style="background-color: #279B48; height: 50px; width: 100%;"></div>

<div class="d-flex" style="background-color: #F5F5F5; min-height: 100vh;">
    <!-- Sidebar -->
    <div class="sidebar d-flex flex-column justify-content-between" style="width: 250px; background-color: #FFFFFF; padding: 20px; border-radius: 0 16px 16px 0;">
        <!-- Menu Atas -->
        <div>
            <h3 class="text-center mb-4">Menu</h3>
            <ul class="nav flex-column">
                <li class="nav-item">
                    <a href="/dashboard" class="nav-link active" style="background-color: #279B48; color: #FFFFFF; border-radius: 8px; padding: 8px 16px; display: block;">Dashboard</a>
                </li>
                <li class="nav-item">
                    <a href="/medicines" class="nav-link" style="color: #000000;">Inventaris</a>
                </li>
                <li class="nav-item">
                    <a href="/reports" class="nav-link" style="color: #000000;">Laporan</a>
                </li>
            </ul>
        </div>

        <!-- Menu Bawah -->
        <div>
            <ul class="nav flex-column">
                <li class="nav-item">
                    <a href="/profile" class="nav-link" style="color: #000000; padding: 8px 16px;">Profile</a>
                </li>
                <li class="nav-item">
                    <form method="POST" action="{{ route('logout') }}" style="margin: 0;">
                        @csrf
                        <button type="submit" class="btn btn-link nav-link" style="color: #000000; text-align: left; padding: 8px 16px;">Logout</button>
                    </form>
                </li>
            </ul>
        </div>
    </div>

    <!-- Konten Utama -->
    <div class="flex-grow-1 p-4">
        <div style="border-radius: 16px; background-color: #FFFFFF; padding: 20px; box-shadow: 0 4px 12px rgba(0,0,0,0.05);">
            <div style="overflow-x: auto;">
            
                <table class="table" style="background-color: #FFFFFF; border-collapse: separate; border-spacing: 0; width: 100%; min-width: 800px;">
                <thead>
                    <tr style="background-color: #279B48; color: #FFFFFF;">
                    <th style="padding: 12px; text-align: center; border-bottom: 4px; border-radius: 16px 0 0 16px; font-weight: 400; background-color:rgb(159, 198, 170)"><a href="{{ url('/notifikasi') }}" style="text-decoration: none; color:black">Semua Notifikasi</a></th>
                        <th style="padding: 12px; text-align: center; border-bottom: 4px; font-weight: 400;"><a href="{{ url('/produkkadaluarsa') }}" style="text-decoration: none; color:white">Produk Kadaluarsa</a></th>
                        <th style="padding: 12px; text-align: center; border-bottom: 4px; font-weight: 400;"><a href="{{ url('/produkhabis') }}" style="text-decoration: none; color:white">Produk Habis</a></th>
                        <th style="padding: 12px; text-align: center; border-bottom: 4px; border-radius: 0 16px 16px 0; font-weight: 400;"><a href="#" style="text-decoration: none; color:white">Laporan Bulanan</a></th>
                    </tr>
                </thead>
                </table>

                <!-- Notifikasi List -->
                <div class="d-flex flex-column gap-3">
                    @foreach($expiredBatches as $batch)
                    <div class="d-flex align-items-center justify-content-between bg-white p-3 rounded shadow-sm">
                        <div class="d-flex align-items-center">
                            <div class="me-3" style="width: 48px; height: 48px; background-color: #FFECEC; color: red; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 24px;">
                                ✖
                            </div>
                            <div>
                                <div class="fw-bold">{{ $batch->medicine->name }} Telah Kadaluarsa</div>
                                <div class="text-muted">{{ $batch->quantity }} tablet perlu dilakukan pemusnahan.</div>
                            </div>
                        </div>
                        <!-- <div class="px-3 py-1 rounded text-white" style="background-color: #888;">
                            {{ \Carbon\Carbon::parse($batch->expiry_date)->format('d M Y') }}
                        </div> -->
                    </div>
                    @endforeach

                    @foreach($nearExpiredBatches as $batch)
                    <div class="d-flex align-items-center justify-content-between bg-white p-3 rounded shadow-sm">
                        <div class="d-flex align-items-center">
                            <div class="me-3" style="width: 48px; height: 48px; background-color: #FFF8E1; color: #D9A800; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 24px;">
                                ⚠
                            </div>
                            <div>
                                <div class="fw-bold">{{ $batch->medicine->name }} Akan Kadaluarsa</div>
                                <div class="text-muted">Dalam {{ intval(now()->diffInDays($batch->expiry_date)) }} hari</div>
                            </div>
                        </div>
                        <!-- <div class="px-3 py-1 rounded text-white" style="background-color: #888;">
                            {{ \Carbon\Carbon::parse($batch->expiry_date)->format('d M Y') }}
                        </div> -->
                    </div>
                    @endforeach

                    @foreach($emptyBatches as $batch)
                    <div class="d-flex align-items-center justify-content-between bg-white p-3 rounded shadow-sm">
                        <div class="d-flex align-items-center">
                            <div class="me-3" style="width: 48px; height: 48px; background-color: #EDEDED; color: #333; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 24px;">
                                🛒
                            </div>
                            <div>
                                <div class="fw-bold">{{ $batch->medicine->name }} Telah Habis</div>
                                <div class="text-muted">Perlu pengadaan obat.</div>
                            </div>
                        </div>
                        <!-- <div class="px-3 py-1 rounded text-white" style="background-color: #198754;">
                            Stok: {{ $batch->quantity }}
                        </div> -->
                    </div>
                    @endforeach

                <!-- <table>
                    <tbody>
                        <tr>
                            <th style="padding: 12px; text-align: center;">
                            @foreach($expiredBatches as $batch)
                                <div class="alert alert-danger" role="alert" style="border-left: 6px solid red;">
                                    <strong>{{ $batch->medicine->name }}</strong> telah <strong>kadaluarsa</strong> (expired pada {{ $batch->expiry_date->format('d-m-Y') }}).<br>
                                    <strong>{{ $batch->quantity }}</strong> obat perlu dilakukan <strong>pemusnahan</strong>.
                                </div> 
                            @endforeach

                            @foreach($nearExpiredBatches as $batch)
                                <div class="alert alert-warning" style="border-left: 6px solid orange; color:black">
                                    <strong>{{ $batch->medicine->name }}</strong> akan <strong>kadaluarsa</strong> dalam waktu dekat (expired pada {{ $batch->expiry_date->format('d-m-Y') }}).<br>
                                </div>
                            @endforeach
                            </th>
                        </tr>
                    </tbody>
                </table> -->
            
            </div>
        </div>
    </div>
</div>
@endsection
