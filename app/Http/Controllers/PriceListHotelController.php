<?php

namespace App\Http\Controllers;

use App\Models\Hotel;
use App\Models\PriceListHotel;
use App\Models\TypeHotel;
use Illuminate\Http\Request;

class PriceListHotelController extends Controller
{
    public function index(Request $request)
    {
        $query = PriceListHotel::query()->latest();

        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where('nama_hotel', 'like', '%' . $search . '%')
                ->orWhere('tipe_kamar', 'like', '%' . $search . '%');
        }

        $listHotel = $query->get();
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
            'category' => 'nullable|string|max:255',
            'tipe_kamar' => 'required|string|max:255',
            'harga' => 'required|numeric|min:0',

            // Tambahan untuk field input baru
            'tanggal_checkOut' => 'nullable|date|after_or_equal:tanggal', // Validasi Logis
            'catatan' => 'nullable|string',
            'add_on' => 'nullable|string',
            'supplier_utama' => 'nullable|string|max:255',
            'kontak_supplier_utama' => 'nullable|string|max:255',
            'supplier_cadangan' => 'nullable|string|max:255',
            'kontak_supplier_cadangan' => 'nullable|string|max:255',
        ]);

        PriceListHotel::create($request->all());

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
            'category' => 'nullable|string|max:255',
            'tipe_kamar' => 'required|string|max:255',
            'harga' => 'required|numeric|min:0',

            // Tambahan untuk field input baru
            'tanggal_checkOut' => 'nullable|date|after_or_equal:tanggal', // Validasi Logis
            'catatan' => 'nullable|string',
            'add_on' => 'nullable|string',
            'supplier_utama' => 'nullable|string|max:255',
            'kontak_supplier_utama' => 'nullable|string|max:255',
            'supplier_cadangan' => 'nullable|string|max:255',
            'kontak_supplier_cadangan' => 'nullable|string|max:255',
        ]);

        $priceList = PriceListHotel::findOrFail($id);
        $priceList->update($request->all());

        return redirect()->route('hotel.price.index')->with('success', 'Harga hotel berhasil diperbarui!');
    }

    public function show($id)
    {
        $priceList = PriceListHotel::findOrFail($id);

        // Hitung durasi malam jika check-in dan check-out tersedia
        $durasi = 0;
        if ($priceList->tanggal && $priceList->tanggal_checkOut) {
            $checkIn = \Carbon\Carbon::parse($priceList->tanggal);
            $checkOut = \Carbon\Carbon::parse($priceList->tanggal_checkOut);
            $durasi = $checkIn->diffInDays($checkOut);
        }

        return view('hotel.price_list.show', compact('priceList', 'durasi'));
    }

    public function destroy(string $id)
    {
        $priceList = PriceListHotel::findOrFail($id);
        $priceList->delete();
        return redirect()->route('hotel.price.index')->with('success', 'Harga hotel berhasil dihapus!');
    }
}
