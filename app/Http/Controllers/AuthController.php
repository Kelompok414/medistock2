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
        $validated = $request->validate([
            'email' => 'required|email',
            'password' => 'required|string',
        ]);

        $user = User::where('email', $validated['email'])->first();

        if ($user && Hash::check($validated['password'], $user->password)) {

            // Redirect berdasarkan role
            if ($user->hasRole('admin')) {
                session([
                    'user_id' => $user->id,
                    'user_name' => $user->name,
                    'role' => 'admin'
                ]);
                return redirect('/dashboard');
            } else if ($user->hasRole('kasir')) {
                session([
                    'user_id' => $user->id,
                    'user_name' => $user->name,
                    'role' => 'kasir'
                ]);
                return redirect('/kasir-dashboard');
            }
        }

        // Jika login gagal
        return back()->with('error', 'Email atau password salah.');
    }

    // Menampilkan halaman dashboard admin
    public function dashboard()
    {
        // Cek apakah session user sudah ada
        if (!session()->has('user_id')) {
            return redirect('/login')->with('error', 'Silakan login terlebih dahulu.');
        }

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
        if (!session()->has('user_id')) {
            return redirect('/login')->with('error', 'Silakan login terlebih dahulu.');
        }

        // Ambil user dari session
        $user = \App\Models\User::find(session('user_id'));

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
        session()->flush();
        return redirect('/login')->with('success', 'Berhasil logout.');
    }

    public function notifikasi()
    {
        // Cek apakah user sudah login
        if (!session()->has('user_id')) {
            return redirect('/login')->with('error', 'Silakan login terlebih dahulu.');
        }

        // Ambil user berdasarkan ID dari session
        $user = User::find(session('user_id'));

        // Cek apakah user punya role admin atau kasir
        if (!$user || !$user->hasAnyRole(['admin', 'kasir'])) {
            abort(403, 'Akses ditolak.');
        }

        // Jika lolos, tampilkan halaman
        return view('notifikasi', [
            'name' => $user->name,
            'role' => $user->getRoleNames()->first(), // atau session('user_role') jika disimpan manual
        ]);
    }
}
