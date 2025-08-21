<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
class AuthController extends Controller
{
    public function sign_in(Request $request){
        $auth = $request->validate(['email' => 'required', 'password' => 'required']);

        if(Auth::attempt($auth)){
            return redirect()->route('admin.index');
        }
    }

public function sign_out()
{
    Auth::logout();
    return redirect('/admin/services')->with('success', 'Anda telah berhasil keluar');

}
}
