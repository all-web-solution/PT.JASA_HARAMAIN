<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\TypeHotel;
use Illuminate\Http\Request;

class TypeController extends Controller
{
    public function index(Request $request)
    {
        $query = TypeHotel::query();

        if ($request->filled('search')) {
            $query->where('nama_tipe', 'like', '%' . $request->search . '%');
        }

        $types = $query->get();
        return view('hotel.type_kamar.index', compact('types'));
    }
    public function create()
    {
        return view('hotel.type_kamar.create');
    }
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:100',
        ]);

        TypeHotel::create([
            'nama_tipe' => $request->name,
        ]);

        return redirect()->route('hotel.type.index');
    }
    public function edit(string $id)
    {
        $type = TypeHotel::find($id);
        return view('hotel.type_kamar.edit', compact('type'));
    }
    public function update(Request $request, string $id)
    {
        $request->validate([
            'name' => 'required|string|max:100',
        ]);

        $type = TypeHotel::findOrFail($id);
        $type->update([
            'nama_tipe' => $request->name,
        ]);

        return redirect()->route('hotel.type.index');
    }
    public function destroy(string $id)
    {
        $type = TypeHotel::find($id);
        $type->delete();
        return redirect()->route('hotel.type.index');
    }
}
