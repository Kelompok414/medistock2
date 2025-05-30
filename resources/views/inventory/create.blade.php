@extends('layouts.app')

@section('content')
<!-- Main Content -->
<div class="rounded-4 p-4" style="background-color: #FFFFFF; border-radius: 16px;">
    <h1 style="font-size: 24px; font-weight: 500;">Tambah Obat</h1>
    <form action="{{ route('inventory.store') }}" method="POST" style="margin-top: 20px;">
        @csrf
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        <!-- Nama Obat -->
        <div class="mb-3">
            <label for="name" class="form-label" style="font-size: 16px;">Nama Obat</label>
            <input type="text" name="name" id="name" class="form-control" style="border-radius: 16px;" required>
        </div>

        <!-- Batch -->
        <div class="mb-3">
            <label for="batch" class="form-label" style="font-size: 16px;">Batch</label>
            <input type="text" name="batch" id="batch" class="form-control" style="border-radius: 16px;" required>
        </div>

        <!-- Tanggal Kadaluarsa -->
        <div class="mb-3">
            <label for="expiry_date" class="form-label" style="font-size: 16px;">Tanggal Kadaluarsa</label>
            <input type="date" name="expiry_date" id="expiry_date" class="form-control" style="border-radius: 16px;" required>
        </div>

        <!-- Harga -->
        <div class="mb-3">
            <label for="price" class="form-label" style="font-size: 16px;">Harga (Rp)</label>
            <input type="number" name="price" id="price" class="form-control" style="border-radius: 16px;" required>
        </div>

        <!-- Stok -->
        <div class="mb-3">
            <label for="stock" class="form-label" style="font-size: 16px;">Stok</label>
            <input type="number" name="stock" id="stock" class="form-control" style="border-radius: 16px;" required>
        </div>

        <!-- Tombol -->
        <div class="d-flex justify-content-end">
            <a href="{{ route('inventory.index') }}" class="btn btn-secondary me-3" style="border-radius: 16px;">Batal</a>
            <button type="submit" class="btn" style="background-color: #279B48; color: #FFFFFF; border-radius: 16px;">Simpan</button>
        </div>
    </form>
</div>
@endsection