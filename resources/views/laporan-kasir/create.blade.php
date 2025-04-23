<?php
namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\LaporanKasir;

class LaporanKasirTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    /** @test */
    public function laporan_kasir_create_page_is_accessible()
    {
        $response = $this->get(route('laporan-kasir.create'));
        $response->assertStatus(200);
        $response->assertSee('Tambah Laporan Kasir');
        $response->assertSee('Total Transaksi');
        $response->assertSee('Persentase Bulan');
        $response->assertSee('Obat Terlaris');
    }

    /** @test */
    public function user_can_create_laporan_kasir()
    {
        $data = [
            'total_transaksi' => 5000000,
            'persentase_bulan' => '15%',
            'obat_terlaris' => 'Paracetamol',
            'total_terjual' => 150,
            'stok_rendah' => 10
        ];

        $response = $this->post(route('laporan-kasir.store'), $data);

        $response->assertRedirect(); // Sesuaikan dengan redirect yang Anda gunakan
        $this->assertDatabaseHas('laporan_kasirs', [
            'obat_terlaris' => 'Paracetamol'
        ]);
    }

    /** @test */
    public function laporan_kasir_requires_all_fields()
    {
        $response = $this->post(route('laporan-kasir.store'), []);

        $response->assertSessionHasErrors([
            'total_transaksi',
            'persentase_bulan',
            'obat_terlaris',
            'total_terjual',
            'stok_rendah'
        ]);
    }

    /** @test */
    public function total_transaksi_must_be_numeric()
    {
        $response = $this->post(route('laporan-kasir.store'), [
            'total_transaksi' => 'not-a-number',
            'persentase_bulan' => '15%',
            'obat_terlaris' => 'Paracetamol',
            'total_terjual' => 150,
            'stok_rendah' => 10
        ]);

        $response->assertSessionHasErrors('total_transaksi');
    }

    /** @test */
    public function total_terjual_must_be_numeric()
    {
        $response = $this->post(route('laporan-kasir.store'), [
            'total_transaksi' => 5000000,
            'persentase_bulan' => '15%',
            'obat_terlaris' => 'Paracetamol',
            'total_terjual' => 'not-a-number',
            'stok_rendah' => 10
        ]);

        $response->assertSessionHasErrors('total_terjual');
    }
}