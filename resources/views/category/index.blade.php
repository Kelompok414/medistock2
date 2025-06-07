@extends('layouts.app')

@section('content')
<div class="rounded-4 p-4" style="background-color: #FFFFFF;">
    <h1 style="font-size: 24px; font-weight: 500;">Daftar Kategori Obat</h1>

    <div class="d-flex justify-content-between align-items-center mb-4 mt-4">
        <!-- Search -->
        <form class="d-flex" method="GET" action="{{ route('categories.index') }}" style="flex: 1; max-width: 600px;">
            <input type="text" name="search" class="form-control" placeholder="Cari kategori" style="border-radius: 16px; margin-right: 16px;">
            <button type="submit" class="flex btn btn-secondary" style="border-radius: 16px; padding: 10px 20px;">
                <i data-feather="search" class="me-2"></i>Cari
            </button>
        </form>

        <a href="{{ route('categories.create') }}" class="flex btn" style="background-color: #279B48; color: white; border-radius: 16px; padding: 10px 20px;">
            <i data-feather="plus" class="me-2"></i>Tambah Kategori
        </a>
    </div>

    <table class="table">
        <thead>
            <tr style="background-color: #279B48; color: white;">
                <th style="padding: 12px; text-align: center; border-radius: 16px 0 0 0;">Nama Kategori</th>
                <th style="padding: 12px; text-align: center; border-radius: 0 16px 0 0;">Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse($categories as $category)
                <tr>
                    <td style="padding: 12px; text-align: center;">{{ $category->name }}</td>
                    <td style="padding: 12px; text-align: center;">
                        <a href="{{ route('categories.edit', $category->id) }}" class="btn btn-icon btn-light-warning" style="border-radius: 8px; padding: 4px 7px;">
                            <i data-feather="edit-3"></i>
                        </a>
                        <form action="{{ route('categories.destroy', $category->id) }}" method="POST" style="display: inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" onclick="return confirm('Hapus kategori ini?')" class="btn btn-icon btn-light-danger" style="border-radius: 8px; padding: 4px 7px;">
                                <i data-feather="trash"></i>
                            </button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="2" class="text-center py-4">Tidak ada kategori ditemukan.</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <div class="d-flex justify-content-center">
        {{ $categories->links() }}
    </div>
</div>
@endsection
