<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Pelanggan;
use App\Models\Service;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function index()
    {
        $orders = Order::paginate(10);
        return view('admin.order.index', compact('orders'));
    }

    public function create()
    {

        $travalers = Service::all();
        return view('admin.order.create', compact('travalers'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'pelanggan_id' => 'required|exists:pelanggans,id',
            'total_harga'  => 'required|numeric|min:0',
        ]);

        // cek apakah customer sudah ada order
        $order = Order::where('service_id', $request->pelanggan_id)->first();

        if ($order) {
            // kalau sudah ada → tambahin utangnya
            $order->total_amount += $request->total_harga;
            $order->save();
        } else {
            // kalau belum ada → buat order baru
            $order = Order::create([
                'service_id'   => $request->pelanggan_id,
                'total_amount' => $request->total_harga,
            ]);
        }

        return redirect()->route('admin.order')->with('success', 'Order berhasil disimpan');
    }

    public function edit($id)
    {
        $order = Order::find($id);
        $travalers = Pelanggan::all();
        return view('admin.order.edit', compact('order', 'travalers'));
    }

    public function update(Request $request, $id)
    {
        $order = Order::find($id);
        $order->update([
            'service_id' => Service::find($request->pelanggan_id)->id,
            'total_amount' => $request->total_harga,
        ]);

        return redirect()->route('admin.order');
    }

    public function destroy($id)
    {
        $order = Order::find($id);
        $order->delete();

        return redirect()->route('admin.order');
    }
}
