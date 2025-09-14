<?php

namespace App\Http\Controllers;

use App\Models\PriceListTicket as ModelsPriceListTicket;
use Illuminate\Http\Request;

class PriceListTicket extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $lists = ModelsPriceListTicket::all();
        return view('transportasi.pesawat.price-list.index', compact('lists'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('transportasi.pesawat.price-list.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        ModelsPriceListTicket::create([
            'tanggal' => $request->tanggal_berangkat,
            'jam_berangkat' => $request->jam_berangkat,
            'kelas' => $request->kelas,
            'harga' => $request->harga
        ]);
        return redirect()->route('price.list.ticket');
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
        $list = ModelsPriceListTicket::find($id);
        return view('transportasi.pesawat.price-list.edit', compact('list'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $list = ModelsPriceListTicket::find($id);
        $list->update([
            'tanggal' => $request->tanggal_berangkat,
            'jam_berangkat' => $request->jam_berangkat,
            'kelas' => $request->kelas,
            'harga' => $request->harga
        ]);
         return redirect()->route('price.list.ticket');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
         $list = ModelsPriceListTicket::find($id);
         $list->delete();
         return redirect()->route('price.list.ticket');
    }
}
