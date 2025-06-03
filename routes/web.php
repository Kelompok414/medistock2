<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\KasirController;

route::get('/login', function () {
    return view('auth.role-selector');
})->name('login');

// Route for Admin Login
Route::get('/admin/login', [AuthController::class, 'showAdminLogin'])->name('admin.login');
Route::post('/admin/login', [AuthController::class, 'login'])->name('login');

// Route for Kasir Login
Route::get('/kasir/login', [AuthController::class, 'showKasirLogin'])->name('kasir.auth.login');
Route::post('/kasir/login', [AuthController::class, 'login'])->name('kasir.login');

// Route for Authenticated Users
Route::middleware('auth')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'admin'])->name('dashboard');

    Route::get('/kasir-dashboard', [AuthController::class, 'kasirDashboard'])->name('kasir.dashboard');

    Route::get('/expiring-medications', [App\Http\Controllers\DashboardController::class, 'expiringMedications'])->name('expiring.medications');

    Route::get('/manajemen-kasir', function () {
        return view('admin.manajemenkasir');
    })->name('manajemen.kasir');

    Route::get('/manajemen-kasir', [DashboardController::class, 'showManajemenKasir'])->name('manajemen.kasir');

    Route::get('/register-kasir', [DashboardController::class, 'showRegisterKasir'])->name('register.kasir');

    Route::post('/register-kasir', [DashboardController::class, 'registerKasir'])->name('store.kasir');

    Route::get('/update-kasir/{id}', [DashboardController::class, 'showUpdateKasir'])->name('update.kasir');

    Route::put('/update-kasir/{id}', [DashboardController::class, 'updateKasir'])->name('update.kasir');

    Route::delete('/delete-kasir/{id}', [DashboardController::class, 'deleteKasir'])->name('delete.kasir');
});
