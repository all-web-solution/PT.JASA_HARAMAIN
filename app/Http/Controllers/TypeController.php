<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\TypeHotel;
use Illuminate\Http\Request;

class TypeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $types = TypeHotel::all();
        return view('hotel.type_kamar.index', compact('types'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('hotel.type_kamar.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        TypeHotel::create(
            ['nama_tipe' => $request->name, 'jumlah' => $request->price]
        );

        return redirect()->route('hotel.type.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $type = TypeHotel::find($id);
        return view('hotel.type_kamar.edit', compact('type'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $type = TypeHotel::find($id);
        $type->update([
            'nama_tipe' => $request->name, 'jumlah' => $request->price
        ]);
         return redirect()->route('hotel.type.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $type = TypeHotel::find($id);
        $type->delete();
        return redirect()->route('hotel.type.index');
    }
}
