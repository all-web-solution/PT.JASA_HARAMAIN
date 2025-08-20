<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Pelanggan;
use App\Models\Services;
use Illuminate\Http\Request;

class ServicesController extends Controller
{
    public function index()
    {
        return view('admin.services.index');
    }
    public function create()
    {


        return view('admin.services.create');
    }


    public function show()
    {
        return view('admin.services.show', compact('service'));
    }
}
