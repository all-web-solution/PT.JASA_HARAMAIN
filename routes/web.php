<?php

use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\PelangganController;
use App\Http\Controllers\Admin\ServicesController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;
use SebastianBergmann\CodeCoverage\Report\Html\Dashboard;

Route::middleware(['auth','role:admin'])->group(function () {
    Route::get('/admin/services', [ServicesController::class, 'index'])->name('admin.services');
    Route::get('/services/create', [ServicesController::class, 'create'])->name('services.create');
    Route::get('/admin/pelanggan', [PelangganController::class, 'index'])->name('admin.pelanggan');
    Route::get('/pelanggan/create', [PelangganController::class, 'create'])->name('admin.pelanggan.create');
    Route::post('/pelanggan', [PelangganController::class, 'store'])->name('admin.pelanggan.store');
    Route::get('/pelanggan/{pelanggan}/edit', [PelangganController::class, 'edit'])->name('admin.pelanggan.edit');
    Route::put('/pelanggan/{pelanggan}', [PelangganController::class, 'update'])->name('admin.pelanggan.update');
    Route::delete('/pelanggan/{pelanggan}', [PelangganController::class, 'destroy'])->name('admin.pelanggan.destroy');
    Route::get('/', function () {return view('admin.dashboard');})->name('admin.index');
    Route::post('/services', [ServicesController::class, 'store'])->name('services.store');
    Route::get('/users', [UserController::class, 'index'])->name('user.index');
    Route::get('/users/create', [UserController::class, 'create'])->name('user.create');
    Route::post('/users', [UserController::class, 'store'])->name('user.store');
    Route::get('/user/{id}/edit', [UserController::class, 'edit'])->name('user.edit');
    Route::put('/user/{id}', [UserController::class, 'update'])->name('user.update');
    Route::delete('/user/{id}', [UserController::class, 'destroy'])->name('user.destroy');
});
Route::middleware(['auth', 'role:hotel'])->group(function () {
    Route::get('/',function(){
        return "Assalamualaikum Hotel";
    })->name('admin.services');
});
Route::middleware(['auth', 'role:hotel'])->group(function () {
    Route::get('/',function(){
        return "Assalamualaikum Hotel";
    })->name('admin.services');
});
Route::middleware(['auth', 'role:transportasi & tiket'])->group(function () {
    Route::get('/',function(){
        return "Assalamualaikum Hotel";
    })->name('admin.services');
});
Route::middleware(['auth', 'role:visa & acara'])->group(function () {
    Route::get('/',function(){
        return "Assalamualaikum Hotel";
    })->name('admin.services');
});
Route::middleware(['auth', 'role:reyal'])->group(function () {
    Route::get('/',function(){
        return "Assalamualaikum Hotel";
    })->name('admin.services');
});
Route::middleware(['auth', 'role:palugada'])->group(function () {
    Route::get('/',function(){
        return "Assalamualaikum Hotel";
    })->name('admin.services');
});
Route::middleware(['auth', 'role:konten & dokumentasi'])->group(function () {
    Route::get('/',function(){
        return "Assalamualaikum Hotel";
    })->name('admin.services');
});


Route::group(['middleware' => 'guest'], function(){
    Route::get('admin/login', function(){return view('admin.auth.login');})->name('login');
    Route::post('/sign-in', [AuthController::class, 'sign_in'])->name('sign_in');
});

Route::post('/sign-out', [AuthController::class, 'sign_out'])->name('sign_out');
