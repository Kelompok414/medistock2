@extends('layouts.app')

@section('content')
<div style="background-color: #279B48; height: 50px; width: 100%;"></div>

<div class="d-flex" style="background-color: #F5F5F5; min-height: 100vh;">
    @include('partials.sidebar')

    <div class="flex-grow-1 p-4">
        <h2 class="mb-4">Create New Transaction</h2>

        <div class="card">
            <div class="card-body">
                <form method="POST" action="{{ route('transactions.store') }}">
                    @csrf

                    <div class="mb-3">
                        <label>User</label>
                        <select name="user_id" class="form-select" required>
                            @foreach ($users as $user)
                                <option value="{{ $user->id }}">{{ $user->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-3">
                        <label>Total Price</label>
                        <input type="number" name="total_price" class="form-control" required>
                    </div>

                    <button class="btn btn-success">Submit</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
