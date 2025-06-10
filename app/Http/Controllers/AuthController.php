<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Saleitem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function form()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required|string',
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate(); // menghindari session fixation

            // Ambil user yang login
            $user = Auth::user();

            // Redirect berdasarkan role
            if ($user->hasRole('admin')) {
                return redirect('/dashboard');
            } else if ($user->hasRole('kasir')) {
                return redirect('/kasir-dashboard');
            }

            // default redirect kalau tidak punya role
            return redirect('/');
        }

        // Jika login gagal
        return back()->withErrors([
            'email' => 'Email atau password salah.',
        ]);
    }


    // Menampilkan halaman dashboard admin
    public function dashboard()
    {
        // Cek apakah session user sudah ada
        if (!Auth::check()) {
            return redirect('/login')->with('error', 'Silakan login terlebih dahulu.');
        }

        // Ambil user dari session
        // $user = Auth::user();

        // get data dummy
        $dashboardData = app('App\Http\Controllers\DashboardController')->admin();

        // Gabungkan data session dengan data dummy
        $data = array_merge($dashboardData, [
            'name' => session('user_name'),
            'role' => session('user_role'),
        ]);

        // Kirim data ke view dashboard.blade.php
        return view('dashboard', $data);
    }


    public function kasirDashboard()
    {
        // Cek apakah session user sudah ada
        if (!Auth::check()) {
            return redirect('/login')->with('error', 'Silakan login terlebih dahulu.');
        }

        // Ambil user dari session
        $user = Auth::user();

        // Data statistik kasir (ganti sesuai struktur tabelmu)
        $totalSales = \App\Models\Transaction::sum('total_price');
        $totalSoldDrugs = Saleitem::sum('quantity');
        $totalTransactions = \App\Models\Transaction::count();
        $transactions = \App\Models\Transaction::latest()->take(10)->get();

        return view('kasir-dashboard', [
            'name' => $user->name,
            'role' => $user->getRoleNames()->first(), // atau session('user_role')
            'totalSales' => $totalSales,
            'totalSoldDrugs' => $totalSoldDrugs,
            'totalTransactions' => $totalTransactions,
            'transactions' => $transactions,
        ]);
    }

    // Logout dan hapus session
    public function logout()
    {
        Auth::logout(); // ini penting
        session()->flush(); // kalau kamu ingin benar-benar menghapus semua session
        return redirect('/login')->with('success', 'Berhasil logout.');
    }


    public function notifikasi()
    {
        // Cek apakah user sudah login
        if (!Auth::check()) {
            return redirect('/login')->with('error', 'Silakan login terlebih dahulu.');
        }

        // Ambil user dari session
        $user = Auth::user();

        // Cek apakah user punya role admin atau kasir
        if (!$user || !$user->hasAnyRole(['admin', 'kasir'])) {
            abort(403, 'Akses ditolak.');
        }
    }
}
