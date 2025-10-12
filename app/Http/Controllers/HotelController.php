<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Hotel;
use App\Models\Order;
use App\Models\Service;


class HotelController extends Controller
{
    public function index(Request $request)
    {
        $query = Hotel::query();

        if ($request->has('search') && $request->search) {
            $query->where('nama_hotel', 'like', '%' . $request->search . '%')
                ->orWhere('service_id', 'like', '%' . $request->search . '%');
        }

        // if ($request->has('status') && $request->status != 'Semua Status') {
        //     $query->where('status', $request->status);
        // }

        $hotels = $query->paginate(10);

        return view('hotel.index', compact('hotels'));
    }

    public function create()
    {
        return view('hotel.create', );
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
        Hotel::create([
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
        $hotel = Hotel::findOrFail($id);
        return view('hotel.show', compact('hotel'));
    }

    public function edit($id)
    {
        $hotel = Hotel::findOrFail($id);
        return view('hotel.edit', compact('hotel'));
    }

    public function update(Request $request, $id)
    {
        // 1. Temukan hotel dan perbarui harganya
        $hotel = Hotel::findOrFail($id);
        $hotel->update([
            'harga_perkamar' => $request->harga,
            'harga_type_custom_special_room' => $request->harga_type_custom_special_room
        ]);

        // 2. Jika hotel terhubung ke layanan (service)
        if ($hotel->service) {
            // 3. Dapatkan pelanggan dari layanan hotel ini
            $pelangganId = $hotel->service->pelanggan_id;

            // 4. Cari SEMUA layanan (services) yang dimiliki oleh pelanggan ini
            $allServices = Service::where('pelanggan_id', $pelangganId)->get();

            // 5. Inisialisasi total harga
            $grandTotal = 0;

            // 6. Loop melalui semua layanan pelanggan untuk menghitung total
            foreach ($allServices as $service) {
                // Hitung total semua hotel yang terhubung ke layanan ini
                $totalHotels = $service->hotels()->sum('harga_perkamar');

                // Hitung total semua pesawat yang terhubung ke layanan ini
                $totalPlanes = $service->planes()->sum('harga');

                // Tambahkan ke total keseluruhan
                $grandTotal += $totalHotels + $totalPlanes;
            }

            // 7. Perbarui pesanan (order) yang terhubung ke service yang mana saja untuk pelanggan ini
            Order::whereHas('service', function ($query) use ($pelangganId) {
                $query->where('pelanggan_id', $pelangganId);
            })->update([
                        'total_amount' => $grandTotal,
                        'sisa_hutang' => $grandTotal
                    ]);
        }

        return redirect()->route('hotel.index')->with('success', 'Harga hotel & total order berhasil diperbarui!');
    }

    public function destroy($id)
    {
        $hotel = Hotel::findOrFail($id);
        $hotel->delete();

        return redirect()->route('hotel.index')->with('success', 'Hotel booking deleted successfully.');
    }
}
