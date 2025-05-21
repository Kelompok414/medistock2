@extends('layouts.app')

@section('content')
<div class="container-fluid p-3">
    <!-- Breadcrumb -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                <li class="breadcrumb-item active" aria-current="page">Obat Yang Akan Kadaluarsa</li>
            </ol>
        </nav>
        <a href="{{ route('dashboard') }}" class="btn btn-outline-secondary">
            <i class="fas fa-arrow-left"></i> Kembali ke Dashboard
        </a>
    </div>

    <!-- Info Card -->
    <div class="card mb-4">
        <div class="card-body p-3">
            <div class="d-flex align-items-center">
                <div class="d-flex align-items-center justify-content-center me-3" style="width: 48px; height: 48px; border-radius: 50%; background-color: rgba(255, 189, 7, 0.1);">
                    <img src="{{ asset('assets/images/alert-circle.png') }}" alt="Alert" width="28" height="28">
                </div>
                <div>
                    <h3 class="text-akan-kadaluarsa mb-0" style="font-size: 24px; font-weight: 500;">{{ $totalAkanKadaluarsa }} Obat Akan Kadaluarsa</h3>
                    <p class="mb-0">Dalam 3 bulan ke depan dan perlu perhatian khusus</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Expiring Medications Table -->
    <div class="card">
        <div class="card-body p-3">
            <h3 class="section-title mb-3">Daftar Obat Yang Akan Kadaluarsa</h3>
            
            <!-- Table -->
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr class="table-header">
                            <th width="20%">Nama Obat</th>
                            <th width="15%" class="text-center">Batch</th>
                            <th width="20%" class="text-center">Tanggal Kadaluarsa</th>
                            <th width="15%" class="text-center">Sisa Hari</th>
                            <th width="10%" class="text-center">Stok</th>
                            <th width="20%" class="text-center">Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($expiringMedications as $item)
                        <x-expired-reminder-row
                            :nama="$item['nama']"
                            :batch="$item['batch']"
                            :tanggalKadaluarsa="$item['tanggal_kadaluarsa']"
                            :sisaHari="$item['sisa_hari']"
                            :stok="$item['stok']"
                            :status="$item['status']" />
                        @empty
                        <tr>
                            <td colspan="6" class="text-center">Tidak ada obat yang akan kadaluarsa dalam 3 bulan ke depan</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            
            <!-- Pagination Links -->
            <div class="d-flex justify-content-center mt-3">
                <div class="pagination-container">
                    @if ($expiringMedicationsPaginator->hasPages())
                        <div class="pagination-info mb-2">
                            Showing {{ $expiringMedicationsPaginator->firstItem() }} to {{ $expiringMedicationsPaginator->lastItem() }} 
                            of {{ $expiringMedicationsPaginator->total() }} results
                        </div>
                        <ul class="pagination">
                            {{-- Previous Page Link --}}
                            @if ($expiringMedicationsPaginator->onFirstPage())
                                <li class="page-item disabled">
                                    <span class="page-link">&laquo; Previous</span>
                                </li>
                            @else
                                <li class="page-item">
                                    <a class="page-link" href="{{ $expiringMedicationsPaginator->previousPageUrl() }}" rel="prev">&laquo; Previous</a>
                                </li>
                            @endif

                            {{-- Pagination Elements --}}
                            @foreach ($expiringMedicationsPaginator->getUrlRange(1, $expiringMedicationsPaginator->lastPage()) as $page => $url)
                                @if ($page == $expiringMedicationsPaginator->currentPage())
                                    <li class="page-item active">
                                        <span class="page-link">{{ $page }}</span>
                                    </li>
                                @else
                                    <li class="page-item">
                                        <a class="page-link" href="{{ $url }}">{{ $page }}</a>
                                    </li>
                                @endif
                            @endforeach

                            {{-- Next Page Link --}}
                            @if ($expiringMedicationsPaginator->hasMorePages())
                                <li class="page-item">
                                    <a class="page-link" href="{{ $expiringMedicationsPaginator->nextPageUrl() }}" rel="next">Next &raquo;</a>
                                </li>
                            @else
                                <li class="page-item disabled">
                                    <span class="page-link">Next &raquo;</span>
                                </li>
                            @endif
                        </ul>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection