<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ManagemenKasirController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/managemen_kasir', [ManagemenKasirController::class, 'index'])->name('managemen_kasir');
Route::post('/managemen_kasir', [ManagemenKasirController::class, 'store'])->name('managemen_kasir.store');
Route::put('/managemen_kasir/{id}', [ManagemenKasirController::class, 'update'])->name('managemen_kasir.update');
Route::delete('/managemen_kasir/{id}', [ManagemenKasirController::class, 'destroy'])->name('managemen_kasir.destroy');

Route::get('/managemen_kasir/create', [ManagemenKasirController::class, 'view_create'])->name('managemen_kasir_create_view');
Route::get('/managemen_kasir/update/{id}', [ManagemenKasirController::class, 'view_edit'])->name('managemen_kasir_update_view');