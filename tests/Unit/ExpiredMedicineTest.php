<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\Batch;

class ExpiredMedicineTest extends TestCase
{
    public function testMengambilDataObatKadaluarsa()
    {
        // Ambil data batch kadaluarsa yang sudah ada di database
        $expired = Batch::with('medicine.category')
            ->where('expiry_date', '<', now())
            ->get();

        // Memastikan ada batch kadaluarsa
        $this->assertNotEmpty($expired, 'Tidak ada data batch kadaluarsa di database.');

        $first = $expired->first();

        // Validasi properti dan relasi
        $this->assertTrue($first->expiry_date->lt(now()));
        $this->assertNotNull($first->medicine, 'Batch tidak memiliki relasi medicine.');
        $this->assertNotNull($first->medicine->category, 'Medicine tidak memiliki relasi category.');
    }
}
