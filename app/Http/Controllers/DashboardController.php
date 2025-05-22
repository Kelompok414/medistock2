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

    public function admin()
    {
        if (Auth::check()) {
            // Pastikan hanya user dengan role admin yang bisa mengakses
            if (Auth::user()->role == 'admin') {
                return view('admin.dashboard');
            }

            return redirect()->route('dashboard');
        }

        return redirect()->route('login');
    }
}
