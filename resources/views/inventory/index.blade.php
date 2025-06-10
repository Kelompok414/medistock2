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
                @php
                    // Helper function for 3-state sort
                    function sortParams($field) {
                        $currentSort = request('sort');
                        $currentDir = request('direction');
                        if ($currentSort !== $field) {
                            return ['sort' => $field, 'direction' => 'asc'];
                        } elseif ($currentDir === 'asc') {
                            return ['sort' => $field, 'direction' => 'desc'];
                        } else {
                            // Remove sort and direction for 3rd click
                            return [];
                        }
                    }
                @endphp
                <th style="padding: 12px; text-align: center; border-radius: 16px 0 0 0; font-weight: 400; font-size: 16px;">
                    <a href="{{ route('inventory.index', array_merge(request()->except(['page', 'sort', 'direction']), sortParams('name'))) }}"
                       style="color: inherit; text-decoration: none; display: flex; align-items: center; justify-content: center; gap: 8px;">
                        Nama Obat
                        @if(request('sort') === 'name')
                            @if(request('direction') === 'asc')
                                <i data-feather="chevron-up" style="width: 20px; height: 20px;"></i>
                            @elseif(request('direction') === 'desc')
                                <i data-feather="chevron-down" style="width: 20px; height: 20px;"></i>
                            @endif
                        @endif
                    </a>
                </th>
                <th style="padding: 12px; text-align: center; font-weight: 400; font-size: 16px;">
                    <a href="{{ route('inventory.index', array_merge(request()->except(['page', 'sort', 'direction']), sortParams('code'))) }}"
                       style="color: inherit; text-decoration: none; display: flex; align-items: center; justify-content: center; gap: 8px;">
                        Kode
                        @if(request('sort') === 'code')
                            @if(request('direction') === 'asc')
                                <i data-feather="chevron-up" style="width: 20px; height: 20px;"></i>
                            @elseif(request('direction') === 'desc')
                                <i data-feather="chevron-down" style="width: 20px; height: 20px;"></i>
                            @endif
                        @endif
                    </a>
                </th>
                <th style="padding: 12px; text-align: center; font-weight: 400; font-size: 16px;">
                    <a href="{{ route('inventory.index', array_merge(request()->except(['page', 'sort', 'direction']), sortParams('category_id'))) }}"
                       style="color: inherit; text-decoration: none; display: flex; align-items: center; justify-content: center; gap: 8px;">
                        Kategori
                        @if(request('sort') === 'category_id')
                            @if(request('direction') === 'asc')
                                <i data-feather="chevron-up" style="width: 20px; height: 20px;"></i>
                            @elseif(request('direction') === 'desc')
                                <i data-feather="chevron-down" style="width: 20px; height: 20px;"></i>
                            @endif
                        @endif
                    </a>
                </th>
                <th style="padding: 12px; text-align: center; font-weight: 400; font-size: 16px;">
                    <a href="{{ route('inventory.index', array_merge(request()->except(['page', 'sort', 'direction']), sortParams('dosage'))) }}"
                       style="color: inherit; text-decoration: none; display: flex; align-items: center; justify-content: center; gap: 8px;">
                        Dosis
                        @if(request('sort') === 'dosage')
                            @if(request('direction') === 'asc')
                                <i data-feather="chevron-up" style="width: 20px; height: 20px;"></i>
                            @elseif(request('direction') === 'desc')
                                <i data-feather="chevron-down" style="width: 20px; height: 20px;"></i>
                            @endif
                        @endif
                    </a>
                </th>
                <th style="padding: 12px; text-align: center; font-weight: 400; font-size: 16px;">
                    <a href="{{ route('inventory.index', array_merge(request()->except(['page', 'sort', 'direction']), sortParams('price'))) }}"
                       style="color: inherit; text-decoration: none; display: flex; align-items: center; justify-content: center; gap: 8px;">
                        Harga (Rp)
                        @if(request('sort') === 'price')
                            @if(request('direction') === 'asc')
                                <i data-feather="chevron-up" style="width: 20px; height: 20px;"></i>
                            @elseif(request('direction') === 'desc')
                                <i data-feather="chevron-down" style="width: 20px; height: 20px;"></i>
                            @endif
                        @endif
                    </a>
                </th>
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
                <td style="padding: 12px; text-align: center; font-size: 15px;">{{ number_format($medicine->price, 0, ',', '.') }}</td>
                <td style="padding: 12px; text-align: center; font-size: 15px;">
                    <a href="{{ route('inventory.edit', $medicine->id) }}"
                       class="btn btn-icon btn-light-warning"
                       style="border-radius: 8px; padding: 4px 7px; font-size: 16px; margin-right: 4px; box-shadow: none;">
                        <i data-feather="edit-3"></i>
                    </a>
                    <button type="button"
                        class="btn btn-icon btn-light-danger"
                        style="border-radius: 8px; padding: 4px 7px; font-size: 16px; box-shadow: none;"
                        onclick="confirmDelete('{{ $medicine->id }}', '{{ $medicine->name }}')">
                        <i data-feather="trash"></i>
                    </button>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
    <!-- Pagination -->
    <div class="d-flex justify-content-center">
        {{ $medicines->links() }}
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content" style="border-radius: 16px;">
            <div class="modal-header" style="background-color: #279B48; border-radius: 16px 16px 0 0;">
                <h5 class="modal-title" id="deleteModalLabel" style="color: #fff; font-weight: 600;">
                    Konfirmasi Hapus
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body text-center" style="border-radius: 0 0 16px 16px;">
                <p style="font-size: 16px;">
                    Apakah Anda yakin ingin menghapus <br>
                    <strong id="medicineName" style="color: #279B48;"></strong>?
                </p>
                <div class="d-flex justify-content-center gap-2 mt-4">
                    <button type="button" class="btn btn-outline-success" data-bs-dismiss="modal" style="border-radius: 16px;">Batal</button>
                    <form id="deleteForm" method="POST" action="" class="d-inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-success" style="border-radius: 16px;">Hapus</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Feather Icons & Pagination Style -->
<script>
    feather.replace();
    function confirmDelete(id, name) {
        document.getElementById('medicineName').textContent = name;
        const deleteForm = document.getElementById('deleteForm');
        deleteForm.action = `/inventory/${id}`;
        const deleteModal = new bootstrap.Modal(document.getElementById('deleteModal'));
        deleteModal.show();
    }
</script>
<style>
    .pagination .page-link {
        border-radius: 12px !important;
        transition: background 0.2s, color 0.2s;
        box-shadow: none !important;
    }
    .pagination .page-link:hover {
        background-color: #f0f1f3 !important; /* abu-abu tipis */
        color: #279B48 !important;
        box-shadow: none !important;
    }
    .pagination .page-item.active .page-link {
        background-color: #279B48 !important;
        color: #fff !important;
        box-shadow: none !important;
    }
</style>
@endsection