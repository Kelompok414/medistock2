@extends('layouts.app')

@section('content')
<!-- Header kosong berwarna hijau -->
<div style="background-color: #279B48; height: 50px; width: 100%;"></div>

<div class="d-flex" style="background-color: #F5F5F5; min-height: 100vh;">
    <!-- Sidebar -->
    <div class="sidebar d-flex flex-column justify-content-between" style="width: 250px; background-color: #FFFFFF; padding: 20px;">
        <!-- Menu Atas -->
        <div>
            <h3 class="text-center mb-4">Menu</h3>
            <ul class="nav flex-column">
                <li class="nav-item">
                    <a href="/dashboard" class="nav-link" style="color: #000000;">Dashboard</a>
                </li>
                <li class="nav-item">
                    <a href="/medicines" class="nav-link active" style="background-color: #279B48; color: #FFFFFF; border-radius: 8px; padding: 8px 16px; display: block;">Inventaris</a>
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

    <!-- Main Content -->
    <div class="container-fluid p-4" style="flex: 1;">
        <div class="rounded-4 p-4" style="background-color: #FFFFFF; border-radius: 16px;">
            <h1 style="font-size: 25px; font-weight: normal;">Edit Obat</h1>
            <form action="{{ route('medicines.update', $medicine->id) }}" method="POST" style="margin-top: 20px;">
                @csrf
                @method('PUT')
                <!-- Nama Obat -->
                <div class="mb-3">
                    <label for="name" class="form-label" style="font-size: 16px;">Nama Obat</label>
                    <input type="text" name="name" id="name" class="form-control" value="{{ $medicine->name }}" style="border-radius: 16px;" required>
                </div>

                <!-- Batch -->
                <div class="mb-3">
                    <label for="batch" class="form-label" style="font-size: 16px;">Batch</label>
                    <input type="text" name="batch" id="batch" class="form-control" value="{{ $medicine->batch }}" style="border-radius: 16px;" required>
                </div>

                <!-- Tanggal Kadaluarsa -->
                <div class="mb-3">
                    <label for="expiry_date" class="form-label" style="font-size: 16px;">Tanggal Kadaluarsa</label>
                    <input type="date" name="expiry_date" id="expiry_date" class="form-control" value="{{ $medicine->expiry_date }}" style="border-radius: 16px;" required>
                </div>

                <!-- Harga -->
                <div class="mb-3">
                    <label for="price" class="form-label" style="font-size: 16px;">Harga (Rp)</label>
                    <input type="number" name="price" id="price" class="form-control" value="{{ $medicine->price }}" style="border-radius: 16px;" required>
                </div>

                <!-- Stok -->
                <div class="mb-3">
                    <label for="stock" class="form-label" style="font-size: 16px;">Stok</label>
                    <input type="number" name="stock" id="stock" class="form-control" value="{{ $medicine->stock }}" style="border-radius: 16px;" required>
                </div>

                <!-- Tombol -->
                <div class="d-flex justify-content-end">
                    <a href="{{ route('medicines.index') }}" class="btn btn-secondary me-3" style="border-radius: 16px;">Batal</a>
                    <button type="submit" class="btn" style="background-color: #279B48; color: #FFFFFF; border-radius: 16px;">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection