<?php

use App\Http\Controllers\ChartOfAccountsController;
use App\Http\Controllers\Dashboardcontroller;
use App\Http\Controllers\KategoriCoasController;
use App\Http\Controllers\LaporanController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TransaksisController;
use Illuminate\Support\Facades\Route;
use SebastianBergmann\CodeCoverage\Report\Html\Dashboard;

Route::get('/', function () {
    return view('auth.login');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');


    Route::resource('kategori', KategoriCoasController::class);
    Route::resource('coa', ChartOfAccountsController::class);
    Route::resource('transaksi', TransaksisController::class);
   
     Route::resource('dashboard', Dashboardcontroller::class);
    // routes/web.php
Route::get('/laporan', [LaporanController::class, 'index'])->name('laporan.index');
Route::get('/laporan/export', [LaporanController::class, 'export'])->name('laporan.export');

});


require __DIR__.'/auth.php';
