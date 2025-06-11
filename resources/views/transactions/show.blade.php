@extends('layouts.app')

@section('content')
<div class="d-flex" style="background-color: #F5F5F5; min-height: 100vh;">
    <div class="flex-grow-1 p-4">
        <div class="container">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('transactions.index') }}">Penjualan</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Detail Penjualan</li>
                    </ol>
                </nav>
                <a href="{{ route('transactions.index') }}" class="btn btn-outline-secondary">
                    <i class="fas fa-arrow-left"></i> Kembali ke Penjualan
                </a>
            </div>

            <div class="card shadow-sm border-0 mb-4">
                <div class="card-body">
                    <div class="row mb-2">
                        <div class="col-sm-3 text-muted">Pelanggan</div>
                        <div class="col-sm-9">{{ $transaction->customer_name ?? 'N/A' }}</div>
                    </div>
                    <div class="row mb-2">
                        <div class="col-sm-3 text-muted">Kasir</div>
                        <div class="col-sm-9">{{ $transaction->user->name ?? 'N/A' }}</div>
                    </div>
                    <div class="row mb-2">
                        <div class="col-sm-3 text-muted">Total Price</div>
                        <div class="col-sm-9">Rp{{ number_format($transaction->total_price, 0, ',', '.') }}</div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-sm-3 text-muted">Transaction Date</div>
                        <div class="col-sm-9">{{ $transaction->transaction_date }}</div>
                    </div>
                </div>
            </div>

            <h4 class="mb-3 fw-semibold">Barang Terjual</h4>

            <div class="card shadow-sm border-0">
                <div class="card-body p-0">
                    <table class="table table-hover table-striped mb-0">
                        <thead class="table-light">
                            <tr class="text-center">
                                <th>Medicine</th>
                                <th>Batch Number</th>
                                <th>Quantity</th>
                                <th>Price per Unit</th>
                                <th>Subtotal</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($transaction->saleitems as $item)
                            <tr class="text-center align-middle">
                                <td>{{ $item->batch->medicine->name ?? 'N/A' }}</td>
                                <td>{{ $item->batch->batch_number ?? 'N/A' }}</td>
                                <td>{{ $item->quantity }}</td>
                                <td>Rp{{ number_format($item->price_per_unit, 0, ',', '.') }}</td>
                                <td>Rp{{ number_format($item->price_per_unit * $item->quantity, 0, ',', '.') }}</td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="5" class="text-center text-muted py-4">
                                    No items found for this transaction.
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </div>
</div>
@endsection