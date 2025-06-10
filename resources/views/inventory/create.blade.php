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
        
        <!-- Kategori -->
        <div class="mb-3">
            <label for="category_id" class="form-label" style="font-size: 16px;">Kategori</label>
            <select name="category_id" id="category_id" class="form-control" style="border-radius: 16px;" required>
                <option value="">-- Pilih Kategori --</option>
                @foreach($categories as $category)
                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                @endforeach
            </select>
        </div>
        
        <!-- Kode Obat -->
        <div class="mb-3">
            <label for="code" class="form-label" style="font-size: 16px;">Kode Obat</label>
            <input type="text" name="code" id="code" class="form-control" style="border-radius: 16px;" required>
        </div>

        <!-- Dosis -->
        <div class="mb-3">
            <label for="dosage" class="form-label" style="font-size: 16px;">Dosis</label>
            <input type="text" name="dosage" id="dosage" class="form-control" style="border-radius: 16px;" required>
        </div>

        <!-- Harga -->
        <div class="mb-3">
            <label for="price" class="form-label" style="font-size: 16px;">Harga (Rp)</label>
            <input type="number" name="price" id="price" class="form-control" style="border-radius: 16px;" min="0" required>
        </div>

        <!-- Tombol -->
        <div class="d-flex justify-content-end">
            <a href="{{ route('inventory.index') }}" class="btn btn-secondary me-3" style="border-radius: 16px;">Batal</a>
            <button type="submit" class="btn" style="background-color: #279B48; color: #FFFFFF; border-radius: 16px;">Simpan</button>
        </div>
    </form>
</div>
@endsection