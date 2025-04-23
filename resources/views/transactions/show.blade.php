@extends('layouts.app')

@section('content')
<div style="background-color: #279B48; height: 50px; width: 100%;"></div>

<div class="d-flex" style="background-color: #F5F5F5; min-height: 100vh;">
    @include('partials.sidebar')

    <div class="flex-grow-1 p-4">
        <h2 class="mb-4">Transaction Detail</h2>

        <div class="card">
            <div class="card-body">
                <p><strong>ID:</strong> {{ $transaction->id }}</p>
                <p><strong>User:</strong> {{ $transaction->user->name ?? 'N/A' }}</p>
                <p><strong>Total Price:</strong> Rp{{ number_format($transaction->total_price, 0, ',', '.') }}</p>
                <p><strong>Transaction Date:</strong> {{ $transaction->transaction_date }}</p>

                <a href="{{ route('transactions.index') }}" class="btn btn-secondary">Back</a>
            </div>
        </div>
    </div>
</div>
@endsection
