@extends('layouts.app')

@section('content')
        <!-- Summary Cards -->
        <div class="row mb-2">
            <div class="col-lg-4 col-md-6 mb-2">
                <div class="p-4" style="border-radius: 16px; background-color: #FFFFFF; color: #000000;">
                    <h5 style="font-size: 16px;">Total Penjualan</h5>
                    <h3 style="font-size: 24px; margin: 0;">Rp {{ number_format($totalSales, 0, ',', '.') }}</h3>
                </div>
            </div>
            <div class="col-lg-4 col-md-6 mb-2">
                <div class="p-4" style="border-radius: 16px; background-color: #FFFFFF; color: #000000;">
                    <h5 style="font-size: 16px;">Obat yang Terjual</h5>
                    <h3 style="font-size: 24px; margin: 0;">{{ $totalSoldDrugs }}</h3>
                </div>
            </div>
            <div class="col-lg-4 col-md-6 mb-2">
                <div class="p-4" style="border-radius: 16px; background-color: #FFFFFF; color: #000000;">
                    <h5 style="font-size: 16px;">Jumlah Transaksi</h5>
                    <h3 style="font-size: 24px; margin: 0;">{{ $totalTransactions }}</h3>
                </div>
            </div>
        </div>

        <!-- Overview Table -->
        <div class="col-12 mb-4">
            <div class="p-4" style="border-radius: 16px; background-color: #FFFFFF; width: 100%;">
                <h1 style="font-size: 24px; font-weight: 500; margin-bottom: 24px;">History Penjualan</h1>
                <table class="table" style="background-color: #FFFFFF; border-collapse: separate; border-spacing: 0; width: 100%;">
                    <thead>
                        <tr style="background-color: #279B48; color: #FFFFFF;">
                            <th style="padding: 12px; text-align: center; font-weight: normal; border-top-left-radius: 16px;">Nama Obat</th>
                            <th style="padding: 12px; text-align: center; font-weight: normal;">Metode Pembayaran</th>
                            <th style="padding: 12px; text-align: center; font-weight: normal;">Tanggal Transaksi</th>
                            <th style="padding: 12px; text-align: center; font-weight: normal;">Total Item</th>
                            <th style="padding: 12px; text-align: center; font-weight: normal; border-top-right-radius: 16px;">Total Harga</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($transactions as $transaction)
                            <tr>
                                <td style="padding: 12px; text-align: center;">{{ $transaction->name }}</td>
                                <td style="padding: 12px; text-align: center;">{{ $transaction->payment_method }}</td>
                                <td style="padding: 12px; text-align: center;">{{ $transaction->transaction_date }}</td>
                                <td style="padding: 12px; text-align: center;">{{ $transaction->total_items }}</td>
                                <td style="padding: 12px; text-align: center;">Rp {{ number_format($transaction->total_price, 0, ',', '.') }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection