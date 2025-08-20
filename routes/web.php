<?php

use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\PelangganController;
use App\Http\Controllers\Admin\ServicesController;
use Illuminate\Support\Facades\Route;
use SebastianBergmann\CodeCoverage\Report\Html\Dashboard;

Route::get('/', function () {
    return view('admin.dashboard');
});

Route::get('/admin/services', [ServicesController::class, 'index'])->name('admin.services');
Route::get('/services/create', [ServicesController::class, 'create'])->name('services.create');

//pelanggan routes
Route::get('/admin/pelanggan', [PelangganController::class, 'index'])->name('admin.pelanggan');
Route::get('/pelanggan/create', [PelangganController::class, 'create'])->name('admin.pelanggan.create');
Route::post('/pelanggan', [PelangganController::class, 'store'])->name('admin.pelanggan.store');
Route::get('/pelanggan/{pelanggan}/edit', [PelangganController::class, 'edit'])->name('admin.pelanggan.edit');
Route::put('/pelanggan/{pelanggan}', [PelangganController::class, 'update'])->name('admin.pelanggan.update');
Route::delete('/pelanggan/{pelanggan}', [PelangganController::class, 'destroy'])->name('admin.pelanggan.destroy');
