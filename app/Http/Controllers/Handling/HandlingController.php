<?php

namespace App\Http\Controllers\Handling;

use App\Http\Controllers\Controller;
use App\Models\HandlingHotel;
use App\Models\HandlingPlanes;

class HandlingController extends Controller
{
    public function index()
    {
        $planes = HandlingPlanes::with(['handling.service.pelanggan'])->get();

        return view('handling.handling.index', compact('planes'));
    }


    public function hotel()
    {
        $hotels = HandlingHotel::with('handling.service.pelanggan')->get();

        return view('handling.handling.hotel', compact('hotels'));
    }
    public function show($id)
    {
        $hotel = HandlingHotel::with('handling.service.pelanggan')->findOrFail($id);

        return view('handling.handling.hotel.show', compact('hotel'));
    }
    public function plane($id)
    {
        $plane = HandlingPlanes::with('handling.service.pelanggan')->findOrFail($id);

        return view('handling.handling.plane.show', compact('plane'));
    }

}
