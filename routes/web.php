<?php

use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\PelangganController;
use App\Http\Controllers\Admin\ServicesController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\HotelController;
use App\Http\Controllers\UserController;
use App\Models\Hotel;
use Illuminate\Support\Facades\Route;
use SebastianBergmann\CodeCoverage\Report\Html\Dashboard;
use App\Http\Controllers\Admin\OrderController;
use App\Http\Controllers\Admin\PaymentController;

Route::middleware(['auth', 'admin'])->group(function () {
    Route::get('/', [DashboardController::class, 'index'])->name('admin.index');
    Route::get('/admin/services', [ServicesController::class, 'index'])->name('admin.services');
    Route::get('/services/create', [ServicesController::class, 'create'])->name('services.create');
    Route::get('/admin/pelanggan', [PelangganController::class, 'index'])->name('admin.pelanggan');
    Route::get('/pelanggan/create', [PelangganController::class, 'create'])->name('admin.pelanggan.create');
    Route::post('/pelanggan', [PelangganController::class, 'store'])->name('admin.pelanggan.store');
    Route::get('/pelanggan/{pelanggan}/edit', [PelangganController::class, 'edit'])->name('admin.pelanggan.edit');
    Route::put('/pelanggan/{pelanggan}', [PelangganController::class, 'update'])->name('admin.pelanggan.update');
    Route::delete('/pelanggan/{pelanggan}', [PelangganController::class, 'destroy'])->name('admin.pelanggan.destroy');
    Route::post('/services', [ServicesController::class, 'store'])->name('services.store');
    Route::get('/users', [UserController::class, 'index'])->name('user.index');
    Route::get('/users/create', [UserController::class, 'create'])->name('user.create');
    Route::post('/users', [UserController::class, 'store'])->name('user.store');
    Route::get('/user/{id}/edit', [UserController::class, 'edit'])->name('user.edit');
    Route::put('/user/{id}', [UserController::class, 'update'])->name('user.update');
    Route::delete('/user/{id}', [UserController::class, 'destroy'])->name('user.destroy');
    Route::get('/order', [OrderController::class, 'index'])->name('admin.order');
    Route::get('/order/create', [OrderController::class, 'create'])->name('admin.order.create');
    Route::post('/order', [OrderController::class, 'store'])->name('order.store');
    Route::get('/order/{id}', [OrderController::class, 'edit'])->name('admin.order.show');
    Route::put('/order/{id}', [OrderController::class, 'update'])->name('admin.order.update');
    Route::delete('/order/{id}', [OrderController::class, 'destroy'])->name('admin.order.destroy');
    Route::get('/payment', [PaymentController::class, 'index'])->name('admin.payment');
    Route::get('/payment/create', [PaymentController::class, 'create'])->name('admin.payment.create');
});

Route::middleware(['auth', 'hotel'])->group(function () {
    Route::get('/hotel', [HotelController::class, 'index'])->name('hotel.index');
    Route::get('/hotel/create', [HotelController::class, 'create'])->name('hotel.create');
    Route::post('/hotel', [HotelController::class, 'store'])->name('hotel.store');
    Route::get('hotel/{id}', [HotelController::class, 'edit'])->name('hotel.edit');
    Route::put('hotel/{id}/update', [HotelController::class, 'update'])->name('hotel.update');
    Route::delete('hotel/{id}/delete', [HotelController::class, 'destroy'])->name('hotel.destroy');
});
    Route::middleware(['auth', 'handling'])->group(function () {
        Route::group(['prefix' => 'catering',], function() {
            Route::get('/', [App\Http\Controllers\Handling\CateringController::class, 'index'])->name('catering.index');
            Route::get('/create', [App\Http\Controllers\Handling\CateringController::class, 'create'])->name('catering.create');
            Route::post('/', [App\Http\Controllers\Handling\CateringController::class, 'store'])->name('catering.store');
            Route::get('/{id}', [App\Http\Controllers\Handling\CateringController::class, 'show'])->name('catering.show');
            Route::get('/{id}/edit', [App\Http\Controllers\Handling\CateringController::class, 'edit'])->name('catering.edit');
            Route::put('update/{id}', [App\Http\Controllers\Handling\CateringController::class, 'update'])->name('catering.update');
            Route::delete('/delete/{id}', [App\Http\Controllers\Handling\CateringController::class, 'destroy'])->name('catering.delete');
        });
    });


Route::group(['middleware' => 'guest'], function(){
    Route::get('admin/login', function(){return view('admin.auth.login');})->name('login');
    Route::post('/sign-in', [AuthController::class, 'sign_in'])->name('sign_in');
});

Route::post('/sign-out', [AuthController::class, 'sign_out'])->name('sign_out');
