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
        <h1 style="font-size: 28px; font-weight: normal;">Daftar Obat</h1>
        <div class="d-flex justify-content-between align-items-center mb-4">
            <!-- Search Bar -->
            <form class="d-flex" method="GET" action="{{ route('medicines.index') }}" style="flex: 1; max-width: 400px;">
                <input type="text" name="search" class="form-control" placeholder="Cari obat..." style="border-radius: 16px; margin-right: 10px;">
                <button type="submit" class="btn btn-secondary" style="border-radius: 16px;">Cari</button>
            </form>

            <!-- Add Medicine Button -->
            <a href="{{ route('medicines.create') }}" class="btn" style="background-color: #279B48; color: #FFFFFF; border-radius: 16px;">Tambah Obat</a>
        </div>

        <!-- Table -->
        <table class="table" style="background-color: #FFFFFF; border-collapse: separate; border-spacing: 0; table-layout: auto;">
            <thead>
                <tr style="background-color: #279B48; color: #FFFFFF;">
                    <th style="padding: 12px; text-align: center; border-radius: 16px 0 0 0; font-weight: 400; font-size: 16px;">Nama Obat</th>
                    <th style="padding: 12px; text-align: center; font-weight: 400; font-size: 16px;">Status</th>
                    <th style="padding: 12px; text-align: center; font-weight: 400; font-size: 16px;">Batch</th>
                    <th style="padding: 12px; text-align: center; font-weight: 400; font-size: 16px;">Tanggal Kadaluarsa</th>
                    <th style="padding: 12px; text-align: center; font-weight: 400; font-size: 16px;">Harga (Rp)</th>
                    <th style="padding: 12px; text-align: center; font-weight: 400; font-size: 16px;">Stok</th>
                    <th style="padding: 12px; text-align: center; border-radius: 0 16px 0 0; font-weight: 400; font-size: 16px;">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($medicines as $medicine)
                <tr>
                    <td style="padding: 12px; text-align: center; font-size: 15px;">{{ $medicine->name }}</td>
                    <td style="padding: 12px; text-align: center; font-weight: normal; font-size: 15px;">
                        @if ($medicine->stock == 0)
                            <span class="badge bg-danger" style="font-weight: normal; font-size: 14px;">Kosong</span>
                        @elseif ($medicine->stock < 90)
                            <span class="badge bg-warning" style="font-weight: normal; font-size: 14px;">Stok Rendah</span>
                        @else
                            <span class="badge bg-success" style="font-weight: normal; font-size: 14px;">Tersedia</span>
                        @endif
                    </td>
                    <td style="padding: 12px; text-align: center; font-size: 15px;">{{ $medicine->batch }}</td>
                    <td style="padding: 12px; text-align: center; font-size: 15px;">{{ $medicine->expiry_date }}</td>
                    <td style="padding: 12px; text-align: center; font-size: 15px;">{{ number_format($medicine->price, 0, ',', '.') }}</td>
                    <td style="padding: 12px; text-align: center; font-size: 15px;">{{ $medicine->stock }}</td>
                    <td style="padding: 12px; text-align: center; font-size: 15px;">
                        <a href="{{ route('medicines.edit', $medicine->id) }}" class="btn btn-sm btn-warning" style="border-radius: 16px; padding-left: 20px; padding-right: 20px; font-size: 14px;">Edit</a>
                        <!-- Delete Button -->
                        <button class="btn btn-sm btn-danger" style="border-radius: 16px; padding-left: 20px; padding-right: 20px; font-size: 14px;" 
                            onclick="confirmDelete({{ $medicine->id }}, '{{ $medicine->name }}')">Hapus</button>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
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
        deleteForm.action = `/medicines/${id}`;

        // Show the modal
        const deleteModal = new bootstrap.Modal(document.getElementById('deleteModal'));
        deleteModal.show();
    }
</script>
@endsection