<?php

use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\PelangganController;
use App\Http\Controllers\Admin\ServicesController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ContentController;
use App\Http\Controllers\DoronganController;
use App\Http\Controllers\HotelController;
use App\Http\Controllers\RouteController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\WakafController;
use App\Models\Hotel;
use Illuminate\Routing\RouteGroup;
use Illuminate\Support\Facades\Route;
use SebastianBergmann\CodeCoverage\Report\Html\Dashboard;
use App\Http\Controllers\Admin\OrderController;
use App\Http\Controllers\Admin\PaymentController;
use App\Http\Controllers\Content\SiskopaturController;
use App\Http\Controllers\Content\VisaController;
use App\Http\Controllers\Content\VaccineController;
use App\Http\Controllers\DocumentController;
use App\Http\Controllers\PriceListHotelController;
use App\Http\Controllers\PriceListTicket;
use App\Http\Controllers\ReyalController;
use App\Http\Controllers\TransportationController;
use App\Models\PriceListHotel;
use Symfony\Component\HttpKernel\DependencyInjection\ServicesResetter;

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
    Route::get('/nego/{id}', [ServicesController::class, 'nego'])->name('admin.service.nego');
    Route::put('/update/{id}/nego', [ServicesController::class, 'updateNego'])->name('update.nego.admin');
    Route::get('/services/{service_id}/upload-berkas', [ServicesController::class, 'uploadBerkas'])->name('service.uploadBerkas');
    Route::post('/services/store-berkas', [ServicesController::class, 'storeBerkas'])->name('service.storeBerkas');
    Route::get('/service/files', [ServicesController::class, 'showFile'])->name('admin.service.file');
    Route::post('{order}/payment', [ServicesController::class, 'payment'])->name('orders.payment');
    Route::get('{order}/bayar', [ServicesController::class, 'bayar'])->name('orders.bayar');
});

Route::middleware(['auth', 'hotel'])->group(function () {
    Route::get('/hotel', [HotelController::class, 'index'])->name('hotel.index');
    Route::get('/hotel/create', [HotelController::class, 'create'])->name('hotel.create');
    Route::post('/hotel', [HotelController::class, 'store'])->name('hotel.store');
    Route::get('hotel/{id}', [HotelController::class, 'edit'])->name('hotel.edit');
    Route::put('hotel/{id}/update', [HotelController::class, 'update'])->name('hotel.update');
    Route::delete('hotel/{id}/delete', [HotelController::class, 'destroy'])->name('hotel.destroy');
    Route::get('/price', [PriceListHotelController::class, 'index'])->name('hotel.price.index');
    Route::get('/price/create', [PriceListHotelController::class, 'create'])->name('hotel.price.create');
    Route::post('/price/store', [PriceListHotelController::class, 'store'])->name('hotel.price.post');
    Route::get('/price/edit/{id}', [PriceListHotelController::class, 'edit'])->name('hotel.price.edit');
    Route::put('/price/update/{id}', [PriceListHotelController::class, 'update'])->name('hotel.price.update');
    Route::delete('/price/delete/{id}', [PriceListHotelController::class, 'destroy'])->name('hotel.price.delete');
});
Route::middleware(['auth', 'handling'])->group(function () {
    Route::group(['prefix' => 'catering',], function () {
        Route::get('/', [App\Http\Controllers\Handling\CateringController::class, 'index'])->name('catering.index');
        Route::get('/create', [App\Http\Controllers\Handling\CateringController::class, 'create'])->name('catering.create');
        Route::post('/', [App\Http\Controllers\Handling\CateringController::class, 'store'])->name('catering.store');
        Route::get('/{id}', [App\Http\Controllers\Handling\CateringController::class, 'show'])->name('catering.show');
        Route::get('/{id}/edit', [App\Http\Controllers\Handling\CateringController::class, 'edit'])->name('catering.edit');
        Route::put('update/{id}', [App\Http\Controllers\Handling\CateringController::class, 'update'])->name('catering.update');
        Route::delete('/delete/{id}', [App\Http\Controllers\Handling\CateringController::class, 'destroy'])->name('catering.delete');
        Route::get('/customer', [App\Http\Controllers\Handling\CateringController::class, 'customer'])->name('catering.customer');
    });
    Route::group(['prefix' => 'handling'], function () {
        Route::get('/',  [App\Http\Controllers\Handling\HandlingController::class, 'index'])->name('handling.handling.index');
        Route::get('/hotel',  [App\Http\Controllers\Handling\HandlingController::class, 'hotel'])->name('handling.handling.hotel');
    });
    Route::group(['prefix' => 'pendamping'], function () {
        Route::get('/',  [App\Http\Controllers\Handling\PendampingController::class, 'index'])->name('handling.pendamping.index');
        Route::get('/create',  [App\Http\Controllers\Handling\PendampingController::class, 'create'])->name('handling.pendamping.create');
        Route::post('/create',  [App\Http\Controllers\Handling\PendampingController::class, 'store'])->name('handling.pendamping.store');
        Route::get('/edit/{id}',  [App\Http\Controllers\Handling\PendampingController::class, 'edit'])->name('handling.pendamping.edit');
        Route::put('/update/{id}', [App\Http\Controllers\Handling\PendampingController::class, 'update'])->name('handling.pendamping.update');
        Route::delete('/delete/{id}', [App\Http\Controllers\Handling\PendampingController::class, 'destroy'])->name('handling.pendamping.destroy');
    });
    Route::group(['prefix' => 'tour'], function () {
        Route::get('/',  [App\Http\Controllers\Handling\TourController::class, 'index'])->name('handling.tour.index');
        Route::get('/create',  [App\Http\Controllers\Handling\TourController::class, 'create'])->name('handling.tour.create');
        Route::post('/create',  [App\Http\Controllers\Handling\TourController::class, 'store'])->name('handling.tour.store');
        Route::get('/edit/{id}',  [App\Http\Controllers\Handling\TourController::class, 'edit'])->name('handling.tour.edit');
        Route::put('/update/{id}', [App\Http\Controllers\Handling\TourController::class, 'update'])->name('handling.tour.update');
        Route::delete('/delete/{id}', [App\Http\Controllers\Handling\TourController::class, 'destroy'])->name('handling.tour.destroy');
    });
});

Route::middleware(['auth', 'transportation'])->group(function () {
    Route::group(['prefix' => 'planes'], function () {
        Route::get('/', [TransportationController::class, 'index'])->name('transportation.plane.index');
        Route::get('/create', [TransportationController::class, 'create'])->name('transportation.plane.create');
        Route::post('/create', [TransportationController::class, 'store'])->name('transportation.plane.store');
        Route::get('/edit/{id}', [TransportationController::class, 'edit'])->name('transportation.plane.edit');
        Route::put('/update/{id}', [TransportationController::class, 'update'])->name('transportation.plane.update');
        Route::delete('/delete/{id}', [TransportationController::class, 'delete'])->name('transportation.plane.delete');
        Route::get('/price-list/ticket', [PriceListTicket::class, 'index'])->name('price.list.ticket');
        Route::get('/price-list/ticket/create', [PriceListTicket::class, 'create'])->name('price.list.ticket.create');
        Route::post('/price-list/ticket/post', [PriceListTicket::class, 'store'])->name('price.list.ticket.post');
        Route::get('/price-list/ticket/edit/{id}', [PriceListTicket::class, 'edit'])->name('price.list.ticket.edit');
        Route::put('/price-list/ticket/update/{id}', [PriceListTicket::class, 'update'])->name('price.list.ticket.update');
        Route::delete('/price-list/ticket/delete/{id}', [PriceListTicket::class, 'destroy'])->name('price.list.ticket.delete');
    });
    Route::group(['prefix' => 'cars'], function () {
        Route::get('/', [TransportationController::class, 'indexCar'])->name('transportation.car.index');
        Route::get('/create', [TransportationController::class, 'createCar'])->name('transportation.car.create');
        Route::post('/create', [TransportationController::class, 'storeCar'])->name('transportation.car.store');
        Route::get('/edit/{id}', [TransportationController::class, 'editCar'])->name('transportation.car.edit');
        Route::put('/update/{id}', [TransportationController::class, 'updateCar'])->name('transportation.car.update');
        Route::delete('/delete/{id}', [TransportationController::class, 'deleteCar'])->name('transportation.car.delete');
        Route::get('/detail/{id}', [TransportationController::class, 'detailCar'])->name('transportation.car.detail');
        Route::get('/detail/{id}/route/create', [RouteController::class, 'create'])->name('transportation.car.detail.create');
        Route::post('/detail/{id}/route/create/store', [RouteController::class, 'store'])->name('transportation.car.detail.store');
        Route::get('/route/id/{id}', [RouteController::class, 'edit'])->name('transportation.car.detail.route.edit');
        Route::put('/route/id/{id}', [RouteController::class, 'update'])->name('transportation.car.detail.route.update');
        Route::delete('/route/delete/{id}', [RouteController::class, 'destroy'])->name('transportation.car.detail.route.delete');
    });
    Route::get('/customer/transportation', [TransportationController::class, 'TransportationCustomer'])->name('transportation.customer');
});

Route::middleware(['auth', 'visa'])->group(function () {
    Route::get('/document', [DocumentController::class, 'index'])->name('visa.document.index');
    Route::get('/document/create', [DocumentController::class, 'create'])->name('visa.document.create');
    Route::post('/document/create', [DocumentController::class, 'store'])->name('visa.document.store');
    Route::get('/document/edit/{id}', [DocumentController::class, 'edit'])->name('visa.document.edit');
    Route::put('/document/edit/{id}', [DocumentController::class, 'update'])->name('visa.document.update');
    Route::delete('/document/delete/{id}', [DocumentController::class, 'destroy'])->name('visa.document.delete');
    Route::get('/document/{id}/detail', [DocumentController::class, 'show'])->name('visa.document.show');
    Route::get('/document/{id}/detail/create', [DocumentController::class, 'createDocument'])->name('visa.document.show.create');
    Route::post('/document/{id}/detail/store', [DocumentController::class, 'createDocumentStore'])->name('visa.document.show.store');
    Route::get('/document/{id}/detail/edit', [DocumentController::class, 'createDocumentEdit'])->name('visa.document.show.edit');
    Route::put('/document/{id}/detail/update', [DocumentController::class, 'createDocumentUpdate'])->name('visa.document.show.update');
    Route::delete('/document/{id}/detail/delete', [DocumentController::class, 'createDocumentDelete'])->name('visa.document.show.delete');
    Route::get('/document/customer', [DocumentController::class, 'customer'])->name('visa.document.customer');
});


Route::group(['middleware' => 'guest'], function () {
    Route::get('admin/login', function () {
        return view('admin.auth.login');
    })->name('login');
    Route::post('/sign-in', [AuthController::class, 'sign_in'])->name('sign_in');
});

Route::post('/sign-out', [AuthController::class, 'sign_out'])->name('sign_out');
Route::get('/reyal', [ReyalController::class, 'index'])->name('reyal.index')->middleware('auth', 'reyal');
Route::middleware(['auth', 'palugada'])->group(function () {
    Route::get('/wakaf', [WakafController::class, 'index'])->name('wakaf.index');
    Route::get('/wakaf/create', [WakafController::class, 'create'])->name('wakaf.create');
    Route::post('wakaf/store', [WakafController::class, 'store'])->name('wakaf.store');
    Route::get('wakaf/edit/{id}', [WakafController::class, 'edit'])->name('wakaf.edit');
    Route::put('wakaf/update/{id}', [WakafController::class, 'update'])->name('wakaf.update');
    Route::delete('wakaf/delete/{id}', [WakafController::class, 'destroy'])->name('wakaf.destroy');
    Route::get('wakaf/customer', [WakafController::class, 'customer'])->name('wakaf.customer');

    Route::get('/dorongan', [DoronganController::class, 'index'])->name('dorongan.index');
    Route::get('/dorongan/create', [DoronganController::class, 'create'])->name('dorongan.create');
    Route::post('dorongan/store', [DoronganController::class, 'store'])->name('dorongan.store');
    Route::get('dorongan/edit/{id}', [DoronganController::class, 'edit'])->name('dorongan.edit');
    Route::put('dorongan/update/{id}', [DoronganController::class, 'update'])->name('dorongan.update');
    Route::delete('dorongan/delete/{id}', [DoronganController::class, 'destroy'])->name('dorongan.destroy');
    Route::get('dorongan/customer', [DoronganController::class, 'customer'])->name('dorongan.customer');

    Route::get('/badal', function(){
        $wakaf = \App\Models\Badal::all();
        return view('palugada.badal', compact('wakaf'));
    })->name('palugada.badal');
});
Route::middleware(['auth', 'content'])->group(function(){
    Route::get('/content', [ContentController::class, 'index'])->name('content.index');
    Route::get('/content/create', [ContentController::class, 'create'])->name('content.create');
    Route::post('/content/store', [ContentController::class, 'store'])->name('content.store');
    Route::get('/content/edit/{id}', [ContentController::class, 'edit'])->name('content.edit');
    Route::put('/content/update/{id}', [ContentController::class, 'update'])->name('content.update');
    Route::delete('/content/delete/{id}', [ContentController::class, 'destroy'])->name('content.destroy');
    Route::get('/content/customer', [ContentController::class, 'customer'])->name('content.customer');
});
