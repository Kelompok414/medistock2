@extends('layouts.app')

@section('content')
<div class="rounded-4 p-4" style="background-color: #FFFFFF;">
    <h1 style="font-size: 24px; font-weight: 500;">Edit Kategori Obat</h1>

    <!-- Breadcrumb -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('categories.index') }}">Kategori</a></li>
                <li class="breadcrumb-item active" aria-current="page">Edit Kategori</li>
            </ol>
        </nav>
        <a href="{{ route('categories.index') }}" class="btn btn-outline-secondary">
            <i class="fas fa-arrow-left"></i> Kembali ke Kategori
        </a>
    </div>

    <form action="{{ route('categories.update', $category->id) }}" method="POST" class="mt-4" style="max-width: 500px;">
        @csrf
        @method('PUT')
        <div class="mb-3">
            <label for="name" class="form-label">Nama Kategori</label>
            <input type="text" name="name" id="name" value="{{ old('name', $category->name) }}" class="form-control" required style="border-radius: 12px;">
        </div>

        <button type="submit" class="btn" style="background-color: #279B48; color: white; border-radius: 16px; padding: 10px 20px;">
            Update
        </button>
        <a href="{{ route('categories.index') }}" class="btn btn-outline-secondary" style="border-radius: 16px; padding: 10px 20px;">
            Batal
        </a>
    </form>
</div>
@endsection