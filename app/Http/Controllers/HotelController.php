<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Hotel;
use App\Models\Order;
use App\Models\Service;
use Illuminate\Support\Facades\Session;

class HotelController extends Controller
{
    public function index()
    {
        $services = Service::query()
            ->has('hotels')
            ->with([
                'pelanggan',
                'hotels',
            ])
            ->latest()
            ->paginate(15);

        return view('hotel.index', ['hotels' => $services]);
    }



    public function create()
    {
        return view('hotel.create', );
    }

    public function store(Request $request)
    {
        $request->validate([
            'checkin' => 'required|date',
            'checkout' => 'required|date|after:checkin',
            'room' => 'required|string|max:255',
            'star' => 'required|string|max:255',
        ]);

        Hotel::create([
            'checkin' => $request->checkin,
            'checkout' => $request->checkout,
            'room_type' => $request->room,
            'star' => $request->star,
        ]);

        return redirect()->route('hotel.index')->with('success', 'Hotel booking created successfully.');
    }

    public function show(Hotel $hotel)
    {
        $serviceId = $hotel->service_id;

        $service = Service::with([
            'pelanggan',
            'hotels'
        ])->findOrFail($serviceId);

        return view('hotel.show', compact('service'));
    }

    public function edit(Hotel $hotel)
    {
        $services = Service::with('pelanggan')->get();
        $statuses = ['nego', 'deal', 'batal', 'done'];

        return view('hotel.edit', compact(
            'hotel',
            'services',
            'statuses'
        ));
    }

    public function update(Request $request, Hotel $hotel)
    {
        $validatedData = $request->validate([
            'service_id' => 'nullable|exists:services,id',
            'tanggal_checkin' => 'nullable|date',
            'tanggal_checkout' => 'nullable|date|after_or_equal:tanggal_checkin',
            'nama_hotel' => 'nullable|string|max:255',
            'jumlah_kamar' => 'nullable|integer|min:0',
            'harga_perkamar' => 'nullable|numeric|min:0',
            'catatan' => 'nullable|string',
            'type' => 'nullable|string|max:255',
            'jumlah_type' => 'nullable|integer|min:0',
            'status' => 'required|string',
            'supplier' => 'nullable|string|max:255',
            'harga_dasar' => 'nullable|numeric|min:0',
            'harga_jual' => 'nullable|numeric|min:0|gte:harga_dasar',
        ]);

        $hotel->update($validatedData);

        Session::flash('success', 'Order hotel berhasil diperbarui.');

        return redirect()->route('hotel.show', $hotel->id);
    }

    public function destroy($id)
    {
        $hotel = Hotel::findOrFail($id);
        $hotel->delete();

        return redirect()->route('hotel.index')->with('success', 'Hotel booking deleted successfully.');
    }
}
