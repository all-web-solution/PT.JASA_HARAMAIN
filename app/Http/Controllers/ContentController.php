<?php

namespace App\Http\Controllers;

use App\Models\ContentCustomer;
use App\Models\ContentItem;
use App\Models\Pelanggan;
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
    $customers = \App\Models\Pelanggan::query()
        ->join('services', 'pelanggans.id', '=', 'services.pelanggan_id')
        ->join('content_customers', 'services.id', '=', 'content_customers.service_id')
        ->join('content_items', 'content_customers.content_id', '=', 'content_items.id')
        ->selectRaw('
            pelanggans.id,
            pelanggans.nama_travel,

            /* Gunakan GROUP_CONCAT untuk menggabungkan semua status */
            GROUP_CONCAT(DISTINCT content_customers.status SEPARATOR ", ") as all_statuses,

            SUM(content_customers.jumlah) as total_jumlah,
            GROUP_CONCAT(content_items.name SEPARATOR ", ") as all_contents,
            GROUP_CONCAT(IFNULL(content_customers.keterangan, "Tidak ada") SEPARATOR "; ") as all_keterangan
        ')
        // Anda perlu menambahkan 'status' ke group by jika tidak menggunakan agregat
        ->groupBy('pelanggans.id', 'pelanggans.nama_travel')
        ->paginate(10);

    return view('dokumentasi.customer', compact('customers'));
}
 public function showCustomerDetail($id)
    {
        $customer = Pelanggan::findOrFail($id);
        // Eager load relasi yang dibutuhkan agar tidak terjadi query N+1
        // Memuat services, lalu contents (pivot), lalu detail content (dari content_items)
        $customer->load('services.contents.content');

        return view('dokumentasi.customer-detail', compact('customer'));
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
}
