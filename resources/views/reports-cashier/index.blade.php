@extends('layouts.app')

@section('title', $title)

@section('content')
<div class="container mx-auto px-4 bg-white shadow-md rounded-lg py-6">
    {{-- Navigasi Tab Laporan --}}
    <table class="table" style="background-color: #FFFFFF; border-collapse: separate; border-spacing: 0; width: 100%; min-width: 800px;">
        <thead>
            <tr style="background-color: #279B48; color: #FFFFFF;">
                {{-- Tab Laporan Mingguan --}}
                <th style="padding: 12px; text-align: center; border-bottom: 4px; border-radius: 16px 0 0 16px; font-weight: 400; background-color: {{ request()->routeIs('reports-cashier.weekly') ? 'rgb(159, 198, 170)' : '#279B48' }};">
                    <a href="{{ route('reports-cashier.weekly') }}" style="text-decoration: none; color: {{ request()->routeIs('reports-cashier.weekly') ? 'black' : 'white' }}">Laporan Mingguan</a>
                </th>
                {{-- Tab Laporan Bulanan --}}
                <th style="padding: 12px; text-align: center; border-bottom: 4px; font-weight: 400; background-color: {{ request()->routeIs('reports-cashier.monthly') ? 'rgb(159, 198, 170)' : '#279B48' }};">
                    <a href="{{ route('reports-cashier.monthly') }}" style="text-decoration: none; color: {{ request()->routeIs('reports-cashier.monthly') ? 'black' : 'white' }}">Laporan Bulanan</a>
                </th>
                {{-- Tab Laporan Tahunan --}}
                <th style="padding: 12px; text-align: center; border-bottom: 4px; border-radius: 0 16px 16px 0; font-weight: 400; background-color: {{ request()->routeIs('reports-cashier.annual') ? 'rgb(159, 198, 170)' : '#279B48' }};">
                    <a href="{{ route('reports-cashier.annual') }}" style="text-decoration: none; color: {{ request()->routeIs('reports-cashier.annual') ? 'black' : 'white' }}">Laporan Tahunan</a>
                </th>
            </tr>
        </thead>
    </table>

    {{-- Filter Form berdasarkan jenis laporan --}}
    <form method="GET" class="mb-4">
        @if($type === 'weekly')
            {{-- Dropdown minggu untuk laporan mingguan --}}
            <label for="week">Select Week:</label>
            <select name="week" id="week" onchange="this.form.submit()">
                @foreach ($filters as $week)
                    <option value="{{ $week }}" {{ $selected == $week ? 'selected' : '' }}>Week {{ $week }}</option>
                @endforeach
            </select>
        @elseif($type === 'monthly')
            {{-- Dropdown bulan dan tahun untuk laporan bulanan --}}
            <label for="month">Month:</label>
            <select name="month" id="month">
                @foreach ($filters['months'] as $month)
                    <option value="{{ $month }}" {{ $selected['month'] == $month ? 'selected' : '' }}>
                        {{ \Carbon\Carbon::create()->month($month)->format('F') }}
                    </option>
                @endforeach
            </select>

            <label for="year">Year:</label>
            <select name="year" id="year">
                @foreach ($filters['years'] as $year)
                    <option value="{{ $year }}" {{ $selected['year'] == $year ? 'selected' : '' }}>{{ $year }}</option>
                @endforeach
            </select>

            <button type="submit" class="btn btn-sm btn-secondary" style="background-color:#279B48; color:#fff; border:none; border-radius:4px; padding: 10px 20px;">Filter</button>
        @elseif($type === 'annual')
            {{-- Dropdown tahun untuk laporan tahunan --}}
            <label for="year">Select Year:</label>
            <select name="year" id="year" onchange="this.form.submit()">
                @foreach ($filters as $year)
                    <option value="{{ $year }}" {{ $selected == $year ? 'selected' : '' }}>{{ $year }}</option>
                @endforeach
            </select>
        @endif
    </form>

    {{-- Total Harga seluruh transaksi ditampilkan di kanan atas --}}
    <div class="mb-3">
        @php
            // Menghitung total harga keseluruhan dari seluruh transaksi
            $totalAmount = 0;
            foreach ($transactions as $transaction) {
                foreach ($transaction->saleitems as $item) {
                    $totalAmount += $item->quantity * $item->price_per_unit;
                }
            }
        @endphp
        <div style="background: rgb(159, 198, 170); border:none; border-radius:4px; padding: 10px 20px; display: inline-block; text-align: right; float: right; margin-bottom: 20px;">
            <h5 style="margin: 0;">Total Harga: <strong>Rp{{ number_format($totalAmount, 0, ',', '.') }}</strong></h5>
        </div>
    </div>

    {{-- Tabel data transaksi --}}
    <table class="table table-bordered table-striped">
        <thead>
            <tr style="background-color:#279B48; color:#fff;">
                <th>No</th>
                <th>Nama Obat</th>
                <th>Jumlah</th>
                <th>Harga per Unit</th>
                <th>Total Harga</th>
                <th>Tanggal Transaksi</th>
            </tr>
        </thead>
        <tbody>
            @php $i = 1; @endphp
            @forelse ($transactions as $transaction)
                {{-- Iterasi untuk setiap item penjualan dalam transaksi --}}
                @foreach ($transaction->saleitems as $saleitem)
                    <tr>
                        <td>{{ $i++ }}</td>
                        <td>{{ $saleitem->batch->medicine->name ?? '-' }}</td> {{-- Menangani kemungkinan data null --}}
                        <td>{{ $saleitem->quantity }}</td>
                        <td>Rp{{ number_format($saleitem->price_per_unit, 0, ',', '.') }}</td>
                        <td>Rp{{ number_format($saleitem->quantity * $saleitem->price_per_unit, 0, ',', '.') }}</td>
                        <td>{{ $transaction->transaction_date }}</td>
                    </tr>
                @endforeach
            @empty
                {{-- Jika tidak ada data --}}
                <tr>
                    <td colspan="6">Tidak ada data</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    {{-- Navigasi pagination, tetap menyertakan filter (query string) --}}
    {{ $transactions->withQueryString()->links() }}
</div>
@endsection