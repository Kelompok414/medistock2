<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use Illuminate\Pagination\Paginator;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Paginator::useBootstrap();
        
        // Tambah route redirect dashboard berdasarkan role
        Route::get('/dashboard', function () {
            $user = Auth::user();

            // Jika belum login, redirect ke login
            if (!$user) {
                return redirect('/login');
            }

            // Redirect berdasarkan role
            if ($user->role === 'admin') {
                return redirect('/dashboard/admin');
            } elseif ($user->role === 'cashier') {
                return redirect('/dashboard/cashier');
            }

            // Jika role tidak dikenali
            return redirect('/');
        });
    }
}
