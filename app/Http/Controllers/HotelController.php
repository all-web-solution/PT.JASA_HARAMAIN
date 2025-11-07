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
        // 1. Ambil data Hotel (per item) dan lakukan paginasi
        $hotels = Hotel::with([
                        'service.pelanggan', // Untuk Nama Travel
                    ])
                    ->latest() // Urutkan berdasarkan yang terbaru
                    ->paginate(15); // Ambil 15 item per halaman

        // 2. Kirim data paginator ke view
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
    public function show(Hotel $hotel)
    {
        // $hotel otomatis ditemukan oleh Laravel
        $hotel->load('service.pelanggan'); // Load relasi

        return view('hotel.show', compact('hotel'));
    }

    public function edit(Hotel $hotel)
    {
        // Ambil data untuk dropdowns
        $services = Service::with('pelanggan')->get();
        $statuses = ['nego', 'deal', 'batal', 'done']; // Sesuaikan dengan kebutuhan

        return view('hotel.edit', compact(
            'hotel',
            'services',
            'statuses'
        ));
    }

    public function update(Request $request, Hotel $hotel)
    {
        // Validasi data berdasarkan model Hotel
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
            // Field Baru
            'supplier' => 'nullable|string|max:255',
            'harga_dasar' => 'nullable|numeric|min:0',
            'harga_jual' => 'nullable|numeric|min:0|gte:harga_dasar',
        ]);

        // Update data hotel
        $hotel->update($validatedData);

        Session::flash('success', 'Order hotel berhasil diperbarui.');

        // Redirect kembali ke halaman detail
        return redirect()->route('hotel.show', $hotel->id);
    }

    public function destroy($id)
    {
        $hotel = Hotel::findOrFail($id);
        $hotel->delete();

        return redirect()->route('hotel.index')->with('success', 'Hotel booking deleted successfully.');
    }
}
