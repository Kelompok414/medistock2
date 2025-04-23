<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserSettingController;

Route::get('/user-setting', [UserSettingController::class, 'index'])->name('user-setting.index');
Route::post('/user-setting/update/{id}', [UserSettingController::class, 'update'])->name('user-setting.update');
Route::get('/', function () {
    return view('welcome'); 
});
