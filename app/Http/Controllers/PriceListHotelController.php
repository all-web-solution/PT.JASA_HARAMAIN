<?php

namespace App\Http\Controllers;

use App\Models\PriceListHotel;
use Illuminate\Http\Request;

class PriceListHotelController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $listHotel = PriceListHotel::all();
        return view('hotel.price_list.index', compact('listHotel'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('hotel.price_list.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
       PriceListHotel::create([
            'tanggal' => $request->tanggal,
            'nama_hotel' => $request->nama_hotel,
            'tipe_kamar' => $request->tipe_kamar,
            'harga' => $request->harga
       ]);
       return redirect()->route('hotel.price.index');
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
        $priceList = PriceListHotel::findOrFail($id);
        return view('hotel.price_list.edit', compact('priceList'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $priceList = PriceListHotel::findOrFail($id);
        $priceList->update([
             'tanggal' => $request->tanggal,
            'nama_hotel' => $request->nama_hotel,
            'tipe_kamar' => $request->tipe_kamar,
            'harga' => $request->harga
        ]);
        return redirect()->route('hotel.price.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $priceList = PriceListHotel::findOrFail($id);
        $priceList->delete();
         return redirect()->route('hotel.price.index');
    }
}
