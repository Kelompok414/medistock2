<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\User;
use PHPUnit\Framework\Attributes\Test;

class NotifikasiTest extends TestCase
{
    #[Test]
    public function mengakses_notifikasi()
    {
        // Buat user menggunakan factory
        $user = User::factory()->create();

        // Mengakses route /notifikasi dengan user yang sudah login
        $response = $this->actingAs($user)->get('/notifikasi');

        // Memastikan respons status 200 (OK)
        $response->assertStatus(200);
    }
}
