<?php

namespace App\Http\Controllers;

use App\Models\DoronganOrder;
use Illuminate\Http\Request;
use App\Models\Dorongan;
use Illuminate\Support\Facades\Session;

class DoronganController extends Controller
{
    public function index()
    {
        $items = Dorongan::with('dorongans')->get();

        return view('palugada.dorongan.index', compact('items'));
    }

    public function create()
    {
        return view('palugada.dorongan.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
        ]);

        Dorongan::create([
            'name' => $request->name,
            'price' => $request->price
        ]);

        Session::flash('success', 'Dorongan created successfully!');

        return redirect()->route('dorongan.index');
    }

    public function customer()
    {
        $data = DoronganOrder::with('dorongan')->get();

        return view('palugada.dorongan.customer', compact('data'));
    }

    public function edit(string $id)
    {
        $item = Dorongan::findOrFail($id);
        return view('palugada.dorongan.edit', compact('item'));
    }

    public function update(Request $request, string $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
        ]);

        $item = Dorongan::findOrFail($id);
        $item->update([
            'name' => $request->name,
            'price' => $request->price
        ]);

        Session::flash('success', 'Dorongan updated successfully!');

        return redirect()->route('dorongan.index');
    }

    public function destroy(string $id)
    {
        $item = Dorongan::findOrFail($id);
        $item->delete();

        Session::flash('success', 'Dorongan deleted successfully!');

        return redirect()->route('dorongan.index');
    }
}
