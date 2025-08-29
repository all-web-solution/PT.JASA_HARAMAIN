<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\Payment;
use App\Models\Transaction;

class PaymentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $transactions = Transaction::all();

        return view('admin.payment.index', compact('transactions'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $orders = Order::all();
        return view('admin.payment.create', compact('orders'));
    }


public function store(Request $request)
{
    $order = Order::findOrFail($request->order_id);

    // ambil total utang dari order
    $utang = $order->total_amount;
    $bayar = $request->total_harga;

    // hitung sisa hutang
    $sisa = $utang - $bayar;
    if ($sisa < 0) {
        $sisa = 0; // kalau bayarnya lebih besar dari utang, sisanya nol
    }

    // simpan ke transaksi
    $transaction = Transaction::create([
        'order_id' => $order->id,
        'invoice_code' => 'INV-' . time(),
        'total_hutang' => $utang,
        'total_yang_di_bayarkan' => $bayar,
        'sisa_hutang' => $sisa,
    ]);

    // update order supaya utangnya jadi sisa terbaru
    $order->update([
        'total_amount' => $sisa,
    ]);

    return redirect()->route('admin.payment');
}






    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
