<?php

namespace App\Http\Controllers\Handling;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\TourItem;
use Illuminate\Support\Facades\Session;

class TourController extends Controller
{
    public function index()
    {
        $tours = TourItem::all();
        return view('handling.tour.index', compact('tours'));
    }
    public function create()
    {
        return view('handling.tour.create');
    }
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        TourItem::create($request->only('name'));

        Session::flash('success', 'Tour berhasil ditambahkan.');
        return redirect()->route('handling.tour.index');
    }
    public function edit(TourItem $tour)
    {
        return view('handling.tour.edit', compact('tour'));
    }
    public function update(Request $request, TourItem $tour)
    {
        $request->validate([
            'name' => 'required|string|max:255',
        ]);
        $tour->update($request->only('name'));
        Session::flash('success', 'Tour berhasil diperbarui.');
        return redirect()->route('handling.tour.index');
    }
    public function destroy(TourItem $tour)
    {
        $tour->delete();
        Session::flash('success', 'Tour berhasil dihapus.');
        return redirect()->route('handling.tour.index');
    }
}
