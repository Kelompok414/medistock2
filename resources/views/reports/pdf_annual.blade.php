<!DOCTYPE html>
<html>
<head>
    <title>{{ $title }}</title>
    <style>
        body { font-family: sans-serif; font-size: 12px; }
        table { border-collapse: collapse; width: 100%; }
        th, td { border: 1px solid #000; padding: 4px; text-align: left; }
    </style>
</head>
<body>
    <h2>{{ $title }}</h2>
    <p>Period: {{ $startDate->format('d M Y') }} - {{ $endDate->format('d M Y') }}</p>

    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Transaction Date</th>
                <th>Medicine Name</th>
                <th>Quantity</th>
                <th>Total Price</th>
            </tr>
        </thead>
        <tbody>
            @php $i = 1; @endphp
            @foreach($transactions as $transaction)
                @foreach($transaction->saleitems as $item)
                    <tr>
                        <td>{{ $i++ }}</td>
                        <td>{{ $transaction->transaction_date->format('d-m-Y') }}</td>
                        <td>{{ $item->batch->medicine->name ?? '-' }}</td>
                        <td>{{ $item->quantity }}</td>
                        <td>{{ number_format($item->quantity * $item->price_per_unit, 2) }}</td>
                    </tr>
                @endforeach
            @endforeach
        </tbody>
    </table>
</body>
</html>
