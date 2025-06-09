@extends('layouts.app')

@section('content')
<div class="rounded-4 p-4" style="background-color: #FFFFFF;">
    <h1 style="font-size: 24px; font-weight: 500;">Tambah Kategori Obat</h1>

    <!-- Breadcrumb -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('categories.index') }}">Kategori</a></li>
                <li class="breadcrumb-item active" aria-current="page">Tambah Kategori</li>
            </ol>
        </nav>
        <a href="{{ route('categories.index') }}" class="btn btn-outline-secondary">
            <i class="fas fa-arrow-left"></i> Kembali ke Kategori
        </a>
    </div>

    <form action="{{ route('categories.store') }}" method="POST" class="mt-4" style="max-width: 500px;">
        @csrf
        <div class="mb-3">
            <label for="name" class="form-label">Nama Kategori</label>
            <input type="text" name="name" id="name" class="form-control" placeholder="Contoh: Antibiotik" required style="border-radius: 12px;">
        </div>

        <button type="submit" class="btn" style="background-color: #279B48; color: white; border-radius: 16px; padding: 10px 20px;">
            Simpan
        </button>
        <a href="{{ route('categories.index') }}" class="btn btn-outline-secondary" style="border-radius: 16px; padding: 10px 20px;">
            Batal
        </a>
    </form>
</div>
@endsection