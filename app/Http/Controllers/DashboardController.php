<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        if (Auth::check()) {
            return view('dashboard');
        }

        return redirect()->route('login');
    }

    // Menampilkan dashboard admin
    public function admin()
    {
        // Data dummy untuk dashboard admin
        $data = [
            'totalObat' => 1245,
            'akanKadaluarsa' => 48,
            'kadaluarsa' => 12,
            'stokMenipis' => 32,
            'pengingatKadaluarsa' => [
                ['nama' => 'Paracetamol 500mg', 'batch' => 'B12345', 'tanggal_kadaluarsa' => '05 Jun 2025', 'sisa_hari' => 89, 'stok' => '145 Tablet', 'status' => 'Akan Kadaluarsa'],
                ['nama' => 'Amoxicillin 500mg', 'batch' => 'B23456', 'tanggal_kadaluarsa' => '20 Mei 2025', 'sisa_hari' => 73, 'stok' => '76 Tablet', 'status' => 'Akan Kadaluarsa'],
                ['nama' => 'Cetirizine 10mg', 'batch' => 'B34567', 'tanggal_kadaluarsa' => '15 Feb 2025', 'sisa_hari' => -22, 'stok' => '30 Tablet', 'status' => 'Kadaluarsa'],
                ['nama' => 'Simvastatin 20mg', 'batch' => 'B45678', 'tanggal_kadaluarsa' => '12 Agu 2025', 'sisa_hari' => 157, 'stok' => '50 Tablet', 'status' => 'Tersedia'],
                ['nama' => 'Metformin 500mg', 'batch' => 'B56789', 'tanggal_kadaluarsa' => '25 Jul 2025', 'sisa_hari' => 139, 'stok' => '120 Tablet', 'status' => 'Tersedia'],
                ['nama' => 'Ibuprofen 400mg', 'batch' => 'B67890', 'tanggal_kadaluarsa' => '10 Apr 2025', 'sisa_hari' => 33, 'stok' => '87 Tablet', 'status' => 'Akan Kadaluarsa'],
                ['nama' => 'Vitamin C 500mg', 'batch' => 'B78901', 'tanggal_kadaluarsa' => '02 Mar 2025', 'sisa_hari' => -6, 'stok' => '25 Tablet', 'status' => 'Kadaluarsa'],
            ],
            'notifikasiTerbaru' => [
                ['pesan' => 'Vitamin C 500mg Telah Kadaluarsa', 'tanggal' => '21 Maret 2025'],
                ['pesan' => 'Cetirizine 10mg Telah Kadaluarsa', 'tanggal' => '21 Maret 2025'],
                ['pesan' => 'Laporan Bulanan Sudah Tersedia', 'tanggal' => '1 Maret 2025'],
                ['pesan' => 'Paracetamol 500mg Akan Kadaluarsa', 'tanggal' => '23 Februari 2025'],
                ['pesan' => 'Amoxicillin 500mg Akan Kadaluarsa', 'tanggal' => '21 Februari 2025'],
            ],
        ];

        // Kembalikan data dummy
        return $data;
    }
}