@extends('layouts.app')

@section('content')
<div class="d-flex" style="background-color: #F5F5F5; min-height: 100vh;">
    <div class="flex-grow-1 p-4">
        <div class="container">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('transactions.index') }}">Penjualan</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Tambah Penjualan</li>
                    </ol>
                </nav>
                <a href="{{ route('transactions.index') }}" class="btn btn-outline-secondary">
                    <i class="fas fa-arrow-left"></i> Kembali ke Penjualan
                </a>
            </div>

            <div class="card">
                <div class="card-body">
                    @if(session('error'))
                    <div class="alert alert-danger">
                        {{ session('error') }}
                    </div>
                    @endif

                    <form method="POST" action="{{ route('transactions.store') }}" id="transactionForm">
                        @csrf
                        <div class="mb-3">
                            <label class="form-label">Nama Pelanggan</label>
                            <input type="text" name="customer_name" class="form-control"
                                placeholder="Isi nama pelanggan" required>
                        </div>

                        <div class="mb-4">
                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <h5>Item Penjualan</h5>
                                <button type="button" class="btn btn-primary btn-sm" onclick="addItem()">
                                    <i class="fas fa-plus"></i> Tambah Item
                                </button>
                            </div>

                            <div id="itemsContainer">
                                <div class="item-row border rounded p-3 mb-3">
                                    <div class="row">
                                        <div class="col-md-4">
                                            <label class="form-label">Batch Obat</label>
                                            <select name="items[0][batch_id]" class="form-select batch-select" required onchange="updatePrice(this, 0)">
                                                <option value="">Pilih Batch</option>
                                                @foreach ($batches as $batch)
                                                <option value="{{ $batch->id }}"
                                                    data-medicine="{{ $batch->medicine->name }}"
                                                    data-batch="{{ $batch->batch_number }}"
                                                    data-stock="{{ $batch->quantity }}"
                                                    data-expiry="{{ $batch->expiry_date }}"
                                                    data-price="{{ intval($batch->medicine->price ?? 0) }}">
                                                    {{ $batch->medicine->name }} -
                                                    (Stock: {{ $batch->quantity }},
                                                    Exp: {{ date('d/m/Y', strtotime($batch->expiry_date)) }})
                                                </option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="col-md-1">
                                            <label class="form-label">Tersedia</label>
                                            <input type="text" class="form-control stock-display" readonly>
                                        </div>
                                        <div class="col-md-1">
                                            <label class="form-label">Kuantitas</label>
                                            <input type="number" name="items[0][quantity]" class="form-control quantity-input"
                                                min="1" required onchange="calculateItemTotal(0)">
                                        </div>
                                        <div class="col-md-2">
                                            <label class="form-label">Harga</label>
                                            <input type="number" name="items[0][price_per_unit]" class="form-control price-input"
                                                min="0" required onchange="calculateItemTotal(0)" readonly>
                                        </div>
                                        <div class="col-md-2">
                                            <label class="form-label">Subtotal</label>
                                            <input type="hidden" class="form-control item-total" readonly>
                                            <input type="text" class="form-control item-total-input" readonly>
                                        </div>
                                        <div class="col-md-1 d-flex align-items-end">
                                            <button type="button" class="btn btn-danger btn-sm" onclick="removeItem(this)" style="display: none;">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-8"></div>
                            <div class="col-md-4">
                                <div class="card bg-light">
                                    <div class="card-body">
                                        <div class="d-flex justify-content-between">
                                            <strong>Total Price:</strong>
                                            <strong id="totalPrice">Rp 0</strong>
                                        </div>
                                        <input type="hidden" name="total_price" id="totalPriceInput" value="0">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="mt-4">
                            <button type="submit" class="btn btn-success">Submit</button>
                            <a href="{{ route('transactions.index') }}" class="btn btn-secondary">Kembali</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    // Tambahkan event listener untuk validasi max
    document.addEventListener('input', function(e) {
        if (e.target.classList.contains('quantity-input')) {
            const input = e.target;
            const max = parseInt(input.getAttribute('max'));
            const value = parseInt(input.value);

            if (max && value > max) {
                input.value = max; // Paksa set ke max value
            }
        }
    });

    document.addEventListener('DOMContentLoaded', function() {
        let itemCount = 1;

        // Make functions global by attaching to window
        window.addItem = function() {
            const container = document.getElementById('itemsContainer');
            const newItem = document.querySelector('.item-row').cloneNode(true);

            // Update name attributes with new index
            const inputs = newItem.querySelectorAll('input, select');
            inputs.forEach(input => {
                if (input.name) {
                    input.name = input.name.replace(/\[\d+\]/, `[${itemCount}]`);
                }
                if (input.type !== 'button') {
                    input.value = '';
                }
                // Reset max attribute untuk quantity input baru
                if (input.classList.contains('quantity-input')) {
                    input.removeAttribute('max');
                }
            });

            // Update onchange handlers
            const batchSelect = newItem.querySelector('.batch-select');
            batchSelect.setAttribute('onchange', `updatePrice(this, ${itemCount})`);

            const quantityInput = newItem.querySelector('.quantity-input');
            quantityInput.setAttribute('onchange', `calculateItemTotal(${itemCount})`);

            const priceInput = newItem.querySelector('.price-input');
            priceInput.setAttribute('onchange', `calculateItemTotal(${itemCount})`);

            // Show remove button for new items
            const removeBtn = newItem.querySelector('.btn-danger');
            removeBtn.style.display = 'block';

            container.appendChild(newItem);
            itemCount++;

            // Show remove button for first item if there are multiple items
            updateRemoveButtons();
        };

        window.removeItem = function(button) {
            const itemRow = button.closest('.item-row');
            itemRow.remove();
            updateRemoveButtons();
            calculateTotal();
        };

        window.updateRemoveButtons = function() {
            const items = document.querySelectorAll('.item-row');
            const removeButtons = document.querySelectorAll('.item-row .btn-danger');

            removeButtons.forEach((btn, index) => {
                btn.style.display = items.length > 1 ? 'block' : 'none';
            });
        };
        
        window.updatePrice = function(selectElement, index) {
            const selectedOption = selectElement.options[selectElement.selectedIndex];
            const priceInput = document.querySelector(`input[name="items[${index}][price_per_unit]"]`);
            const stockDisplay = selectElement.closest('.item-row').querySelector('.stock-display');
            const quantityInput = document.querySelector(`input[name="items[${index}][quantity]"]`);

            if (selectedOption.value) {
                const price = parseInt(selectedOption.getAttribute('data-price')) || 0;
                const stock = parseInt(selectedOption.getAttribute('data-stock')) || 0;

                priceInput.value = price;
                stockDisplay.value = stock;

                // Set max attribute sesuai available stock
                quantityInput.setAttribute('max', stock);

                // Reset quantity jika sudah ada nilai yang melebihi stock baru
                if (quantityInput.value && parseInt(quantityInput.value) > stock) {
                    quantityInput.value = '';
                }
            } else {
                priceInput.value = '';
                stockDisplay.value = '';
                quantityInput.removeAttribute('max');
                quantityInput.value = '';
            }

            calculateItemTotal(index);
        };

        window.calculateItemTotal = function(index) {
            const quantityInput = document.querySelector(`input[name="items[${index}][quantity]"]`);
            const priceInput = document.querySelector(`input[name="items[${index}][price_per_unit]"]`);
            const total = quantityInput.closest('.item-row').querySelector('.item-total');
            const totalInput = quantityInput.closest('.item-row').querySelector('.item-total-input');

            const quantity = parseInt(quantityInput.value) || 0;
            const price = parseInt(priceInput.value) || 0;
            const totalItem = quantity * price;

            total.value = totalItem;
            totalInput.value = 'Rp ' + totalItem.toLocaleString('id-ID');

            calculateTotal();
        };

        window.calculateTotal = function() {
            let total = 0;
            const itemTotals = document.querySelectorAll('.item-total');

            itemTotals.forEach(input => {
                const value = input.value.replace(/[^\d.-]/g, '');
                total += parseInt(value) || 0;
            });
            
            console.log("total", total);
            document.getElementById('totalPrice').textContent = 'Rp ' + total.toLocaleString('id-ID');
            document.getElementById('totalPriceInput').value = total;
        };

        // Form validation
        document.getElementById('transactionForm').addEventListener('submit', function(e) {
            const items = document.querySelectorAll('.item-row');
            let hasValidItem = false;

            items.forEach(item => {
                const batchSelect = item.querySelector('.batch-select');
                const quantityInput = item.querySelector('.quantity-input');

                if (batchSelect.value && quantityInput.value && quantityInput.value > 0) {
                    hasValidItem = true;
                }
            });

            if (!hasValidItem) {
                e.preventDefault();
                alert('Please add at least one valid item to the transaction.');
                return false;
            }

            // Validate stock
            let stockError = false;
            items.forEach(item => {
                const batchSelect = item.querySelector('.batch-select');
                const quantityInput = item.querySelector('.quantity-input');
                const stockDisplay = item.querySelector('.stock-display');

                if (batchSelect.value && quantityInput.value) {
                    const requestedQty = parseInt(quantityInput.value);
                    const availableStock = parseInt(stockDisplay.value);

                    if (requestedQty > availableStock) {
                        stockError = true;
                        quantityInput.classList.add('is-invalid');
                    } else {
                        quantityInput.classList.remove('is-invalid');
                    }
                }
            });

            if (stockError) {
                e.preventDefault();
                alert('Some items have insufficient stock. Please check the quantities.');
                return false;
            }
        });
    });
</script>
@endpush

<style>
    .item-row {
        background-color: white;
    }

    .is-invalid {
        border-color: #dc3545;
    }

    .quantity-input:invalid {
        border-color: #ffc107;
        background-color: #fff3cd;
    }
</style>
@endsection