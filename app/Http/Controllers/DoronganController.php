<?php

namespace App\Http\Controllers;

use App\Models\DoronganOrder;
use Illuminate\Http\Request;
use App\Models\Dorongan;

class DoronganController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $items = Dorongan::all();
        return view('palugada.dorongan.index', compact('items'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
         return view('palugada.dorongan.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        Dorongan::create([
            'name' => $request->nama,
            'price' => $request->harga
        ]);
        return redirect()->route('dorongan.index');

    }

    /**
     * Display the specified resource.
     */
    public function customer()
    {
        $data = DoronganOrder::all();
        return view('palugada.dorongan.customer', compact('data'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $item = Dorongan::findOrFail($id);
        return view('palugada.dorongan.edit', compact('item'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $item = Dorongan::findOrFail($id);
        $item->update([
             'name' => $request->name,
            'price' => $request->price
        ]);
        return redirect()->route('dorongan.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
          $item = Dorongan::findOrFail($id);
          $item->delete();
           return redirect()->route('dorongan.index');
    }


}
