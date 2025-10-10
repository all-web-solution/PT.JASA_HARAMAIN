<?php

namespace App\Http\Controllers\Handling;

use App\Http\Controllers\Controller;
use App\Models\GuideItems;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class PendampingController extends Controller
{
    public function index()
    {
        $guides = GuideItems::all();
        return view('handling.pendamping.index', compact('guides'));
    }

    public function create()
    {
        return view('handling.pendamping.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama' => 'required|string|max:255',
            'harga' => 'required|numeric',
            'keterangan' => 'nullable|string|max:500',
        ]);

        GuideItems::create($validated);

        Session::flash('success', 'Pendamping berhasil ditambahkan.');

        return redirect()->route('handling.pendamping.index');
    }

    public function edit(string $id)
    {
        $guide = GuideItems::findOrFail($id);
        return view('handling.pendamping.edit', compact('guide'));
    }

    public function update(Request $request, string $id)
    {
        $validated = $request->validate([
            'nama' => 'required|string|max:255',
            'harga' => 'required|numeric',
            'keterangan' => 'nullable|string|max:500',
        ]);

        $guide = GuideItems::findOrFail($id);
        $guide->update($validated);

        Session::flash('success', 'Pendamping berhasil diperbarui.');

        return redirect()->route('handling.pendamping.index');
    }

    public function destroy(string $id)
    {
        $guide = GuideItems::findOrFail($id);
        $guide->delete();

        Session::flash('success', 'Pendamping berhasil dihapus.');

        return redirect()->route('handling.pendamping.index');
    }

    public function customer()
    {
        $guides = GuideItems::with('service.pelanggan')->get();
        return view('handling.pendamping.customer', compact('guides'));
    }
}
