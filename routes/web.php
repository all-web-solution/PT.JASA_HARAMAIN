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
use App\Http\Controllers\Content\SiskopaturController;
use App\Http\Controllers\Content\VisaController;
use App\Http\Controllers\Content\VaccineController;
use App\Http\Controllers\TransportationController;

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
    Route::post('/payment/store', [PaymentController::class, 'store'])->name('admin.payment.stor');
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
        Route::group(['prefix' => 'handling'], function(){
            Route::get('/',  [App\Http\Controllers\Handling\HandlingController::class, 'index'])->name('handling.handling.index');
        });
        Route::group(['prefix' => 'pendamping'], function(){
            Route::get('/',  [App\Http\Controllers\Handling\PendampingController::class, 'index'])->name('handling.pendamping.index');
            Route::get('/create',  [App\Http\Controllers\Handling\PendampingController::class, 'create'])->name('handling.pendamping.create');
            Route::post('/create',  [App\Http\Controllers\Handling\PendampingController::class, 'store'])->name('handling.pendamping.store');
            Route::get('/edit/{id}',  [App\Http\Controllers\Handling\PendampingController::class, 'edit'])->name('handling.pendamping.edit');
            Route::put('/update/{id}', [App\Http\Controllers\Handling\PendampingController::class,'update'])->name('handling.pendamping.update');
            Route::delete('/delete/{id}', [App\Http\Controllers\Handling\PendampingController::class,'destroy'])->name('handling.pendamping.destroy');
        });
        Route::group(['prefix' => 'tour'], function(){
            Route::get('/',  [App\Http\Controllers\Handling\TourController::class, 'index'])->name('handling.tour.index');
            Route::get('/create',  [App\Http\Controllers\Handling\TourController::class, 'create'])->name('handling.tour.create');
            Route::post('/create',  [App\Http\Controllers\Handling\TourController::class, 'store'])->name('handling.tour.store');
            Route::get('/edit/{id}',  [App\Http\Controllers\Handling\TourController::class, 'edit'])->name('handling.tour.edit');
            Route::put('/update/{id}', [App\Http\Controllers\Handling\TourController::class,'update'])->name('handling.tour.update');
            Route::delete('/delete/{id}', [App\Http\Controllers\Handling\TourController::class,'destroy'])->name('handling.tour.destroy');
        });
    });

   Route::middleware(['auth', 'transportation'])->group(function(){
        Route::group(['prefix' => 'planes'], function(){
           Route::get('/', [TransportationController::class, 'index'])->name('transportation.plane.index');
           Route::get('/create', [TransportationController::class, 'create'])->name('transportation.plane.create');
           Route::post('/create', [TransportationController::class, 'store'])->name('transportation.plane.store');
           Route::get('/edit/{id}', [TransportationController::class, 'edit'])->name('transportation.plane.edit');
           Route::put('/update/{id}', [TransportationController::class, 'update'])->name('transportation.plane.update');
           Route::delete('/delete/{id}', [TransportationController::class, 'delete'])->name('transportation.plane.delete');
        });
        Route::group(['prefix' => 'cars'], function(){
           Route::get('/', [TransportationController::class, 'indexCar'])->name('transportation.car.index');
           Route::get('/create', [TransportationController::class, 'createCar'])->name('transportation.car.create');
           Route::post('/create', [TransportationController::class, 'storeCar'])->name('transportation.car.store');
           Route::get('/edit/{id}', [TransportationController::class, 'editCar'])->name('transportation.car.edit');
           Route::put('/update/{id}', [TransportationController::class, 'updateCar'])->name('transportation.car.update');
           Route::delete('/delete/{id}', [TransportationController::class, 'deleteCar'])->name('transportation.car.delete');
        });
        Route::get('/customer/transportation', [TransportationController::class, 'TransportationCustomer'])->name('transportation.customer');
   });

   Route::middleware(['auth', 'content'])->group(function(){
        Route::group(['prefix' => 'visa'], function(){
            Route::get('/', [VisaController::class, 'index'])->name('content.visa.index');
            Route::get('/create', [VisaController::class, 'create'])->name('content.visa.create');
            Route::post('/create', [VisaController::class, 'store'])->name('content.visa.store');
            Route::get('/edit/{id}', [VisaController::class, 'edit'])->name('content.visa.edit');
            Route::put('/update/{id}', [VisaController::class, 'update'])->name('content.visa.update');
            Route::delete('/delete/{id}', [VisaController::class, 'destroy'])->name('content.visa.destroy');
        });
        Route::group(['prefix' => 'vaccine'], function(){
            Route::get('/', [VaccineController::class, 'index'])->name('content.vaccine.index');
            Route::get('/create', [VaccineController::class, 'create'])->name('content.vaccine.create');
            Route::post('/create', [VaccineController::class, 'store'])->name('content.vaccine.store');
            Route::get('/edit/{id}', [VaccineController::class, 'edit'])->name('content.vaccine.edit');
            Route::put('/update/{id}', [VaccineController::class, 'update'])->name('content.vaccine.update');
            Route::delete('/delete/{id}', [VaccineController::class, 'destroy'])->name('content.vaccine.destroy');
        });
        Route::group(['prefix' => 'siskopatur'], function(){
            Route::get('/', [SiskopaturController::class, 'index'])->name('content.siskopatur.index');
            Route::get('/create', [SiskopaturController::class, 'create'])->name('content.siskopatur.create');
            Route::post('/create', [SiskopaturController::class, 'store'])->name('content.siskopatur.store');
            Route::get('/edit/{id}', [SiskopaturController::class, 'edit'])->name('content.siskopatur.edit');
            Route::put('/update/{id}', [SiskopaturController::class, 'update'])->name('content.siskopatur.update');
            Route::delete('/delete/{id}', [SiskopaturController::class, 'destroy'])->name('content.siskopatur.destroy');
        });
   });


Route::group(['middleware' => 'guest'], function(){
    Route::get('admin/login', function(){return view('admin.auth.login');})->name('login');
    Route::post('/sign-in', [AuthController::class, 'sign_in'])->name('sign_in');
});

Route::post('/sign-out', [AuthController::class, 'sign_out'])->name('sign_out');
