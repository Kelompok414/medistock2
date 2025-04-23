<x-app-layout>
    <div class="py-6">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="mb-6">
                <p class="text-lg text-gray-600">Selamat datang, {{ $name }} ({{ $role }})</p>
            </div>

            <!-- Summary Cards -->
            <div class="flex flex-wrap -mx-3">
                @php
                    $cards = [
                        ['title' => 'Total Obat', 'value' => $totalObat, 'description' => '25 obat baru'],
                        ['title' => 'Akan Kadaluarsa', 'value' => $akanKadaluarsa, 'description' => 'Dalam 3 bulan'],
                        ['title' => 'Kadaluarsa', 'value' => $kadaluarsa, 'description' => 'Harus dimusnahkan'],
                        ['title' => 'Stok Menipis', 'value' => $stokMenipis, 'description' => 'Perlu pemesanan'],
                    ];
                @endphp

                @foreach ($cards as $card)
                    <div class="w-full sm:w-1/2 lg:w-1/4 px-2 mb-4">
                        <div class="h-full">
                            <x-summary-card 
                                :title="$card['title']" 
                                :value="$card['value']" 
                                :description="$card['description']" 
                                class="h-full flex flex-col" 
                            />
                        </div>
                    </div>
                @endforeach
            </div>

            <!-- Main Content -->
            <div class="flex flex-wrap -mx-3">
                <!-- Pengingat Kadaluarsa Table -->
                <div class="w-full lg:w-3/4 px-2 mb-4">
                    <div class="bg-white p-6 shadow rounded-lg h-full">
                        <h3 class="text-lg font-semibold mb-4">Pengingat Kadaluarsa Obat</h3>
                        <div class="overflow-x-auto">
                            <table class="w-full border-collapse">
                                <thead>
                                    <tr class="rounded-lg">
                                        <th class="p-3 text-left bg-green-500 text-white rounded-tl-lg">Nama Obat</th>
                                        <th class="p-3 text-left bg-green-500 text-white">Batch</th>
                                        <th class="p-3 text-left bg-green-500 text-white">Tanggal Kadaluarsa</th>
                                        <th class="p-3 text-left bg-green-500 text-white">Sisa Hari</th>
                                        <th class="p-3 text-left bg-green-500 text-white">Stok</th>
                                        <th class="p-3 text-left bg-green-500 text-white rounded-tr-lg">Status</th>
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
                                            :status="$item['status']" 
                                        />
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <!-- Notifikasi Terbaru -->
                <div class="w-full lg:w-1/4 px-2 mb-4">
                    <div class="bg-white p-6 shadow rounded-lg h-full">
                        <h3 class="text-lg font-semibold mb-4">Notifikasi Terbaru</h3>
                        <ul class="space-y-4">
                            @foreach ($notifikasiTerbaru as $notif)
                                <li class="flex items-start">
                                    <div class="flex-shrink-0 mt-1">
                                        <span class="inline-flex items-center justify-center h-8 w-8 rounded-full 
                                            {{ strpos($notif['pesan'], 'Kadaluarsa') !== false ? 'bg-red-100' : 'bg-yellow-100' }}">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 
                                                {{ strpos($notif['pesan'], 'Kadaluarsa') !== false ? 'text-red-500' : 'text-yellow-500' }}" 
                                                fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                                    d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                            </svg>
                                        </span>
                                    </div>
                                    <div class="ml-3">
                                        <p class="text-sm font-medium">{{ $notif['pesan'] }}</p>
                                        <span class="inline-block bg-gray-200 rounded-full px-3 py-1 text-xs font-semibold text-gray-700 mt-1">
                                            {{ $notif['tanggal'] }}
                                        </span>
                                    </div>
                                </li>
                            @endforeach
                            <li class="text-center mt-2">
                                <a href="#" class="text-green-600 hover:text-green-800 text-sm font-medium">Lihat semua notifikasi</a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>