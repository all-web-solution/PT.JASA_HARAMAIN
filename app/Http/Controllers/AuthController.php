<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
class AuthController extends Controller
{
    public function sign_in(Request $request)
{
    $credentials = $request->validate([
        'email' => ['required', 'email'],
        'password' => ['required'],
    ]);

    if (Auth::attempt($credentials)) {
        $request->session()->regenerate(); // penting biar session hijacking aman
        return redirect()->route('admin.index');
    }

    return back()->withErrors([
        'email' => 'Email atau password salah.',
    ])->onlyInput('email');
}

public function sign_out()
{
    Auth::logout();
    return redirect('/admin/services')->with('success', 'Anda telah berhasil keluar');

}
}
