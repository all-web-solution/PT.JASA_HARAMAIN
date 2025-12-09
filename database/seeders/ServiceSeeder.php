<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use App\Models\Service;
use App\Models\Pelanggan;
use App\Models\Transportation;
use App\Models\TransportationItem;
use App\Models\Route;
use App\Models\Plane;
use App\Models\Hotel;
use App\Models\GuideItems;
use App\Models\Guide;
use App\Models\MealItem;
use App\Models\Meal;
use App\Models\ContentItem;
use App\Models\ContentCustomer;
use App\Models\Dorongan;
use App\Models\DoronganOrder;
use App\Models\Wakaf;
use App\Models\WakafCustomer;
use App\Models\TourItem;
use App\Models\Tour;
use App\Models\Badal;
use App\Models\Document;
use App\Models\DocumentChildren;
use App\Models\CustomerDocument;
use App\Models\Order;

class ServiceSeeder extends Seeder
{
    public function run()
    {
        // 1. Buat / Ambil Dummy Pelanggan
        $pelanggan = Pelanggan::firstOrCreate(
            ['email' => 'travel@example.com'],
            [
                'nama_travel' => 'PT. Travel Sejahtera',
                'penanggung_jawab' => 'H. Ahmad',
                'no_ktp' => '3174123456789012',
                'phone' => '081234567890',
                'alamat' => 'Jl. Kebahagiaan No. 1, Jakarta',
                'status' => 'active',
            ]
        );

        // 2. Buat Dummy Service
        $tanggalBerangkat = Carbon::now()->addDays(30);
        $tanggalPulang = $tanggalBerangkat->copy()->addDays(9); // Paket 9 Hari

        $service = Service::create([
            'unique_code' => 'ID-' . rand(1000, 9999),
            'pelanggan_id' => $pelanggan->id,
            'services' => json_encode([
                'transportasi',
                'hotel',
                'dokumen',
                'handling',
                'pendamping',
                'konten',
                'reyal',
                'tour',
                'meals',
                'dorongan',
                'waqaf',
                'badal'
            ]),
            'tanggal_keberangkatan' => $tanggalBerangkat,
            'tanggal_kepulangan' => $tanggalPulang,
            'total_jamaah' => 45,
            'status' => 'nego',
        ]);

        // ==========================================
        // 3. TRANSPORTASI (Pesawat & Darat)
        // ==========================================

        // A. Pesawat
        Plane::create([
            'service_id' => $service->id,
            'tanggal_keberangkatan' => $tanggalBerangkat,
            'rute' => 'CGK - JED',
            'maskapai' => 'Saudia Airlines',
            'harga' => 12500000,
            'jumlah_jamaah' => 45,
            'keterangan' => 'Direct Flight',
        ]);

        // B. Transportasi Darat (Bus) - Menggunakan Logika Manual Route
        $busMaster = Transportation::firstOrCreate(
            ['nama' => 'Bus Mercedes Benz'],
            ['kapasitas' => 50, 'fasilitas' => 'AC, Toilet, Wifi', 'harga' => 1500000]
        );

        // Simulasi input manual rute
        $routeName = 'Jeddah - Madinah';
        $routePrice = 2500000;

        // Cari/Buat Route sesuai logika Controller terbaru
        $route = Route::firstOrCreate(
            ['transportation_id' => $busMaster->id, 'route' => $routeName, 'price' => $routePrice]
        );

        TransportationItem::create([
            'service_id' => $service->id,
            'transportation_id' => $busMaster->id,
            'route_id' => $route->id,
            'dari_tanggal' => $tanggalBerangkat,
            'sampai_tanggal' => $tanggalBerangkat->copy()->addDay(),
        ]);

        // ==========================================
        // 4. HOTEL
        // ==========================================
        Hotel::create([
            'service_id' => $service->id,
            'nama_hotel' => 'Al Haramin Hotel',
            'tanggal_checkin' => $tanggalBerangkat,
            'tanggal_checkout' => $tanggalBerangkat->copy()->addDays(3),
            'jumlah_kamar' => 12,
            'type' => 'Quad',
            'jumlah_type' => 10,
            'harga_perkamar' => 500000,
            'catatan' => 'Dekat Masjid',
        ]);

        // ==========================================
        // 5. HANDLING
        // ==========================================

        // Hotel Handling
        $handlingHotel = $service->handlings()->create(['name' => 'hotel']);
        $handlingHotel->handlingHotels()->create([
            'nama' => 'Movenpick',
            'tanggal' => $tanggalBerangkat,
            'harga' => 100000,
            'pax' => 45,
            // Field Wajib (dari migration add_kode_barang_table)
            'kode_booking' => 'BOOK-123-DUMMY',
            'rumlis' => 'dummy_rumlis.pdf',
            'identitas_koper' => 'dummy_koper_hotel.jpg',
        ]);

        // Bandara Handling
        $handlingBandara = $service->handlings()->create(['name' => 'bandara']);
        $handlingBandara->handlingPlanes()->create([
            'nama_bandara' => 'King Abdulaziz Intl',
            'jumlah_jamaah' => 45,
            'harga' => 50000,
            'kedatangan_jamaah' => $tanggalBerangkat,
            'nama_supir' => 'Abdullah',
            // Field Wajib (dari migration add_paket_info_table)
            'paket_info' => 'dummy_paket_info.pdf',
            'identitas_koper' => 'dummy_koper_bandara.jpg',
        ]);

        // ==========================================
        // 6. PENDAMPING (Muthowif)
        // ==========================================
        $guideMaster = GuideItems::firstOrCreate(
            ['nama' => 'Ust. Fulan'],
            [
                'harga' => 200000,
                'keterangan' => 'Muthowif Berpengalaman' // Tambahkan field wajib ini
            ]
        );

        Guide::create([
            'service_id' => $service->id,
            'guide_id' => $guideMaster->id,
            'jumlah' => 1,
            'muthowif_dari' => $tanggalBerangkat,
            'muthowif_sampai' => $tanggalPulang,
        ]);

        // ==========================================
        // 7. DOKUMEN
        // ==========================================
        // Dokumen Parent (Misal: Siskopatuh)
        $docSisko = Document::firstOrCreate(['name' => 'Siskopatuh'], ['price' => 50000]);
        CustomerDocument::create([
            'service_id' => $service->id,
            'document_id' => $docSisko->id,
            'jumlah' => 45,
            'harga' => 50000,
        ]);

        // Dokumen Child (Misal: Visa Umrah)
        $docVisa = Document::firstOrCreate(['name' => 'Visa'], ['price' => 0]); // Parent 0
        $childVisa = DocumentChildren::firstOrCreate(
            ['document_id' => $docVisa->id, 'name' => 'Visa Umrah'],
            ['price' => 1500000]
        );

        CustomerDocument::create([
            'service_id' => $service->id,
            'document_id' => $docVisa->id,
            'document_children_id' => $childVisa->id,
            'jumlah' => 45,
            'harga' => 1500000,
        ]);

        // ==========================================
        // 8. LAIN-LAIN (Meals, Tour, Konten, Reyal, Badal)
        // ==========================================

        // Meals
        $mealMaster = MealItem::firstOrCreate(['name' => 'Nasi Box Arab'], ['price' => 25000]);
        Meal::create([
            'service_id' => $service->id,
            'meal_id' => $mealMaster->id,
            'jumlah' => 45 * 3, // 3 hari
            'dari_tanggal' => $tanggalBerangkat,
            'sampai_tanggal' => $tanggalBerangkat->copy()->addDays(2),
        ]);

        // Tour
        $tourMaster = TourItem::firstOrCreate(['name' => 'Ziarah Madinah']);
        Tour::create([
            'service_id' => $service->id,
            'tour_id' => $tourMaster->id,
            'transportation_id' => $busMaster->id,
            'tanggal_keberangkatan' => $tanggalBerangkat->copy()->addDays(2),
        ]);

        // Konten
        $contentMaster = ContentItem::firstOrCreate(['name' => 'Dokumentasi Video'], ['price' => 2000000]);
        ContentCustomer::create([
            'service_id' => $service->id,
            'content_id' => $contentMaster->id,
            'jumlah' => 1,
            'tanggal_pelaksanaan' => $tanggalBerangkat,
            'keterangan' => 'Shooting di Jabal Rahmah',
        ]);

        // Reyal (Exchange)
        $service->exchanges()->create([
            'tipe' => 'tamis',
            'jumlah_input' => 10000000, // IDR
            'kurs' => 4200,
            'hasil' => 2380.95, // SAR
            'tanggal_penyerahan' => $tanggalBerangkat->subDays(1),
        ]);

        // Badal Umrah
        Badal::create([
            'service_id' => $service->id,
            'name' => 'Alm. Bpk. Fulan',
            'price' => 2500000,
            'tanggal_pelaksanaan' => $tanggalBerangkat->addDays(4),
        ]);

        // Dorongan (Kursi Roda)
        $doronganMaster = Dorongan::firstOrCreate(['name' => 'Kursi Roda'], ['price' => 300000]);
        DoronganOrder::create([
            'service_id' => $service->id,
            'dorongan_id' => $doronganMaster->id,
            'jumlah' => 2,
            'tanggal_pelaksanaan' => $tanggalBerangkat,
        ]);

        // Wakaf
        $wakafMaster = Wakaf::firstOrCreate(['nama' => 'Wakaf Al-Quran'], ['harga' => 100000]);
        WakafCustomer::create([
            'service_id' => $service->id,
            'wakaf_id' => $wakafMaster->id,
            'jumlah' => 10,
        ]);

        // 9. Buat Dummy Order (Keuangan)
        Order::create([
            'service_id' => $service->id,
            'invoice' => 'INV-' . time(),
            'total_estimasi' => 500000000, // Dummy total
            'total_amount_final' => 500000000,
            'total_yang_dibayarkan' => 100000000,
            'sisa_hutang' => 400000000,
            'status_pembayaran' => 'belum_bayar',
            'status_harga' => 'fix',
        ]);

        $this->command->info('Service Dummy Berhasil Dibuat! ID: ' . $service->id);
    }
}
