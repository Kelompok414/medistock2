@extends('layouts.app')

@section('content')
<div class="mx-auto px-4 sm:px-6 lg:px-8 py-6">

    <!-- Filter Form -->
    <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-200 mb-8">
        <h2 class="text-xl font-semibold text-gray-900 mb-5">Penjualan</h2>

        <form method="GET" id="filter-form" action="{{ route('transactions.index') }}">
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-4 items-end">

                <!-- Search User -->
                <div class="lg:col-span-4">
                    <label for="customer_name" class="block text-sm font-medium text-gray-700 mb-1">🔍 Cari Pelanggan</label>
                    <input type="text" name="customer_name" id="user-search"
                        value="{{ request('customer_name') }}"
                        class="w-full rounded-lg border border-gray-300 px-4 py-2 text-sm focus:ring-2 focus:ring-primary focus:border-primary transition"
                        placeholder="Nama customer...">
                </div>

                <!-- From Date -->
                <div class="lg:col-span-2">
                    <label for="from_date" class="block text-sm font-medium text-gray-700 mb-1">📅 Dari Tanggal</label>
                    <input type="date" name="from_date" id="from_date" value="{{ request('from_date') }}"
                        class="w-full rounded-lg border border-gray-300 px-4 py-2 text-sm focus:ring-2 focus:ring-primary focus:border-primary transition">
                </div>

                <!-- To Date -->
                <div class="lg:col-span-2">
                    <label for="to_date" class="block text-sm font-medium text-gray-700 mb-1">📅 Sampai Tanggal</label>
                    <input type="date" name="to_date" id="to_date" value="{{ request('to_date') }}"
                        class="w-full rounded-lg border border-gray-300 px-4 py-2 text-sm focus:ring-2 focus:ring-primary focus:border-primary transition">
                </div>

                <!-- Buttons -->
                <div class="lg:col-span-2 flex gap-2">
                    <button type="submit"
                        class="w-full bg-[#279B48] text-white px-4 py-2 rounded-lg text-sm font-medium">
                        🔎 Filter
                    </button>
                    <a href="{{ route('transactions.index') }}"
                        class="w-full bg-gray-100 text-gray-700 px-4 py-2 rounded-lg text-sm font-medium hover:bg-gray-200 text-center transition">
                        ❌ Reset
                    </a>
                </div>

            </div>
        </form>
    </div>

    <!-- Transaction Table Card -->
    <div class="bg-white rounded-lg shadow-md overflow-hidden">
        <div class="p-6" id="transaction-table">
            <a href="{{ route('transactions.create') }}"
                class="inline-flex items-center gap-1 mb-4 px-4 py-2 bg-[#279B48] text-white rounded-md transition">
                + Tambah Transaksi
            </a>
            @include('transactions.partials.table-transactions', ['transactions' => $transactions])
        </div>
    </div>

</div>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', () => {
        const userInput = document.getElementById('user-search');
        const fromDate = document.getElementById('from_date');
        const toDate = document.getElementById('to_date');
        const tableContainer = document.getElementById('transaction-table');

        // Current sort state
        let currentSortColumn = '{{ request("sort_column", "transaction_date") }}';
        let currentSortDir = '{{ request("sort_dir", "desc") }}';

        // Helper to build query params including filters and sort
        function buildQuery(sortColumn = currentSortColumn, sortDir = currentSortDir) {
            const params = new URLSearchParams();
            if (userInput.value.trim()) params.append('customer_name', userInput.value.trim());
            if (fromDate.value) params.append('from_date', fromDate.value);
            if (toDate.value) params.append('to_date', toDate.value);
            if (sortColumn) params.append('sort_column', sortColumn);
            if (sortDir) params.append('sort_dir', sortDir);
            return params.toString();
        }

        // Fetch table with filters and sorting
        function fetchTable(sortColumn = currentSortColumn, sortDir = currentSortDir) {
            currentSortColumn = sortColumn;
            currentSortDir = sortDir;

            fetch(`{{ route('transactions.index') }}?${buildQuery(sortColumn, sortDir)}`, {
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest'
                    }
                })
                .then(res => res.text())
                .then(html => {
                    tableContainer.innerHTML = html;
                    updateSortIndicators();
                    bindHeaderClicks();
                });
        }

        // Update sort indicators on header arrows
        function updateSortIndicators() {
            document.querySelectorAll('th[data-sort-column]').forEach(th => {
                const col = th.getAttribute('data-sort-column');
                const arrowUp = '▲';
                const arrowDown = '▼';

                if (col === currentSortColumn) {
                    th.setAttribute('data-sort-dir', currentSortDir === 'asc' ? 'asc' : 'desc');
                    th.innerHTML = th.textContent.trim().replace(/[▲▼]/g, '') + (currentSortDir === 'asc' ? ` ${arrowUp}` : ` ${arrowDown}`);
                } else {
                    th.setAttribute('data-sort-dir', 'asc'); // default next click is asc
                    th.innerHTML = th.textContent.trim().replace(/[▲▼]/g, '');
                }
            });
        }

        // Bind click events on sortable headers
        function bindHeaderClicks() {
            document.querySelectorAll('th[data-sort-column]').forEach(th => {
                th.style.cursor = 'pointer';
                th.onclick = () => {
                    const col = th.getAttribute('data-sort-column');
                    let dir = th.getAttribute('data-sort-dir') === 'asc' ? 'desc' : 'asc';
                    fetchTable(col, dir);
                };
            });
        }

        // Bind filter inputs to fetch table on change
        [userInput, fromDate, toDate].forEach(el => {
            el.addEventListener('change', () => fetchTable());
            if (el === userInput) {
                let debounceTimeout;
                el.addEventListener('keyup', () => {
                    clearTimeout(debounceTimeout);
                    debounceTimeout = setTimeout(() => fetchTable(), 300);
                });
            }
        });

        // Initial setup
        updateSortIndicators();
        bindHeaderClicks();
    });
</script>
@endpush