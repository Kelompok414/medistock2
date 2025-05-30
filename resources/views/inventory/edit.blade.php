@extends('layouts.app')

@section('content')
<!-- Main Content -->
<div class="rounded-4 p-4" style="background-color: #FFFFFF; border-radius: 16px;">
    <h1 style="font-size: 24px; font-weight: 500;">Edit Obat</h1>
    <form action="{{ route('inventory.update', $medicine->id) }}" method="POST" style="margin-top: 20px;">
        @csrf
        @method('PUT')
        <!-- Nama Obat -->
        <div class="mb-3">
            <label for="name" class="form-label" style="font-size: 16px;">Nama Obat</label>
            <input type="text" name="name" id="name" class="form-control" value="{{ $medicine->name }}" style="border-radius: 16px;" required>
        </div>

        <!-- Kategori -->
        <div class="mb-3">
            <label for="category_id" class="form-label" style="font-size: 16px;">Kategori</label>
            <select name="category_id" id="category_id" class="form-control" style="border-radius: 16px;" required>
                @foreach($categories as $category)
                    <option value="{{ $category->id }}" {{ $medicine->category_id == $category->id ? 'selected' : '' }}>
                        {{ $category->name }}
                    </option>
                @endforeach
            </select>
        </div>

        <!-- Dosis -->
        <div class="mb-3">
            <label for="dosage" class="form-label" style="font-size: 16px;">Dosis</label>
            <input type="text" name="dosage" id="dosage" class="form-control" value="{{ $medicine->dosage }}" style="border-radius: 16px;" required>
        </div>

        <!-- Deskripsi -->
        <div class="mb-3">
            <label for="description" class="form-label" style="font-size: 16px;">Deskripsi</label>
            <textarea name="description" id="description" class="form-control" style="border-radius: 16px;">{{ $medicine->description }}</textarea>
        </div>

        @php
            $batch = $medicine->batches->sortByDesc('expiry_date')->first();
        @endphp

        <!-- Batch (readonly) -->
        <div class="mb-3">
            <label class="form-label" style="font-size: 16px;">Batch</label>
            <input type="text" class="form-control" value="{{ $batch ? $batch->batch_number : '-' }}" style="border-radius: 16px;" readonly>
        </div>

        <!-- Tanggal Kadaluarsa (readonly) -->
        <div class="mb-3">
            <label class="form-label" style="font-size: 16px;">Tanggal Kadaluarsa</label>
            <input type="text" class="form-control" value="{{ $batch ? $batch->expiry_date : '-' }}" style="border-radius: 16px;" readonly>
        </div>

        <!-- Harga (readonly) -->
        <div class="mb-3">
            <label class="form-label" style="font-size: 16px;">Harga (Rp)</label>
            <input type="text" class="form-control" value="{{ $batch ? number_format($batch->price, 0, ',', '.') : '-' }}" style="border-radius: 16px;" readonly>
        </div>

        <!-- Stok (readonly) -->
        <div class="mb-3">
            <label class="form-label" style="font-size: 16px;">Stok</label>
            <input type="text" class="form-control" value="{{ $medicine->batches->sum('stock') }}" style="border-radius: 16px;" readonly>
        </div>

        <!-- Tombol -->
        <div class="d-flex justify-content-end">
            <a href="{{ route('inventory.index') }}" class="btn btn-secondary me-3" style="border-radius: 16px;">Batal</a>
            <button type="submit" class="btn" style="background-color: #279B48; color: #FFFFFF; border-radius: 16px;">Simpan</button>
        </div>
    </form>
</div>
@endsection