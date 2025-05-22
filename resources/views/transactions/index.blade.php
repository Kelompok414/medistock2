@extends('layouts.app')

@section('content')
<!-- Header -->
<div style="background-color: #279B48; height: 50px; width: 100%;"></div>

<div class="d-flex" style="background-color: #F5F5F5; min-height: 100vh;">
    @include('partials.sidebar')

    <!-- Main Content -->
    <div class="flex-grow-1 p-4">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2>Transactions</h2>
            <a href="{{ route('transactions.create') }}" class="btn btn-success">+ New Transaction</a>
        </div>

        <form method="GET" id="filter-form" action="{{ route('transactions.index') }}" class="mb-4">
            <div class="row g-2 align-items-end">
                <div class="col-md-3">
                    <label for="user">Search User</label>
                    <input type="text" name="user" id="user-search" class="form-control" placeholder="User name">
                </div>
                <div class="col-md-3">
                    <label for="from_date">From Date</label>
                    <input type="date" name="from_date" id="from_date" class="form-control" value="{{ request('from_date') }}">
                </div>
                <div class="col-md-3">
                    <label for="to_date">To Date</label>
                    <input type="date" name="to_date" id="to_date" class="form-control" value="{{ request('to_date') }}">
                </div>
                <div class="col-md-3 d-flex">
                    <button type="submit" class="btn btn-success me-2">Filter</button>
                    <a href="{{ route('transactions.index') }}" class="btn btn-secondary">Reset</a>
                </div>
            </div>
        </form>

        <div class="card">
            <div class="card-body">
                <div id="transaction-table">
                    @include('transactions.partials.table-transactions', ['transactions' => $transactions])
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const searchInput = document.getElementById('user-search');

        searchInput.addEventListener('keyup', function() {
            const user = searchInput.value;
            const from_date = document.getElementById('from_date').value;
            const to_date = document.getElementById('to_date').value;

            fetch(`{{ route('transactions.index') }}?user=${user}&from_date=${from_date}&to_date=${to_date}`, {
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest'
                    }
                })
                .then(response => response.text())
                .then(html => {
                    document.getElementById('transaction-table').innerHTML = html;
                });
        });
    });
</script>
@endpush