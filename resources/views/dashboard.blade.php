@extends('layouts.app')

@section('content')
<div class="d-flex flex-column h-100">
    <!-- Welcome Message -->
    <div class="mb-3">
        <p class="font-medium" style="font-size: 20px; margin-bottom: 10px;">Selamat datang, {{ $name }} ({{ $role }})</p>
    </div>

    <!-- Summary Cards -->
    <div class="row g-3 mb-3">
        @php
        $cards = [
            ['title' => 'Total Obat', 'value' => $totalObat, 'description' => '25 obat baru'],
            ['title' => 'Akan Kadaluarsa', 'value' => $akanKadaluarsa, 'description' => 'Dalam 3 bulan'],
            ['title' => 'Kadaluarsa', 'value' => $kadaluarsa, 'description' => 'Harus dimusnahkan'],
            ['title' => 'Stok Menipis', 'value' => $stokMenipis, 'description' => 'Perlu pemesanan'],
        ];
        @endphp

        @foreach ($cards as $card)
        <x-summary-card :title="$card['title']" :value="$card['value']" :description="$card['description']" />
        @endforeach
    </div>

    <!-- Main Content -->
    <div class="row g-3 flex-grow-1 min-height-content">
        <!-- Expired Reminder Table -->
        <div class="col-12 col-lg-9 d-flex flex-column">
            <div class="card w-100 h-100">
                <div class="card-body d-flex flex-column p-0">
                    <div class="p-3">
                        <h3 style="font-size: 20px; font-weight: medium; margin-bottom: 10px;">Pengingat Kadaluarsa Obat</h3>
                    </div>

                    <!-- Table Container -->
                    <div class="d-flex flex-column flex-grow-1 min-height-0">
                        <!-- Tabel Header (fixed) -->
                        <div style="padding: 0 15px;">
                            <table class="table borderless-table fixed-table mb-0">
                                <thead class="sticky-header">
                                    <tr style="background-color: var(--primary); color: var(--white);">
                                        <th width="20%" style="padding: 12px; text-align: left; border-radius: 16px 0 0 0; font-weight: 500; font-size: 16px;">Nama Obat</th>
                                        <th width="15%" style="padding: 12px; text-align: center; font-weight: 400; font-size: 16px;">Batch</th>
                                        <th width="20%" style="padding: 12px; text-align: center; font-weight: 400; font-size: 16px;">Tanggal Kadaluarsa</th>
                                        <th width="15%" style="padding: 12px; text-align: center; font-weight: 400; font-size: 16px;">Sisa Hari</th>
                                        <th width="10%" style="padding: 12px; text-align: center; font-weight: 400; font-size: 16px;">Stok</th>
                                        <th width="20%" style="padding: 12px; text-align: center; border-radius: 0 16px 0 0; font-weight: 500; font-size: 16px;">Status</th>
                                    </tr>
                                </thead>
                            </table>
                        </div>

                        <!-- Area scrolling untuk body tabel -->
                        <div class="scroll-container" style="flex: 1; overflow-y: auto; padding: 0 15px 15px;">
                            <table class="table borderless-table fixed-table mb-0">
                                <tbody>
                                    @foreach ($pengingatKadaluarsa as $item)
                                    <x-expired-reminder-row
                                        :nama="$item['nama']"
                                        :batch="$item['batch']"
                                        :tanggalKadaluarsa="$item['tanggal_kadaluarsa']"
                                        :sisaHari="$item['sisa_hari']"
                                        :stok="$item['stok']"
                                        :status="$item['status']" />
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Latest Notification -->
        <div class="col-12 col-lg-3 d-flex flex-column">
            <div class="card w-100 h-100">
                <div class="card-body d-flex flex-column p-0">
                    <div class="p-3">
                        <h3 style="font-size: 20px; font-weight: medium; margin-bottom: 10px;">Notifikasi Terbaru</h3>
                    </div>

                    <!-- Scrollable notifications -->
                    <div class="notification-container flex-grow-1">
                        <div class="px-3">
                            <ul class="list-unstyled mb-0">
                                @foreach ($notifikasiTerbaru as $notif)
                                <li class="d-flex align-items-start mb-3">
                                    <div class="flex-shrink-0">
                                        <span class="d-inline-flex align-items-center justify-content-center"
                                            style="height: 2rem; width: 2rem; border-radius: 50%; background-color: {{ strpos($notif['pesan'], 'Kadaluarsa') !== false ? '#f8d7da' : '#fff3cd' }};">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="1.2rem" height="1.2rem"
                                                fill="none" viewBox="0 0 24 24" stroke="{{ strpos($notif['pesan'], 'Kadaluarsa') !== false ? '#dc3545' : '#ffc107' }}">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                            </svg>
                                        </span>
                                    </div>
                                    <div class="ms-3">
                                        <p style="font-size: 15px; margin-bottom: 5px;">{{ $notif['pesan'] }}</p>
                                        <span class="d-inline-block px-2 py-1 rounded-pill"
                                            style="background-color: #e9ecef; font-size: 12px; color: #495057;">
                                            {{ $notif['tanggal'] }}
                                        </span>
                                    </div>
                                </li>
                                @endforeach
                            </ul>

                            <div class="text-center mt-3">
                                <a href="#" style="color: var(--primary); text-decoration: none; font-size: 15px;">Lihat semua notifikasi</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection