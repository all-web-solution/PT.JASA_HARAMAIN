<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
    $middleware->alias([
        'role'  => \App\Http\Middleware\RoleMiddleware::class,
        'admin' => \App\Http\Middleware\AdminMiddleware::class,
        'hotel' => \App\Http\Middleware\HotelMiddleware::class,
        'handling' => \App\Http\Middleware\HandlingMiddleware::class,
        'transportation' => \App\Http\Middleware\TransportationMiddleware::class,
        'content' => \App\Http\Middleware\ContentMiddleware::class,
        'visa' => \App\Http\Middleware\VisaMiddleware::class,
        'reyal' => \App\Http\Middleware\ReyalMiddleware::class,
        'palugada' => \App\Http\Middleware\PalugadaMiddleware::class,
        'keuangan' => \App\Http\Middleware\KeuanganMiddleware::class
    ]);
})
    ->withExceptions(function (Exceptions $exceptions): void {
        //
    })->create();
