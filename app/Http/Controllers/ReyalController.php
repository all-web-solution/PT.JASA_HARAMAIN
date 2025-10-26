<?php

namespace App\Http\Controllers;

use App\Models\Exchange;
use Illuminate\Http\Request;

class ReyalController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $reyals = Exchange::all();
        return view('reyal.index', compact('reyals'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

    }

    /**
     * Display the specified resource.
     */
    public function createSupplier($id)
    {
        $supplier = Exchange::findOrFail($id);
        return view('reyal.supplier_create', compact('supplier'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function supplier(string $id)
    {
        $supplier = Exchange::findOrFail($id);
        return view('reyal.supplier', compact('supplier'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function createSupplierStore(Request $request, string $id)
    {
        $supplier = Exchange::findOrFail($id);
        $supplier->supplier = $request->input('name');
        $supplier->harga_dasar = $request->input('price');
        $supplier->save();
        return redirect()->route('reyal.supplier.index', $id);

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
