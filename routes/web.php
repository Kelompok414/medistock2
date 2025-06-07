<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\KasirController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\AnalyticsController;
use App\Http\Controllers\MedicineController;
use App\Http\Controllers\ReportCashierController;

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
Route::get('/produkkadaluarsa', [NotificationController::class, 'index'])->name('notifikasi.produkkadaluarsa');
Route::get('/produkhabis', [NotificationController::class, 'index'])->name('notifikasi.produkhabis');
Route::get('/produkakankadaluarsa', [NotificationController::class, 'index'])->name('notifikasi.produkakankadaluarsa');

Route::resource('transactions', TransactionController::class);

// reports admin
Route::prefix('reports')->group(function () {
    Route::get('/weekly', [ReportController::class, 'weekly'])->name('reports.weekly');
    Route::get('/monthly', [ReportController::class, 'monthly'])->name('reports.monthly');
    Route::get('/annual', [ReportController::class, 'annual'])->name('reports.annual');
});

Route::get('reports/weekly/export', [ReportController::class, 'exportWeekly'])->name('reports.weekly.export');
Route::get('reports/monthly/export', [ReportController::class, 'exportMonthly'])->name('reports.monthly.export');
Route::get('reports/annual/export', [ReportController::class, 'exportAnnual'])->name('reports.annual.export');

Route::get('/analytics', [AnalyticsController::class, 'index'])->name('analytics.index');
Route::get('/analytics/trend/{range}', [AnalyticsController::class, 'getTrend']);

// reports kasir
Route::get('/reports-cashier/weekly', [ReportCashierController::class, 'weekly'])->name('reports-cashier.weekly');
Route::get('/reports-cashier/monthly', [ReportCashierController::class, 'monthly'])->name('reports-cashier.monthly');
Route::get('/reports-cashier/annual', [ReportCashierController::class, 'annual'])->name('reports-cashier.annual');
// Route untuk halaman inventaris
Route::get('/inventory', [MedicineController::class, 'index'])->name('inventory.index');
Route::get('/inventory/create', [MedicineController::class, 'create'])->name('inventory.create');
Route::post('/inventory', [MedicineController::class, 'store'])->name('inventory.store');
Route::get('/inventory/{medicine}/edit', [MedicineController::class, 'edit'])->name('inventory.edit');
Route::put('/inventory/{medicine}', [MedicineController::class, 'update'])->name('inventory.update');
Route::delete('/inventory/{medicine}', [MedicineController::class, 'destroy'])->name('inventory.destroy');