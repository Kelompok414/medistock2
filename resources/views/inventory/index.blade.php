@extends('layouts.app')

@section('content')
<!-- Main Content -->
<div class="rounded-4 p-4" style="background-color: #FFFFFF; border-radius: 16px;">
    <h1 style="font-size: 24px; font-weight: 500;">Daftar Obat</h1>
    <div class="d-flex justify-content-between align-items-center mb-4 mt-4">
        <!-- Search Bar -->
        <form class="d-flex" method="GET" action="{{ route('inventory.index') }}" style="flex: 1; max-width: 600px;">
            <input type="text" name="search" class="form-control" placeholder="Temukan obat" style="border-radius: 16px; margin-right: 16px;">
            <button type="submit" class="btn btn-secondary d-flex align-items-center justify-content-center" style="border-radius: 16px; padding: 10px 20px; font-size: 14px; font-weight: 500;">
                <i data-feather="search" class="me-2"></i>Cari
            </button>
        </form>

        <!-- Add Medicine Button -->
        <a href="{{ route('inventory.create') }}" class="btn d-flex align-items-center justify-content-center" style="background-color: #279B48; color: #FFFFFF; border-radius: 16px; padding: 10px 20px; font-size: 14px; font-weight: 500;">
            <i data-feather="plus" class="me-2"></i>Tambah Obat
        </a>
    </div>

    <!-- Table -->
    <table class="table" style="background-color: #FFFFFF; border-collapse: separate; border-spacing: 0; table-layout: auto;">
        <thead>
            <tr style="background-color: #279B48; color: #FFFFFF;">
                <th style="padding: 12px; text-align: center; border-radius: 16px 0 0 0; font-weight: 400; font-size: 16px;">Nama Obat</th>
                <th style="padding: 12px; text-align: center; font-weight: 400; font-size: 16px;">Kode</th>
                <th style="padding: 12px; text-align: center; font-weight: 400; font-size: 16px;">Kategori</th>
                <th style="padding: 12px; text-align: center; font-weight: 400; font-size: 16px;">Dosis</th>
                <th style="padding: 12px; text-align: center; font-weight: 400; font-size: 16px;">Deskripsi</th>
                <th style="padding: 12px; text-align: center; border-radius: 0 16px 0 0; font-weight: 400; font-size: 16px;">Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($medicines as $medicine)
            <tr>
                <td style="padding: 12px; text-align: center; font-size: 15px;">{{ $medicine->name }}</td>
                <td style="padding: 12px; text-align: center; font-size: 15px;">{{ $medicine->code }}</td>
                <td style="padding: 12px; text-align: center; font-size: 15px;">
                    {{ $medicine->category ? $medicine->category->name : '-' }}
                </td>
                <td style="padding: 12px; text-align: center; font-size: 15px;">{{ $medicine->dosage }}</td>
                <td style="padding: 12px; text-align: center; font-size: 15px;">{{ $medicine->description }}</td>
                <td style="padding: 12px; text-align: center; font-size: 15px;">
                    <a href="{{ route('inventory.edit', $medicine->id) }}" class="btn btn-sm btn-warning" style="border-radius: 16px; padding-left: 20px; padding-right: 20px; font-size: 14px;">Edit</a>
                    <!-- Delete Button -->
                    <button class="btn btn-sm btn-danger" style="border-radius: 16px; padding-left: 20px; padding-right: 20px; font-size: 14px;" 
                        onclick="confirmDelete('{{ $medicine->id }}', '{{ $medicine->name }}')">Hapus</button>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
    <!-- Tambahkan ini untuk pagination -->
    <div class="d-flex justify-content-center">
        {{ $medicines->links() }}
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="deleteModalLabel">Konfirmasi Hapus</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                Apakah Anda yakin ingin menghapus <strong id="medicineName"></strong>?
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                <form id="deleteForm" method="POST" action="">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">Hapus</button>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    function confirmDelete(id, name) {
        // Set the medicine name in the modal
        document.getElementById('medicineName').textContent = name;

        // Set the form action to the delete route
        const deleteForm = document.getElementById('deleteForm');
        deleteForm.action = `/inventory/${id}`;

        // Show the modal
        const deleteModal = new bootstrap.Modal(document.getElementById('deleteModal'));
        deleteModal.show();
    }
</script>
@endsection