<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\Batch;

class WillExpireMedicineTest extends TestCase
{
    public function testMengambilDataObatYangAkanKadaluarsa()
    {
        // Ambil data batch dengan expiry_date antara sekarang dan 1 bulan ke depan
        $soonToExpire = Batch::with('medicine.category')
            ->where('expiry_date', '>', now())
            ->where('expiry_date', '<', now()->addMonth())
            ->get();

        // Memastikan ada batch yang akan kadaluarsa
        $this->assertNotEmpty($soonToExpire, 'Tidak ditemukan obat yang akan kadaluarsa dalam 1 bulan.');

        // Ambil batch pertama
        $first = $soonToExpire->first();

        // Memastikan expiry date lebih kecil dari 1 bulan ke depan
        $this->assertTrue($first->expiry_date->lt(now()->addMonth()));

        // Memastikan expiry date lebih besar dari sekarang
        $this->assertTrue($first->expiry_date->gt(now()));

        // Memastikan batch memiliki relasi medicine
        $this->assertNotNull($first->medicine, 'Batch tidak memiliki relasi medicine.');

        // Memastikan batch memiliki relasi category
        $this->assertNotNull($first->medicine->category, 'Medicine tidak memiliki relasi category.');
    }
}
