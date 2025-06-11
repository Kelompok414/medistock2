<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Models\Batch;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

class NotificationController extends Controller
{
    public function index()
    {
        if (!Auth::check()) {
            return redirect('/login')->with('error', 'Silakan login terlebih dahulu.');
        }

        $route = Route::currentRouteName(); // Mengambil nama rute saat ini (untuk menentukan tampilan apa yang dipanggil)

        $today = Carbon::today(); // Tanggal hari ini
        $nextMonth = $today->copy()->addMonth(); // Tanggal satu bulan ke depan

        // Ambil semua batch yang SUDAH KADALUARSA (expired)
        $expiredBatches = Batch::with('medicine') // ikut ambil relasi data obat
            ->where('expiry_date', '<', $today)
            ->get();

        // Ambil semua batch yang MENDEKATI KADALUARSA (antara hari ini hingga sebulan ke depan)
        $nearExpiredBatches = Batch::with('medicine')
            ->whereBetween('expiry_date', [$today, $nextMonth])
            ->get();

        // Ambil semua batch yang HABIS (quantity ≤ 0)
        $emptyBatches = Batch::with('medicine')
            ->where('quantity', '<=', 0)
            ->get();

        // Menentukan tampilan mana yang akan ditampilkan berdasarkan route yang diakses
        if ($route === 'notifikasi.produkkadaluarsa') {
            // Jika route saat ini adalah 'produkkadaluarsa', tampilkan hanya produk yang sudah expired
            return view('notifikasi.produkkadaluarsa', [
                'expiredBatches' => $expiredBatches,
            ]);
        } elseif ($route === 'notifikasi.produkhabis') {
            // Jika route saat ini adalah 'produkhabis', tampilkan hanya produk yang habis stok
            return view('notifikasi.produkhabis', [
                'emptyBatches' => $emptyBatches,
            ]);
        } elseif ($route === 'notifikasi.produkakankadaluarsa') {
            // Jika route saat ini adalah 'produkhabis', tampilkan hanya produk yang habis stok
            return view('notifikasi.produkakankadaluarsa', [
                'nearExpiredBatches' => $nearExpiredBatches,
            ]);
        } else { // default: route 'notifikasi'
            // Jika route default (notifikasi), tampilkan semua kategori notifikasi
            return view('notifikasi.notifikasi', [
                'expiredBatches' => $expiredBatches,
                'nearExpiredBatches' => $nearExpiredBatches,
                'emptyBatches' => $emptyBatches,
            ]);
        }
    }
}
