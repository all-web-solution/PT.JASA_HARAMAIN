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

        $pelanggans = Pelanggan::all();
        return view('admin.services.create', compact('pelanggans'));
    }


    public function show()
    {
        return view('admin.services.show', compact('service'));
    }

    public function store(Request $request){
        // $request->validate([
        //     'subcategory_id' => 'required|exists:subcategories,id',
        //     'name' => 'required|string|max:255',
        //     'description' => 'nullable|string',
        //     'price' => 'required|numeric|min:0',
        //     'currency' => 'required|string|max:10',
        //     'duration' => 'required|integer|min:1',
        //     'is_active' => 'boolean',
        // ]);

        // Services::create($request->all());

        // return redirect()->route('admin.services.index')->with('success', 'Service created successfully.');
       
    }
}
