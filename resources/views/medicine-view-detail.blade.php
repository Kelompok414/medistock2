@extends('layouts.app')

@section('content')
    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    @if (session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="container py-4">
        <div class="card shadow-sm rounded-4 border-0 mb-3">
            <div class="card-body">
                <h4 class="card-title fw-bold mb-4">🩺 Data Obat <span class="text-primary">{{ $medicine->name }}</span>
                </h4>

                <ul class="list-unstyled mb-0">
                    <li class="mb-3">
                        <strong class="d-block text-secondary">Kategori</strong>
                        <span class="fs-6">{{ $medicine->category->name }}</span>
                    </li>

                    <li class="mb-3">
                        <strong class="d-block text-secondary">Dosis</strong>
                        <span class="fs-6">{{ $medicine->dosage ?: '—' }}</span>
                    </li>

                    <li class="mb-3">
                        <strong class="d-block text-secondary">Kode</strong>
                        <span class="fs-6">{{ $medicine->code }}</span>
                    </li>

                    <li class="mb-2">
                        <strong class="d-block text-secondary mb-1">Deskripsi</strong>
                        <p class="text-muted fs-6 mb-0"
                            style="
                            max-height: 4.5em;
                            overflow: hidden;
                            text-overflow: ellipsis;
                            display: -webkit-box;
                            -webkit-line-clamp: 2;
                            -webkit-box-orient: vertical;
                        ">
                            {{ $medicine->description }}
                        </p>
                    </li>
                </ul>
            </div>
        </div>

        <div class="card shadow-sm rounded-4 border-0">
            <div class="card-body">
                <h5 class="card-title fs-3">Update Deskripsi Obat</h5>
                <form action="{{ route('medicine.update.detail', $medicine->id) }}" method="post">
                    @csrf
                    @method('PUT')
                    <div class="mb-3">
                        <textarea class="form-control" name="description"></textarea>
                    </div>
                    <button type="submit" class="btn btn-info text-white w-100">Update</button>
                </form>
            </div>
        </div>
    </div>
@endsection
