<table class="table table-bordered table-striped">
    <thead>
        <tr>
            <th>ID</th>
            <th>User</th>
            <th>Total Price</th>
            <th>Transaction Date</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        @forelse ($transactions as $transaction)
        <tr>
            <td>{{ $transaction->id }}</td>
            <td>{{ $transaction->user->name ?? 'N/A' }}</td>
            <td>Rp{{ number_format($transaction->total_price, 0, ',', '.') }}</td>
            <td>{{ $transaction->transaction_date }}</td>
            <td>
                <a href="{{ route('transactions.show', $transaction->id) }}" class="btn btn-info btn-sm">View</a>
                <a href="{{ route('transactions.edit', $transaction->id) }}" class="btn btn-primary btn-sm">Edit</a>
                <form action="{{ route('transactions.destroy', $transaction->id) }}" method="POST" class="d-inline">
                    @csrf
                    @method('DELETE')
                    <button onclick="return confirm('Are you sure?')" class="btn btn-danger btn-sm">Delete</button>
                </form>
            </td>
        </tr>
        @empty
        <tr>
            <td colspan="5">No data found</td>
        </tr>
        @endforelse
    </tbody>
</table>

{{ $transactions->links() }}