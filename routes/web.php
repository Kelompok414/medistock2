<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\KasirController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\ReportController;

Route::get('/', function () {
    return view('welcome');
});

//login
Route::get('/login', [AuthController::class, 'form'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Rute Dashboard
Route::get('/dashboard', [AuthController::class, 'dashboard'])->name('dashboard'); // Admin Dashboard
Route::get('/kasir-dashboard', [AuthController::class, 'kasirDashboard'])->name('kasir.dashboard'); // Kasir Dashboard

Route::get('/expiring-medications', [App\Http\Controllers\DashboardController::class, 'expiringMedications'])
    ->name('expiring.medications');


Route::get('/manajemen-kasir', function () {
    return view('manajemenkasir');
})->name('manajemen.kasir');

//register kasir
Route::get('/register-kasir', [KasirController::class, 'showRegisterKasir'])->name('registerkasir');
Route::post('/register-kasir', [KasirController::class, 'registerKasir'])->name('register.kasir');

//notifikasi
Route::get('/notifikasi', [NotificationController::class, 'index'])->name('notifikasi');
Route::get('/produkkadaluarsa', [NotificationController::class, 'index'])->name('produkkadaluarsa');
Route::get('/produkhabis', [NotificationController::class, 'index'])->name('produkhabis');
Route::get('/laporanbulanan', [NotificationController::class, 'index'])->name('laporanbulanan');

Route::resource('transactions', TransactionController::class);

Route::prefix('reports')->group(function () {
    Route::get('/weekly', [ReportController::class, 'weekly'])->name('reports.weekly');
    Route::get('/monthly', [ReportController::class, 'monthly'])->name('reports.monthly');
    Route::get('/annual', [ReportController::class, 'annual'])->name('reports.annual');
});

Route::get('reports/weekly/export', [ReportController::class, 'exportWeekly'])->name('reports.weekly.export');
Route::get('reports/monthly/export', [ReportController::class, 'exportMonthly'])->name('reports.monthly.export');
Route::get('reports/annual/export', [ReportController::class, 'exportAnnual'])->name('reports.annual.export');
