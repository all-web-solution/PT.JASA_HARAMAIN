<?php

namespace App\Http\Controllers;

use App\Models\Hotel;
use App\Models\PriceListHotel;
use App\Models\TypeHotel;
use Illuminate\Http\Request;

class PriceListHotelController extends Controller
{
    public function index()
    {
        $listHotel = PriceListHotel::all();
        return view('hotel.price_list.index', compact('listHotel'));
    }

    public function create()
    {
        $hotels = Hotel::pluck('nama_hotel');
        $roomTypes = TypeHotel::pluck('nama_tipe');
        return view('hotel.price_list.create', compact('hotels', 'roomTypes'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'tanggal' => 'required|date',
            'nama_hotel' => 'required|string|max:255',
            'tipe_kamar' => 'required|string|max:255',
            'harga' => 'required|numeric|min:0',
        ]);

        PriceListHotel::create($request->only('tanggal', 'nama_hotel', 'tipe_kamar', 'harga'));

        return redirect()->route('hotel.price.index')->with('success', 'Harga hotel berhasil ditambahkan!');
    }

    public function edit($id)
    {
        $priceList = PriceListHotel::findOrFail($id);
        $hotels = Hotel::pluck('nama_hotel');
        $roomTypes = TypeHotel::pluck('nama_tipe');
        return view('hotel.price_list.edit', compact('priceList', 'hotels', 'roomTypes'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'tanggal' => 'required|date',
            'nama_hotel' => 'required|string|max:255',
            'tipe_kamar' => 'required|string|max:255',
            'harga' => 'required|numeric|min:0',
        ]);

        $priceList = PriceListHotel::findOrFail($id);
        $priceList->update($request->only('tanggal', 'nama_hotel', 'tipe_kamar', 'harga'));

        return redirect()->route('hotel.price.index')->with('success', 'Harga hotel berhasil diperbarui!');
    }

    public function destroy(string $id)
    {
        $priceList = PriceListHotel::findOrFail($id);
        $priceList->delete();
        return redirect()->route('hotel.price.index');
    }

}
