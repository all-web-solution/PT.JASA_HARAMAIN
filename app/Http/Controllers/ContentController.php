<?php

namespace App\Http\Controllers;

use App\Models\ContentCustomer;
use App\Models\ContentItem;
use App\Models\Pelanggan;
use App\Models\Service;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
class ContentController extends Controller
{

    public function index(){
        $contents = ContentItem::all();
        return view('dokumentasi.index', compact('contents'));
    }

    public function create(){
        return view('dokumentasi.create');
    }

    public function store(Request $request){
        ContentItem::create([
            'name' => $request->nama,
            'price' => $request->harg
        ]);
        return redirect()->route('content.index');


    }

    public function edit($id){
        $content = ContentItem::find($id);
        return view('dokumentasi.edit', compact('content'));
    }

    public function update($id, Request $request){
        $content = ContentItem::find($id);
        $content->update([
            'name' => $request->nama,
            'price' => $request->harga
        ]);
         return redirect()->route('content.index');
    }

    public function destroy($id){
        $content = ContentItem::find($id);
        $content->delete();
         return redirect()->route('content.index');
    }

    public function customer()
    {
        $customers = ContentCustomer::query()

            // 2. Gunakan "Eager Loading" untuk mengambil relasi
            ->with([
                'content',          // <-- Mengambil data dari ContentItem (relasi content())
                'service.pelanggan' // <-- Mengambil data Service, DAN data Pelanggan-nya
            ])

            // 3. Urutkan berdasarkan data terbaru (opsional)
            ->latest()

            // 4. Gunakan pagination
            ->paginate(10); // (Anda bisa ganti 15 dengan jumlah item per halaman)

        return view('dokumentasi.customer', compact('customers'));
    }

    public function showCustomerDetail($id)
    {
        $customer = Pelanggan::findOrFail($id);
        // Eager load relasi yang dibutuhkan agar tidak terjadi query N+1
        // Memuat services, lalu contents (pivot), lalu detail content (dari content_items)
        $customer->load('services.contents.content');

        return view('dokumentasi.customer_detail', compact('customer'));
    }

    public function showContentItemDetail($id)
    {
        // Cari ContentCustomer berdasarkan ID-nya,
        // lalu load relasinya agar efisien (Eager Loading)
        $contentCustomer = ContentCustomer::with(['service.pelanggan', 'content'])->findOrFail($id);

        // Kirim data ke view detail (yang sudah kita buat di chat sebelumnya)
        // Asumsi nama file: resources/views/dokumentasi/content/detail.blade.php
        return view('dokumentasi.content_detail', [
            'contentCustomer' => $contentCustomer
        ]);
    }

    public function editCustomer(ContentCustomer $contentCustomer) // Gunakan Route-Model Binding
    {
        // Ambil data untuk dropdown
        $services = Service::with('pelanggan')->get();
        $contentItems = ContentItem::all();

        $statuses = ['nego', 'deal', 'batal', 'tahap persiapan', 'tahap produksi', 'done'];

        return view('dokumentasi.customer_edit', compact(
            'contentCustomer',
            'services',
            'contentItems',
            'statuses'
        ));
    }

    public function updateCustomer(Request $request, ContentCustomer $contentCustomer)
    {
        // 1. Validasi
        $validated = $request->validate([
            'keterangan' => 'nullable|string',
            'status' => 'required|string',
            'supplier' => 'nullable|string|max:255',
            'harga_dasar' => 'required|numeric|min:0',
            'harga_jual' => 'required|numeric|min:0|gte:harga_dasar', // gte = greater than or equal
        ]);

        // 2. Update data
        $contentCustomer->update($validated);

        // 3. Redirect kembali ke index dengan pesan sukses
        return redirect()->route('content.customer') // Asumsi 'customer.index' adalah nama route index Anda
                         ->with('success', 'Order Konten berhasil diperbarui!');
    }

     public function setStatusPending(Pelanggan $customer)
    {
        $this->updateAllContentStatus($customer, 'pending');
        return redirect()->back()->with('success', 'Semua status konten berhasil diubah menjadi Pending.');
    }

    public function setStatusSelesai(Pelanggan $customer)
    {
        $this->updateAllContentStatus($customer, 'success');
        return redirect()->back()->with('success', 'Semua status konten berhasil diubah menjadi Selesai.');
    }

    public function setStatusBatal(Pelanggan $customer)
    {
        $this->updateAllContentStatus($customer, 'cancled');
        return redirect()->back()->with('success', 'Semua status konten berhasil dibatalkan.');
    }

    /**
     * Private helper function untuk mengubah status semua konten milik customer.
     */
    private function updateAllContentStatus(Pelanggan $customer, string $newStatus)
    {
        // Ambil semua service_id milik customer ini
        $serviceIds = $customer->services()->pluck('id');

        // Update semua status di tabel content_customers yang terkait dengan service_id tersebut
        DB::table('content_customers')
            ->whereIn('service_id', $serviceIds)
            ->update(['status' => $newStatus]);
    }




    public function showSupplier($id)
    {
        $content = ContentCustomer::findOrFail($id);
        return view('dokumentasi.supplier', compact('content'));
    }
    public function createSupplier($id)
    {
        $content = ContentCustomer::findOrFail($id);
        return view('dokumentasi.supplier_create', compact('content'));
    }

    public function storeSupplier(Request $request, $id)
    {

        $content = ContentCustomer::findOrFail($id);
        $content->supplier = $request->input('name');
        $content->harga_dasar = $request->input('price');
        $content->save();
        return redirect()->route('content.supplier', $id);
    }
}
