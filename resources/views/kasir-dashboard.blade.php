@extends('layouts.app')

@section('content')
        <!-- Summary Cards -->
        <div class="row mb-2">
            <div class="col-lg-4 col-md-6 mb-2">
                <div class="p-4" style="border-radius: 16px; background-color: #FFFFFF; color: #000000;">
                    <div class="d-flex align-items-center mb-2">
                        <span style="display: inline-flex; align-items: center; justify-content: center; width: 36px; height: 36px; border-radius: 50%; background: #F0F1F3; margin-right: 10px;">
                            <i data-feather="dollar-sign" style="width: 20px; height: 20px; color: #000;"></i>
                        </span>
                        <h5 style="font-size: 20px; margin: 0;">Total Penjualan</h5>
                    </div>
                    <h3 style="font-size: 24px; margin: 0;">Rp{{ number_format($totalSales, 0, ',', '.') }}</h3>
                </div>
            </div>
            <div class="col-lg-4 col-md-6 mb-2">
                <div class="p-4" style="border-radius: 16px; background-color: #FFFFFF; color: #000000;">
                    <div class="d-flex align-items-center mb-2">
                        <span style="display: inline-flex; align-items: center; justify-content: center; width: 36px; height: 36px; border-radius: 50%; background: #F0F1F3; margin-right: 10px;">
                            <i data-feather="shopping-bag" style="width: 20px; height: 20px; color: #000;"></i>
                        </span>
                        <h5 style="font-size: 20px; margin: 0;">Obat yang Terjual</h5>
                    </div>
                    <h3 style="font-size: 24px; margin: 0;">{{ $totalSoldDrugs }}</h3>
                </div>
            </div>
            <div class="col-lg-4 col-md-6 mb-2">
                <div class="p-4" style="border-radius: 16px; background-color: #FFFFFF; color: #000000;">
                    <div class="d-flex align-items-center mb-2">
                        <span style="display: inline-flex; align-items: center; justify-content: center; width: 36px; height: 36px; border-radius: 50%; background: #F0F1F3; margin-right: 10px;">
                            <i data-feather="file-text" style="width: 20px; height: 20px; color: #000;"></i>
                        </span>
                        <h5 style="font-size: 20px; margin: 0;">Jumlah Transaksi</h5>
                    </div>
                    <h3 style="font-size: 24px; margin: 0;">{{ $totalTransactions }}</h3>
                </div>
            </div>
        </div>

        <!-- Overview Table -->
        <div class="col-12 mb-4">
            <div class="p-4" style="border-radius: 16px; background-color: #FFFFFF; width: 100%;">
                <h1 style="font-size: 24px; font-weight: 500; margin-bottom: 24px;">Overview Penjualan</h1>
                <table class="table" style="background-color: #FFFFFF; border-collapse: separate; border-spacing: 0; width: 100%;">
                    <thead>
                        <tr style="background-color: #279B48; color: #FFFFFF;">
                            <th style="padding: 12px; text-align: center; font-weight: normal; border-top-left-radius: 16px;">Pelanggan</th>
                            <th style="padding: 12px; text-align: center; font-weight: normal;">Tanggal</th>
                            <th style="padding: 12px; text-align: center; font-weight: normal; border-top-right-radius: 16px;">Total Harga</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($transactions->take(10) as $transaction)
                            <tr>
                                <td style="padding: 12px; text-align: center;">
                                    {{ $transaction->user->name ?? '-' }}
                                </td>
                                <td style="padding: 12px; text-align: center;">
                                    {{ \Carbon\Carbon::parse($transaction->transaction_date)->format('d-m-Y') }}
                                </td>
                                <td style="padding: 12px; text-align: center;">
                                    Rp {{ number_format($transaction->total_price, 0, ',', '.') }}
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection