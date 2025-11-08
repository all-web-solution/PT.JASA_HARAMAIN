<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function sign_in(Request $request)
    {
        $auth = $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        if (Auth::attempt($auth)) {
            $request->session()->regenerate();

            $user = Auth::user();

            if ($user->role === 'admin') {
                return redirect()->route('admin.index');
            } elseif ($user->role === 'hotel') {
                return redirect()->route('hotel.index');
            } elseif ($user->role === 'handling') {
                return redirect()->route('catering.index');
            } elseif ($user->role === 'transportasi & tiket') {
                return redirect()->route('transportation.plane.index');
            } elseif ($user->role === 'visa dan acara') {
                return redirect()->route('visa.document.index');
            } elseif ($user->role === 'reyal') {
                return redirect()->route('reyal.index');
            } elseif ($user->role === 'palugada') {
                return redirect()->route('wakaf.index');
            } elseif ($user->role === 'konten dan dokumentasi') {
                return redirect()->route('content.index');
            } elseif ($user->role === 'keuangan') {
                return redirect()->route('keuangan.index');
            }

            return redirect()->route('login')->withErrors(['email' => 'Role tidak dikenali.']);
        } else {
            return redirect()->back()->withInput()->with('failed', "Username atau password salah");
        }
    }

    public function sign_out()
    {
        Auth::logout();
        return redirect()->route('login')->with('success', 'Anda telah berhasil keluar');
    }
}
