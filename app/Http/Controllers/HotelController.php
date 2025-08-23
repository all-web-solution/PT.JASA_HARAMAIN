<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

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

    
}
