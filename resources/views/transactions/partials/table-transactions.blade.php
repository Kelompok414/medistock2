<div class="overflow-x-auto rounded-xl shadow border border-gray-200">
    <table class="min-w-full divide-y divide-gray-200">
        <thead class="bg-gray-50">
            <tr>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nama Pelanggan</th>

                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider cursor-pointer"
                    data-sort-column="transaction_date" data-sort-dir="asc">
                    Tanggal
                </th>

                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider cursor-pointer"
                    data-sort-column="total_price" data-sort-dir="asc">
                    Harga
                </th>

                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Keterangan</th>
            </tr>
        </thead>
        <tbody class="text-sm text-gray-700 divide-y divide-gray-100">
            @forelse ($transactions as $transaction)
            <tr class="hover:bg-gray-50 transition">
                <td class="px-6 py-4 whitespace-nowrap">
                    {{ $transaction->customer_name ?? 'N/A' }}
                </td>
                <td class="px-6 py-4">
                    <span class="inline-block bg-blue-100 text-blue-800 px-2 py-1 rounded text-xs">
                        {{ $transaction->transaction_date }}
                    </span>
                </td>
                <td class="px-6 py-4">
                    <span class="inline-block bg-green-100 text-green-800 px-3 py-1 rounded-full text-xs font-semibold">
                        Rp{{ number_format($transaction->total_price, 0, ',', '.') }}
                    </span>
                </td>
                <td class="px-6 py-4 text-center space-x-2">
                    <a href="{{ route('transactions.show', $transaction->id) }}"
                        class="inline-flex items-center gap-1 px-3 py-1 bg-sky-100 text-sky-700 rounded-md text-xs hover:bg-sky-200 transition">
                        🔍 Detail
                    </a>
                    <a href="{{ route('transactions.edit', $transaction->id) }}"
                        class="inline-flex items-center gap-1 px-3 py-1 bg-yellow-100 text-yellow-800 rounded-md text-xs hover:bg-yellow-200 transition">
                        ✏️ Edit
                    </a>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="4" class="text-center py-6 text-gray-400">Tidak ada transaksi ditemukan</td>
            </tr>
            @endforelse
        </tbody>
    </table>

    <div class="px-6 py-3 bg-gray-50 border-t border-gray-200">
        {!! $transactions->withQueryString()->links() !!}
    </div>
</div>