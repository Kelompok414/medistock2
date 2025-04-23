<?php

namespace App\Http\Controllers;

use App\Models\LaporanKasir;
use Illuminate\Http\Request;

class LaporanKasirController extends Controller
{
    public function dashboard()
    {
        try {
            $laporan = LaporanKasir::firstOrFail();
            return view('dashboard', compact('laporan'));
        } catch (\Exception $e) {
            return redirect()->route('laporan-kasir.create')
                ->with('error', 'Silakan buat laporan pertama Anda');
        }
    }

    public function index()
    {
        $laporan = LaporanKasir::first();
        return view('laporan-kasir.index', compact('laporan'));
    }

    // ... (method create dan store tetap sama)

    public function edit(LaporanKasir $laporanKasir)
    {
        return view('laporan-kasir.edit', compact('laporanKasir'));
    }

    // ... (method update tetap sama)

    public function create()
{
    // bisa return view ke form
    return view('laporan-kasir.create');
}
public function store(Request $request)
{
    // Validasi data input
    $validatedData = $request->validate([
        'field1' => 'required',
        'field2' => 'required|numeric',
        // sesuaikan dengan field yang dibutuhkan
    ]);

    // Simpan data ke database
    LaporanKasir::create($validatedData);

    // Redirect dengan pesan sukses
    return redirect()->route('laporan_kasir.index')
                     ->with('success', 'Data berhasil disimpan');
}

}