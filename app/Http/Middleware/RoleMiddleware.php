<?php

namespace App\Http\Middleware;


use Closure;
use Illuminate\Support\Facades\Auth;

class RoleMiddleware
{
    public function handle($request, Closure $next, ...$roles)
    {
        // ...$roles otomatis jadi array, walau di route cuma 'admin'
        if (Auth::check()) {
            $role = Auth::user()->role;
            switch ($role) {
                case 'admin':
                    return redirect()->route('admin.dashboard');
                case 'hotel':
                    return redirect()->route('hotel.index');
                case 'handling':
                    return redirect()->route('handling.index');
                case 'visa dan acara':
                    return redirect()->route('visa.index');
                case 'reyal':
                    return redirect()->route('reyal.index');
                case 'palugada':
                    return redirect()->route('palugada.index');
                case 'konten dan dokumentasi':
                    return redirect()->route('content.index');
                default:
                    return redirect()->route('login');
            }
        }

        return $next($request);
    }
}
