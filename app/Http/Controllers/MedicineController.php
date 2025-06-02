<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Batch;

class MedicineController extends Controller
{
    /**
     * Tampilkan daftar obat yang hampir habis stoknya.
     */
    public function lowStock()
    {
        // Ambang batas stok rendah (misal < 10)
        $lowStockThreshold = 10;

        // Ambil batch obat yang stoknya rendah dengan paginate 10
        $lowStockBatches = Batch::with('medicine')
            ->where('quantity', '<', $lowStockThreshold)
            ->orderBy('quantity', 'asc')
            ->paginate(10);

        // Untuk looping di blade, pakai collection dari paginate items
        // Jadi data ini adalah koleksi yang sudah di-paginate
        $lowStockList = $lowStockBatches->map(function ($item) {
            return [
                'nama' => $item->medicine->name ?? '-',
                'batch' => $item->batch_number,
                'stok' => $item->quantity,
                'tanggal_kadaluarsa' => $item->expiry_date->format('Y-m-d'),
                'sisa_hari' => now()->diffInDays($item->expiry_date, false),
                'status' => 'Stok Menipis',
            ];
        });

        return view('stok-obat-menipis', [
            'totalStokMenipis' => $lowStockBatches->total(), // total data di pagination
            'lowStockMedications' => $lowStockList,
            'lowStockPaginator' => $lowStockBatches, // objek paginator untuk paginasi di view
        ]);
    }
}
