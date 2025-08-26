<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\Payment;

class PaymentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $payments = Payment::all();
        return view('admin.payment.index', compact('payments'));
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
        // Cari order
        $order = Order::findOrFail($request->order_id);

        // Hitung total pembayaran yang sudah pernah dilakukan
        $totalPaidSoFar = Payment::where('order_id', $order->id)->sum('paid_amount');

        // Tambahkan pembayaran baru
        $newPayment = (float) $request->total_harga;

        // Hitung total dibayar setelah pembayaran baru
        $totalPaid = $totalPaidSoFar + $newPayment;

        // Hitung sisa utang
        $outstandingDebt = $order->total_amount - $totalPaid;
        $status = 'unpaid';
        if ($totalPaid == 0) {
            $status = 'unpaid';
        } elseif ($totalPaid < $order->total_amount) {
            $status = 'partial';
        } elseif ($totalPaid >= $order->total_amount) {
            $status = 'paid';
        }

        $payment = Payment::create([
            'invoice'      => 'INV-' . time(),
            'order_id'     => $order->id,
            'total_amount' => $order->total_amount,
            'paid_amount'  => $newPayment,
            'status'       => $status,
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
