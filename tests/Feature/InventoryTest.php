<?php

namespace Tests\Feature;

use App\Models\Medicine;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class InventoryTest extends TestCase
{
    use RefreshDatabase;


    public function test_tambah_obat_baru()
    {
        $response = $this->postJson('/medicines', [
            'name' => 'Paracetamol',
            'batch' => 'B12345',
            'expiry_date' => '2025-12-31',
            'price' => 10000,
            'stock' => 100,
        ]);

        $response->assertStatus(201);
        $this->assertDatabaseHas('medicines', [
            'name' => 'Paracetamol',
            'batch' => 'B12345',
            'expiry_date' => '2025-12-31',
            'price' => 10000,
            'stock' => 100,
        ]);
    }


    public function test_tambah_obat_validasi_field_kosong()
    {
        $response = $this->postJson('/medicines', []);

        $response->assertStatus(422);
        $response->assertJsonValidationErrors(['name', 'batch', 'expiry_date', 'price', 'stock']);
    }


    public function test_update_stok_obat()
    {
        $medicine = Medicine::factory()->create([
            'name' => 'Paracetamol',
            'batch' => 'B12345',
            'expiry_date' => '2025-12-31',
            'price' => 10000,
            'stock' => 100,
        ]);

        $response = $this->putJson("/medicines/{$medicine->id}", ['stock' => 200]);

        $response->assertStatus(200);
        $this->assertDatabaseHas('medicines', [
            'id' => $medicine->id,
            'stock' => 200,
        ]);
    }


    public function test_update_stok_obat_ke_angka_negatif()
    {
        $medicine = Medicine::factory()->create([
            'name' => 'Paracetamol',
            'batch' => 'B12345',
            'expiry_date' => '2025-12-31',
            'price' => 10000,
            'stock' => 100,
        ]);

        $response = $this->putJson("/medicines/{$medicine->id}", ['stock' => -50]);

        $response->assertStatus(422);
        $response->assertJsonValidationErrors(['stock']);
    }


    public function test_hapus_obat()
    {
        $medicine = Medicine::factory()->create([
            'name' => 'Paracetamol',
            'batch' => 'B12345',
            'expiry_date' => '2025-12-31',
            'price' => 10000,
            'stock' => 100,
        ]);

        $response = $this->deleteJson("/medicines/{$medicine->id}");

        $response->assertStatus(200);
        $this->assertDatabaseMissing('medicines', ['id' => $medicine->id]);
    }


    public function test_ambil_daftar_obat()
    {
        Medicine::factory()->count(3)->create([
            'name' => 'Paracetamol',
            'batch' => 'B12345',
            'expiry_date' => '2025-12-31',
            'price' => 10000,
            'stock' => 100,
        ]);

        $response = $this->getJson('/medicines');

        $response->assertStatus(200);
        $response->assertJsonStructure([
            '*' => ['id', 'name', 'batch', 'expiry_date', 'price', 'stock'],
        ]);
    }

    
    public function test_cari_obat_berdasarkan_nama()
    {
        Medicine::factory()->create([
            'name' => 'Paracetamol',
            'batch' => 'B12345',
            'expiry_date' => '2025-12-31',
            'price' => 10000,
            'stock' => 100,
        ]);

        Medicine::factory()->create([
            'name' => 'Ibuprofen',
            'batch' => 'B67890',
            'expiry_date' => '2025-12-31',
            'price' => 15000,
            'stock' => 50,
        ]);

        $response = $this->getJson('/medicines?search=Paracetamol');

        $response->assertStatus(200);
        $response->assertJsonFragment(['name' => 'Paracetamol']);
        $response->assertJsonMissing(['name' => 'Ibuprofen']);
    }
}