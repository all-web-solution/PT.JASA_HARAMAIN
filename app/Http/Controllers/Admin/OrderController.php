<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Pelanggan;
use App\Models\Service;
use App\Models\UploadPayment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

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

    public function payment_proff(Order $order)
    {
        $paymentPreff = UploadPayment::where('order_id', $order->id)->get();
        return view('admin.order.payment_proff', compact('paymentPreff', 'order'));
    }
    public function payment_proff_create(Order $order)
    {
        return view('admin.order.payment_proff_create', compact('order'));
    }


 // Baik untuk debugging

public function payment_proff_store(Request $request, Order $order)
{
    // 1. Validasi Input (WAJIB)
    // Ini memperbaiki bug 'Undefined variable' dan mengamankan upload
    $validated = $request->validate([
        'foto' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048', // Wajib, harus gambar, max 2MB
    ]);

    $path = null; // Inisialisasi $path

    try {
        // 2. Simpan file di dalam subfolder 'payment_proofs'
        if ($request->hasFile('foto')) {
            // Ini akan menyimpan file di: storage/app/public/payment_proofs
            $path = $request->file('foto')->store('payment_proofs', 'public');
           
        }

        // 3. Buat entri database
        // Gunakan nama kolom yang konsisten.
        // Di Blade Anda sebelumnya: payment_proff
        // Di sini (dan sepertinya lebih benar): payment_proof
        $order->uploadPayments()->create([
            'payment_proof' => $path,
        ]);

        return redirect()->route('payment.proff', $order->id)->with('success', 'Bukti pembayaran berhasil ditambahkan');

    } catch (\Exception $e) {
        // Jika terjadi error saat simpan database atau file
        Log::error('Gagal upload bukti bayar: ' . $e->getMessage());
        return redirect()->back()->with('error', 'Terjadi kesalahan. Gagal menambahkan bukti pembayaran.');
    }
}
}
