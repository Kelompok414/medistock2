<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;

class DashboardAdminTest extends TestCase
{
    // Test untuk memastikan navigasi ke halaman kasir berhasil
    public function testNavigasiKasir()
    {
        // Login terlebih dahulu
        $this->post('/login', [
            'email' => 'admin@example.com',
            'password' => 'password',
        ]);

        // Akses halaman manajemen kasir
        $response = $this->get('/manajemen-kasir');
        
        // Pastikan halaman dapat diakses
        $response->assertStatus(200);
        $response->assertViewIs('manajemenkasir');
    }

    // Test untuk memastikan logout berhasil
    public function testLogout()
    {
        // Login terlebih dahulu
        $this->post('/login', [
            'email' => 'admin@example.com',
            'password' => 'password',
        ]);

        // Lakukan logout
        $response = $this->post('/logout');
        
        // Pastikan logout berhasil dengan redirect ke login
        $response->assertRedirect('/login');
        $this->assertFalse(session()->has('user_id'));
        $this->assertFalse(session()->has('user_name'));
    }
}