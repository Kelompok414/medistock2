@extends('layouts.app')

@section('content')
<div class="container-fluid p-3">
    <!-- Welcome Message -->
    <div class="mb-4">
        <p class="welcome-message">Selamat datang, {{ $name }} ({{ $role }})</p>
    </div>

    <!-- Summary Cards -->
    <div class="row g-3 mb-4">
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
    <div class="row g-3">
        <!-- Expired Reminder Table -->
        <div class="col-12 col-lg-9">
            <div class="card">
                <div class="card-body p-3">
                    <h3 class="section-title mb-3">Pengingat Kadaluarsa Obat</h3>
                    
                    <!-- Table -->
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr class="table-header">
                                    <th width="20%">Nama Obat</th>
                                    <th width="15%" class="text-center">Batch</th>
                                    <th width="20%" class="text-center">Tanggal Kadaluarsa</th>
                                    <th width="15%" class="text-center">Sisa Hari</th>
                                    <th width="10%" class="text-center">Stok</th>
                                    <th width="20%" class="text-center">Status</th>
                                </tr>
                            </thead>
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

        <!-- Latest Notification -->
        <div class="col-12 col-lg-3">
            <div class="card">
                <div class="card-body p-3">
                    <h3 class="section-title mb-3">Notifikasi Terbaru</h3>
                    
                    <!-- Notifications List -->
                    <div>
                        <ul class="list-unstyled notification-list">
                            @foreach ($notifikasiTerbaru as $notif)
                            @php
                                $icon = '';
                                $iconClass = '';
                                $bgColor = '';

                                if (strpos($notif['pesan'], 'Telah Kadaluarsa') !== false) {
                                    $icon = 'x-circle.png';
                                    $iconClass = 'icon-danger';
                                    $bgColor = 'rgba(237, 30, 40, 0.1)';
                                } elseif (strpos($notif['pesan'], 'Laporan') !== false) {
                                    $icon = 'report.png';
                                    $iconClass = 'icon-black';
                                    $bgColor = 'var(--light-gray)';
                                } elseif (strpos($notif['pesan'], 'Akan Kadaluarsa') !== false) {
                                    $icon = 'alert-circle.png';
                                    $iconClass = 'icon-warning';
                                    $bgColor = 'rgba(255, 189, 7, 0.1)';
                                } else {
                                    $icon = 'alert-circle.png';
                                    $iconClass = 'icon-warning';
                                    $bgColor = 'rgba(255, 189, 7, 0.1)';
                                }
                            @endphp
                            <li class="notification-item mb-3">
                                <div class="d-flex align-items-start">
                                    <div class="notification-icon" style="background-color: {{ $bgColor }};">
                                        <img src="{{ asset('assets/images/' . $icon) }}" alt="Notification Icon" 
                                            width="18" height="18" class="{{ $iconClass }}">
                                    </div>
                                    <div class="ms-3">
                                        <p class="notification-message">{{ $notif['pesan'] }}</p>
                                        <p class="notification-description">{{ $notif['deskripsi'] }}</p>
                                        <span class="badge-tanggal">{{ $notif['tanggal'] }}</span>
                                    </div>
                                </div>
                            </li>
                            @endforeach
                        </ul>

                        <div class="text-center mt-3">
                            <a href="#" class="view-all-link">Lihat semua notifikasi</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection