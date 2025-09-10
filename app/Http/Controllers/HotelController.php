<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Hotel;

class HotelController extends Controller
{
    public function index()
    {
        $hotels = \App\Models\Hotel::all();
        return view('hotel.index', compact('hotels'));
    }
    public function create()
    {

        return view('hotel.create',);
    }

    public function store(Request $request)
    {
        // Validate the request data
        $request->validate([
            'checkin' => 'required|date',
            'checkout' => 'required|date|after:checkin',
            'room' => 'required|string|max:255',
            'star' => 'required|string|max:255',
        ]);

        // Create a new hotel booking
        \App\Models\Hotel::create([
            'checkin' => $request->checkin,
            'checkout' => $request->checkout,
            'room_type' => $request->room,
            'star' => $request->star,
        ]);

        // Redirect to the hotel index page with a success message
        return redirect()->route('hotel.index')->with('success', 'Hotel booking created successfully.');
    }

    // Add other methods like show, edit, update, destroy as needed
    public function show($id)
    {
        $hotel = \App\Models\Hotel::findOrFail($id);
        return view('hotel.show', compact('hotel'));
    }

    public function edit($id)
    {
        $hotel = \App\Models\Hotel::findOrFail($id);
        return view('hotel.edit', compact('hotel'));
    }

    public function update(Request $request, $id)
    {
        // Temukan hotel dan perbarui harganya
        $hotel = Hotel::findOrFail($id);
        $hotel->update(['harga_perkamar' => $request->harga]);

        // Pastikan hotel memiliki layanan (service) master yang terhubung
        if ($hotel->service) {
            // Dapatkan ID dari layanan master yang terhubung ke hotel ini
            $serviceId = $hotel->service->id;

            // Hitung total harga semua hotel yang terhubung ke layanan master ini
            $totalHotels = $hotel->service->hotels()->sum('harga_perkamar');

            // Hitung total harga semua pesawat yang terhubung ke layanan master yang SAMA
            $totalPlanes = $hotel->service->planes()->sum('harga');

            // Hitung total gabungan dari hotel dan pesawat
            $grandTotal = $totalHotels + $totalPlanes;

            // Perbarui pesanan (order) yang terhubung ke layanan master ini
            \App\Models\Order::where('service_id', $serviceId)->update([
                'total_amount' => $grandTotal,
                'sisa_hutang' => $grandTotal
            ]);
        }

        return redirect()->route('hotel.index')->with('success', 'Harga hotel & total order berhasil diperbarui!');
    }

    public function destroy($id)
    {
        $hotel = \App\Models\Hotel::findOrFail($id);
        $hotel->delete();

        return redirect()->route('hotel.index')->with('success', 'Hotel booking deleted successfully.');
    }
}
