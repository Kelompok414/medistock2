@extends('layouts.app')

@section('content')
<div class="d-flex" style="background-color: #F5F5F5; min-height: 100vh;">
    <div class="flex-grow-1 p-4">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('transactions.index') }}">Penjualan</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Edit Penjualan</li>
                </ol>
            </nav>
            <a href="{{ route('transactions.index') }}" class="btn btn-outline-secondary">
                <i class="fas fa-arrow-left"></i> Kembali ke Penjualan
            </a>
        </div>

        <div class="card shadow-sm">
            <div class="card-body">
                @if(session('error'))
                <div class="alert alert-danger">
                    {{ session('error') }}
                </div>
                @endif
                <form id="transactionForm" action="{{ route('transactions.update', $transaction->id) }}" method="POST">
                    @csrf
                    @method('PUT')

                    @php
                    $user = Auth::user();
                    @endphp

                    {{-- Pelanggan --}}
                    <div class="mb-3 w-96">
                        <input type="hidden" name="user_id" class="form-control" id="user_id"
                            value="{{ $user->id }}" readonly>
                    </div>

                    {{-- Pelanggan --}}
                    <div class="mb-3 w-96">
                        <label for="customer_name" class="form-label">Pelanggan</label>
                        <input type="text" name="customer_name" class="form-control" id="customer_name"
                            value="{{ $transaction->customer_name }}" readonly>
                    </div>

                    {{-- Tanggal Transaksi --}}
                    <div class="mb-3 w-96">
                        <label for="transaction_date" class="form-label">Tanggal Transaksi</label>
                        <input type="datetime-local" name="transaction_date" id="transaction_date" class="form-control"
                            value="{{ $transaction->transaction_date->format('Y-m-d\TH:i') }}" required>
                    </div>

                    <h5 class="mt-4 mb-3">Daftar Item</h5>

                    <div id="items">
                        @foreach($transaction->saleitems as $index => $item)
                        <div class="card mb-3 item-row p-3 border">
                            <div class="row g-2 align-items-end">
                                <div class="col-md-3">
                                    <label class="form-label">Obat (Batch)</label>
                                    <select name="items[{{ $index }}][batch_id]" class="form-select" required>
                                        @foreach($batches as $batch)
                                        <option value="{{ $batch->id }}" {{ $item->batch_id == $batch->id ? 'selected' : '' }}>
                                            {{ $batch->medicine->name }} - Batch {{ $batch->batch_number }}
                                        </option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="col-md-2">
                                    <label class="form-label">Jumlah</label>
                                    <input type="number" name="items[{{ $index }}][quantity]" class="form-control quantity-input" value="{{ $item->quantity }}" min="1" required>
                                </div>

                                <div class="col-md-3">
                                    <label class="form-label">Harga Satuan</label>
                                    <input type="number" name="items[{{ $index }}][price_per_unit]" class="form-control price-input" value="{{ $item->price_per_unit }}" min="0" step="0.01" required readonly>
                                </div>

                                <div class="col-md-3">
                                    <label class="form-label">Subtotal</label>
                                    <input type="text" class="form-control subtotal-output bg-light" value="0" readonly>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>

                    {{-- Total --}}
                    <div class="mt-4">
                        <label for="total_price" class="form-label">Total Harga</label>
                        <input type="hidden" name="total_price" id="total_price_raw" value="{{ $transaction->total_price }}">
                        <input type="text" class="form-control bg-light" id="total_price" value="{{ number_format($transaction->total_price, 0, ',', '.') }}" readonly>
                    </div>

                    <button type="submit" class="btn btn-primary mt-4">Simpan Perubahan</button>
                </form>
            </div>
        </div>
    </div>
</div>


@push('scripts')
<script>
    console.log("loaded")

    function formatCurrency(amount) {
        return new Intl.NumberFormat('id-ID', {
            style: 'currency',
            currency: 'IDR',
            minimumFractionDigits: 0,
            maximumFractionDigits: 0
        }).format(amount);
    }

    function calculateSubtotal(row) {
        const qtyInput = row.querySelector('.quantity-input');
        const priceInput = row.querySelector('.price-input');
        const subtotalOutput = row.querySelector('.subtotal-output');

        if (qtyInput && priceInput && subtotalOutput) {
            const qty = parseFloat(qtyInput.value) || 0;
            const price = parseFloat(priceInput.value) || 0;
            const subtotal = qty * price;

            subtotalOutput.value = formatCurrency(subtotal);

            // Update total setelah menghitung subtotal
            calculateTotal();
        }
    }

    function calculateTotal() {
        let total = 0;

        document.querySelectorAll('.item-row').forEach(row => {
            const qtyInput = row.querySelector('.quantity-input');
            const priceInput = row.querySelector('.price-input');

            if (qtyInput && priceInput) {
                const qty = parseFloat(qtyInput.value) || 0;
                const price = parseFloat(priceInput.value) || 0;
                total += qty * price;
            }
        });

        const totalPriceInput = document.getElementById('total_price');
        const totalPriceRaw = document.getElementById('total_price_raw');

        if (totalPriceInput && totalPriceRaw) {
            totalPriceInput.value = formatCurrency(total);
            totalPriceRaw.value = total;
        }
    }

    function attachEventListeners() {
        // Hapus event listener lama untuk menghindari duplikasi
        document.querySelectorAll('.quantity-input, .price-input').forEach(input => {
            input.removeEventListener('input', handleInputChange);
            input.addEventListener('input', handleInputChange);
        });
    }

    function handleInputChange(event) {
        const row = event.target.closest('.item-row');
        console.log("input change")
        if (row) {
            calculateSubtotal(row);
            console.log("yes row")
        }
    }

    // Inisialisasi saat DOM dimuat
    document.addEventListener('DOMContentLoaded', function() {
        // Hitung semua subtotal dan total saat halaman dimuat
        document.querySelectorAll('.item-row').forEach(row => {
            calculateSubtotal(row);
        });

        // Attach event listeners
        attachEventListeners();

        // Hitung total awal
        calculateTotal();
    });

    // Fungsi untuk menambah item baru (jika dibutuhkan nanti)
    function addNewItemRow() {
        // Setelah menambah row baru, panggil attachEventListeners() lagi
        attachEventListeners();
    }
</script>
@endpush

@endsection