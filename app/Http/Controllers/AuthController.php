<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    // Menampilkan form login
    public function form()
    {
        return view('auth.login');
    }

    // Proses login
    public function login(Request $request)
    {
        $validated = $request->validate([
            'email' => 'required|email',
            'password' => 'required|string',
        ]);

        $user = User::where('email', $validated['email'])->first();

        if ($user && Hash::check($validated['password'], $user->password)) {
            // Simpan session jika login berhasil
            session([
                'user_id' => $user->id,
                'user_name' => $user->name,
            ]);

            // Redirect berdasarkan role
            if ($user->hasRole('admin')) {
                return redirect('/dashboard');
            } elseif ($user->hasRole('kasir')) {
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

        return view('dashboard', [
            'name' => session('user_name'),
            'role' => session('user_role'),
        ]);
    }

    // Menampilkan halaman dashboard kasir
    public function kasirDashboard()
    {
        // Cek apakah session user sudah ada
        if (!session()->has('user_id')) {
            return redirect('/login')->with('error', 'Silakan login terlebih dahulu.');
        }

        return view('kasir-dashboard', [
            'name' => session('user_name'),
            'role' => session('user_role'),
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

