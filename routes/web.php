<?php

use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\PelangganController;
use App\Http\Controllers\Admin\ServicesController;
use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;
use SebastianBergmann\CodeCoverage\Report\Html\Dashboard;


Route::group(['middleware' => 'auth'], function(){
    Route::get('/admin/services', [ServicesController::class, 'index'])->name('admin.services');
    Route::get('/services/create', [ServicesController::class, 'create'])->name('services.create');
    //pelanggan routes
    Route::get('/admin/pelanggan', [PelangganController::class, 'index'])->name('admin.pelanggan');
    Route::get('/pelanggan/create', [PelangganController::class, 'create'])->name('admin.pelanggan.create');
    Route::post('/pelanggan', [PelangganController::class, 'store'])->name('admin.pelanggan.store');
    Route::get('/pelanggan/{pelanggan}/edit', [PelangganController::class, 'edit'])->name('admin.pelanggan.edit');
    Route::put('/pelanggan/{pelanggan}', [PelangganController::class, 'update'])->name('admin.pelanggan.update');
    Route::delete('/pelanggan/{pelanggan}', [PelangganController::class, 'destroy'])->name('admin.pelanggan.destroy');
    Route::get('/', function () {return view('admin.dashboard');})->name('admin.index');
    Route::post('/services', [ServicesController::class, 'store'])->name('services.store');
    Route::get('/users', function(){
        return view('admin.users.index');
    })->name('user.index');
    Route::get('/users/create', function(){
        return view('admin.users.create');
    })->name('user.create');
});


Route::group(['middleware' => 'guest'], function(){
    Route::get('admin/login', function(){return view('admin.auth.login');})->name('login');
    Route::post('/sign-in', [AuthController::class, 'sign_in'])->name('sign_in');
});

Route::post('/sign-out', [AuthController::class, 'sign_out'])->name('sign_out');
