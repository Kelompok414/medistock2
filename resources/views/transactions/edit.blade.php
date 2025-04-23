@extends('layouts.app')

@section('content')
<div style="background-color: #279B48; height: 50px; width: 100%;"></div>

<div class="d-flex" style="background-color: #F5F5F5; min-height: 100vh;">
    @include('partials.sidebar')

    <div class="flex-grow-1 p-4">
        <h2 class="mb-4">Edit Transaction</h2>

        <div class="card">
            <div class="card-body">
                <form action="{{ route('transactions.update', $transaction->id) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="mb-3">
                        <label>Total Price</label>
                        <input type="number" name="total_price" class="form-control" value="{{ $transaction->total_price }}" required>
                    </div>

                    <div class="mb-3">
                        <label>Transaction Date</label>
                        <input type="datetime-local" name="transaction_date" class="form-control" value="{{ $transaction->transaction_date->format('Y-m-d\TH:i') }}" required>
                    </div>

                    <button class="btn btn-primary">Update</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
