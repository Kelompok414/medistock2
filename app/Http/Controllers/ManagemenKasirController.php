<?php

namespace App\Http\Controllers;

use App\Models\ManagemenKasir;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class ManagemenKasirController extends Controller
{
    // Menampilkan daftar pengguna
    public function index()
    {
        $users = ManagemenKasir::all();
        return view('admin/managemen_kasir', ['users' => $users]);
    }
    public function view_create()
    {
        return view('admin/managemen_kasir_create');
    }
    // Menyimpan pengguna baru
    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required',
            'role' => 'required',
            'no_telepon' => 'required',
            'email' => 'required|email|unique:managemen_kasirs',
            'username' => 'required|unique:managemen_kasirs',
            'password' => 'required|min:6',
        ]);
        
        ManagemenKasir::create([
            'nama' => $request->nama,
            'role' => $request->role,
            'no_telepon' => $request->no_telepon,
            'email' => $request->email,
            'username' => $request->username,
            'password' => Hash::make($request->password),
        ]);

        return redirect()->route('managemen_kasir')->with('success', 'Pengguna berhasil ditambahkan');
    }

    public function view_edit(Request $request, $id)
    {
        $user = ManagemenKasir::findOrFail($id);
        return view('admin/managemen_kasir_edit',['user' => $user]);
    }

    // Memperbarui pengguna
    public function update(Request $request, $id)
    {
        $user = ManagemenKasir::findOrFail($id);

        $request->validate([
            'nama' => 'required',
            'role' => 'required',
            'no_telepon' => 'required',
            'email' => 'required|email|unique:managemen_kasirs,email,' . $id,
            'username' => 'required|unique:managemen_kasirs,username,' . $id,
        ]);

        $user->update([
            'nama' => $request->nama,
            'role' => $request->role,
            'email' => $request->email,
            'no_telepon' => $request->no_telepon,
            'username' => $request->username,
            'password' => $request->password ? Hash::make($request->password) : $user->password,
        ]);

        return redirect()->route('managemen_kasir')->with('success', 'Pengguna berhasil ditambahkan');
    }

    // Menghapus pengguna
    public function destroy($id)
    {
        $user = ManagemenKasir::findOrFail($id);
        $user->delete();

        return redirect()->back()->with('success', 'Pengguna berhasil dihapus');
    }
}