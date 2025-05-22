<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class KasirController extends Controller
{
    public function showRegisterKasir()
    {
        return view('registerkasir');
    }

    public function registerKasir(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:8|confirmed',
        ]);

        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
        ]);

        // assign role secara permission
        $user->assignRole('kasir');

        return redirect()->back()->with('success', 'Kasir berhasil diregistrasi.');
    }

    public function kasirDashboard()
{
    // Pastikan user sudah login
    if (!Auth::check()) {
        return redirect('/login')->with('error', 'Silakan login terlebih dahulu.');
    }

    // Cek apakah user punya role kasir
    // if (!Auth::user()->hasRole('kasir')) {
    //     return redirect('/')->with('error', 'Kamu tidak punya akses ke halaman ini.');
    // }

    // Jika role kasir, tampilkan halaman dashboard kasir
    return view('kasir.dashboard', [
        'name' => Auth::user()->name,
        'role' => 'kasir',
    ]);
}
}
