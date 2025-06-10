<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\KasirController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\AnalyticsController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\MedicineController;
use App\Http\Controllers\ReportCashierController;
use App\Http\Controllers\SettingController;
use App\Http\Controllers\ProfileController;

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

Route::get('/transactions', [TransactionController::class, 'index'])->name('transactions.index');
Route::get('/transactions/create', [TransactionController::class, 'create'])->name('transactions.create');
Route::post('/transactions', [TransactionController::class, 'store'])->name('transactions.store');
Route::get('/transactions/{transaction}/edit', [TransactionController::class, 'edit'])->name('transactions.edit');
Route::put('/transactions/{transaction}', [TransactionController::class, 'update'])->name('transactions.update');
Route::delete('/transactions/{transaction}', [TransactionController::class, 'destroy'])->name('transactions.destroy');

Route::get('/categories', [CategoryController::class, 'index'])->name('categories.index');
Route::get('/categories/create', [CategoryController::class, 'create'])->name('categories.create');
Route::post('/categories', [CategoryController::class, 'store'])->name('categories.store');
Route::get('/categories/{category}/edit', [CategoryController::class, 'edit'])->name('categories.edit');
Route::put('/categories/{category}', [CategoryController::class, 'update'])->name('categories.update');
Route::delete('/categories/{category}', [CategoryController::class, 'destroy'])->name('categories.destroy');

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

Route::get('medicine/detail/{id}', [MedicineController::class, 'detail'])->name('medicine.detail');
Route::put('medicine/detail/description/{id}', [MedicineController::class, 'updateDescription'])->name('medicine.update.detail');

Route::get('/user-setting', [ProfileController::class, 'index'])->name('user-setting.index');
Route::put('/user-setting/update', [ProfileController::class, 'update'])->name('profile.update');

//tampilan
Route::get('/user-setting/display', [SettingController::class, 'index'])->name('user-setting.display');
Route::post('/user-setting/display/update', [SettingController::class, 'update'])->name('user-setting.display.update');
