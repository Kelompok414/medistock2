<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\Batch;

class OutOfStockMedicineTest extends TestCase
{
    public function testMengambilDataObatYangHabis()
    {
        // Ambil data batch yang stoknya habis (quantity <= 0)
        $outOfStock = Batch::with('medicine.category')
            ->where('quantity', '<=', 0)
            ->get();

        // Pastikan ada batch yang habis
        $this->assertNotEmpty($outOfStock, 'Tidak ada data batch dengan stok habis.');

        // Ambil batch pertama
        $first = $outOfStock->first();

        // Pastikan quantity 0 atau kurang
        $this->assertTrue($first->quantity <= 0);

        // Pastikan relasi medicine tersedia
        $this->assertNotNull($first->medicine, 'Batch tidak memiliki relasi medicine.');

        // Pastikan relasi category tersedia
        $this->assertNotNull($first->medicine->category, 'Medicine tidak memiliki relasi category.');
    }
}
