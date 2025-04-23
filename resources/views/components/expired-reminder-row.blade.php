@props(['nama', 'batch', 'tanggalKadaluarsa', 'sisaHari', 'stok', 'status'])

<tr class="border-b hover:bg-gray-50">
    <td class="p-3 text-left">{{ $nama }}</td>
    <td class="p-3 text-left">{{ $batch }}</td>
    <td class="p-3 text-left">{{ $tanggalKadaluarsa }}</td>
    <td class="p-3 text-left">{{ $sisaHari }}</td>
    <td class="p-3 text-left">{{ $stok }}</td>
    <td class="p-3 text-left">
        @if ($status == 'Kadaluarsa')
            <span class="px-2 py-1 bg-red-100 text-red-500 rounded-full text-xs">Kadaluarsa</span>
        @elseif ($status == 'Akan Kadaluarsa')
            <span class="px-2 py-1 bg-yellow-100 text-yellow-500 rounded-full text-xs">Akan Kadaluarsa</span>
        @else
            <span class="px-2 py-1 bg-green-100 text-green-500 rounded-full text-xs">Tersedia</span>
        @endif
    </td>
</tr>