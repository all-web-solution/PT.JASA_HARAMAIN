<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ContentCustomer;
use App\Models\ContentItem;
use Carbon\Carbon;
use App\Models\File;
use App\Models\Guide;
use App\Models\GuideItems;
use App\Models\Hotel;
use App\Models\Meal;
use App\Models\Pelanggan;
use App\Models\Document;
use App\Models\Service;
use App\Models\Plane;
use App\Models\Tour;
use App\Models\Transportation;
use App\Models\TransportationItem;
use App\Models\TransportationOrder;
use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\TourItem;
use App\Models\MealItem;
use App\Models\Document as DocumentModel;
use App\Models\CustomerDocument;
use App\Models\Wakaf;
use App\Models\Dorongan;
use App\Models\DoronganOrder;
use App\Models\TypeHotel;
use Illuminate\Support\Facades\DB;
use App\Models\Badal;
use App\Models\DocumentChildren;
use App\Models\HandlingHotel;
use App\Models\HandlingPlanes;
use App\Models\WakafCustomer;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class ServicesController extends Controller
{
    /**
     * Tampilkan daftar layanan.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\View\View
     */
    public function index(Request $request)
    {
        $query = Service::query();
        $services = $query->latest()->paginate(10);

        $countBadalNego = \App\Models\Badal::where('status', 'nego')->count();
        $countContentCustomerNego = \App\Models\ContentCustomer::where('status', 'nego')->count();
        $countCustomerDocumentNego = \App\Models\CustomerDocument::where('status', 'nego')->count();
$countDoronganOrderNego = \App\Models\DoronganOrder::where('status', 'nego')->count();
$countExchangeNego = \App\Models\Exchange::where('status', 'nego')->count(); // Corrected typo: Exchange
$countGuideNego = \App\Models\Guide::where('status', 'nego')->count();
$countHandlingHotelNego = \App\Models\HandlingHotel::where('status', 'nego')->count();
$countHandlingPlaneNego = \App\Models\HandlingPlanes::where('status', 'nego')->count();
$countHotelNego = \App\Models\Hotel::where('status', 'nego')->count();
$countMealNego = \App\Models\Meal::where('status', 'nego')->count();
$countPlaneNego = \App\Models\Plane::where('status', 'nego')->count();
$countTourNego = \App\Models\Tour::where('status', 'nego')->count();
$countTransportationItemNego = \App\Models\TransportationItem::where('status', 'nego')->count();
$countWakafCustomerNego = \App\Models\WakafCustomer::where('status', 'nego')->count();

        $totalNegoOverall =
    $countBadalNego +
    $countContentCustomerNego +
    $countCustomerDocumentNego +
    $countDoronganOrderNego +
    $countExchangeNego +
    $countGuideNego +
    $countHandlingHotelNego +
    $countHandlingPlaneNego +
    $countHotelNego +
    $countMealNego +
    $countPlaneNego +
    $countTourNego +
    $countTransportationItemNego +
    $countWakafCustomerNego;

        $countBadalPersiapan = \App\Models\Badal::where('status', 'tahap persiapan')->count();
$countContentCustomerPersiapan = \App\Models\ContentCustomer::where('status', 'tahap persiapan')->count();
$countCustomerDocumentPersiapan = \App\Models\CustomerDocument::where('status', 'tahap persiapan')->count();
$countDoronganOrderPersiapan = \App\Models\DoronganOrder::where('status', 'tahap persiapan')->count();
$countExchangePersiapan = \App\Models\Exchange::where('status', 'tahap persiapan')->count();
$countGuidePersiapan = \App\Models\Guide::where('status', 'tahap persiapan')->count();
        $countHandlingHotelPersiapan = \App\Models\HandlingHotel::where('status', 'tahap persiapan')->count();

$countHandlingPlanePersiapan = \App\Models\HandlingPlanes::where('status', 'tahap persiapan')->count();
$countHotelPersiapan = \App\Models\Hotel::where('status', 'tahap persiapan')->count();
$countMealPersiapan = \App\Models\Meal::where('status', 'tahap persiapan')->count();
$countPlanePersiapan = \App\Models\Plane::where('status', 'tahap persiapan')->count();
$countTourPersiapan = \App\Models\Tour::where('status', 'tahap persiapan')->count();
$countTransportationItemPersiapan = \App\Models\TransportationItem::where('status', 'tahap persiapan')->count();
$countWakafCustomerPersiapan = \App\Models\WakafCustomer::where('status', 'tahap persiapan')->count();

// Menjumlahkan semua hitungan 'tahap persiapan'
$totalPersiapanOverall =
    $countBadalPersiapan +
    $countContentCustomerPersiapan +
    $countCustomerDocumentPersiapan +
    $countDoronganOrderPersiapan +
    $countExchangePersiapan +
    $countGuidePersiapan +
    $countHandlingHotelPersiapan + // Sertakan hitungan HandlingHotel yang sudah ada
    $countHandlingPlanePersiapan +
    $countHotelPersiapan +
    $countMealPersiapan +
    $countPlanePersiapan +
    $countTourPersiapan +
    $countTransportationItemPersiapan +
    $countWakafCustomerPersiapan;

    // --- Hitung Status 'tahap_produksi' ---
$countBadalProduksi = \App\Models\Badal::where('status', 'tahap_produksi')->count();
$countContentCustomerProduksi = \App\Models\ContentCustomer::where('status', 'tahap_produksi')->count();
$countCustomerDocumentProduksi = \App\Models\CustomerDocument::where('status', 'tahap_produksi')->count();
$countDoronganOrderProduksi = \App\Models\DoronganOrder::where('status', 'tahap_produksi')->count();
$countExchangeProduksi = \App\Models\Exchange::where('status', 'tahap_produksi')->count();
$countGuideProduksi = \App\Models\Guide::where('status', 'tahap_produksi')->count();
$countHandlingHotelProduksi = \App\Models\HandlingHotel::where('status', 'tahap_produksi')->count();
$countHandlingPlaneProduksi = \App\Models\HandlingPlanes::where('status', 'tahap_produksi')->count();
$countHotelProduksi = \App\Models\Hotel::where('status', 'tahap_produksi')->count();
$countMealProduksi = \App\Models\Meal::where('status', 'tahap_produksi')->count();
$countPlaneProduksi = \App\Models\Plane::where('status', 'tahap_produksi')->count();
$countTourProduksi = \App\Models\Tour::where('status', 'tahap_produksi')->count();
$countTransportationItemProduksi = \App\Models\TransportationItem::where('status', 'tahap_produksi')->count();
$countWakafCustomerProduksi = \App\Models\WakafCustomer::where('status', 'tahap_produksi')->count();

// Jumlahkan semua hitungan 'tahap_produksi'
$totalProduksiOverall =
    $countBadalProduksi +
    $countContentCustomerProduksi +
    $countCustomerDocumentProduksi +
    $countDoronganOrderProduksi +
    $countExchangeProduksi +
    $countGuideProduksi +
    $countHandlingHotelProduksi +
    $countHandlingPlaneProduksi +
    $countHotelProduksi +
    $countMealProduksi +
    $countPlaneProduksi +
    $countTourProduksi +
    $countTransportationItemProduksi +
    $countWakafCustomerProduksi;

// --- Hitung Status 'done' ---
$countBadalDone = \App\Models\Badal::where('status', 'done')->count();
$countContentCustomerDone = \App\Models\ContentCustomer::where('status', 'done')->count();
$countCustomerDocumentDone = \App\Models\CustomerDocument::where('status', 'done')->count();
$countDoronganOrderDone = \App\Models\DoronganOrder::where('status', 'done')->count();
$countExchangeDone = \App\Models\Exchange::where('status', 'done')->count();
$countGuideDone = \App\Models\Guide::where('status', 'done')->count();
$countHandlingHotelDone = \App\Models\HandlingHotel::where('status', 'done')->count();
$countHandlingPlaneDone = \App\Models\HandlingPlanes::where('status', 'done')->count();
$countHotelDone = \App\Models\Hotel::where('status', 'done')->count();
$countMealDone = \App\Models\Meal::where('status', 'done')->count();
$countPlaneDone = \App\Models\Plane::where('status', 'done')->count();
$countTourDone = \App\Models\Tour::where('status', 'done')->count();
$countTransportationItemDone = \App\Models\TransportationItem::where('status', 'done')->count();
$countWakafCustomerDone = \App\Models\WakafCustomer::where('status', 'done')->count();

// Jumlahkan semua hitungan 'done'
$totalDoneOverall =
    $countBadalDone +
    $countContentCustomerDone +
    $countCustomerDocumentDone +
    $countDoronganOrderDone +
    $countExchangeDone +
    $countGuideDone +
    $countHandlingHotelDone +
    $countHandlingPlaneDone +
    $countHotelDone +
    $countMealDone +
    $countPlaneDone +
    $countTourDone +
    $countTransportationItemDone +
    $countWakafCustomerDone;

        return view('admin.services.index', compact('services', 'totalNegoOverall', 'totalPersiapanOverall', 'totalProduksiOverall', 'totalDoneOverall'));
    }


    public function create()
    {
        $data = [
            'pelanggans' => Pelanggan::all(),
            'transportations' => Transportation::all(),
            'guides' => GuideItems::all(),
            'tours' => TourItem::all(),
            'meals' => MealItem::all(),
            'documents' => DocumentModel::with('childrens')->get(),
            'wakaf' => Wakaf::all(),
            'dorongan' => Dorongan::all(),
            'contents' => ContentItem::all(),
            'types' => TypeHotel::all(),
        ];

        return view('admin.services.create', $data);
    }


    public function store(Request $request)
    {
        $request->validate([
            'travel' => 'required|exists:pelanggans,id',
            'services' => 'required|array',
            'tanggal_keberangkatan' => 'required|date',
            'tanggal_kepulangan' => 'required|date',
            'total_jamaah' => 'required|integer',
        ]);

        $masterPrefix = 'ID';
        $lastService = Service::where('unique_code', 'like', $masterPrefix . '-%')
            ->orderByDesc('id')
            ->first();
        $lastNumber = $lastService ? (int) explode('-', $lastService->unique_code)[1] : 0;
        $uniqueCode = $masterPrefix . '-' . ($lastNumber + 1);
        $status = $request->input('action') === 'nego' ? 'nego' : 'deal';

        $service = Service::create([
            'pelanggan_id' => $request->travel,
            'services' => json_encode($request->services),
            'tanggal_keberangkatan' => $request->tanggal_keberangkatan,
            'tanggal_kepulangan' => $request->tanggal_kepulangan,
            'total_jamaah' => $request->total_jamaah,
            'status' => $status,
            'unique_code' => $uniqueCode,
        ]);

        $this->processServiceItems($request, $service);

        // ----------------------------------------------------
    // 🔒 HITUNG ULANG TOTAL DI SERVER SETELAH ITEM DISIMPAN
    // ----------------------------------------------------
    $serverTotalAmount = 0;

    // Muat ulang (refresh) relasi yang baru saja disimpan/diperbarui
    // Ini penting agar kita mendapatkan data yang paling akurat dari database
    $service->load([
        'documents', // Relasi ke CustomerDocument
        'hotels',    // Relasi ke Hotel
        'badals',    // Relasi ke Badal
        'meals',     // Relasi ke MealCustomer (atau nama relasi Anda)
        'guides',    // Relasi ke GuideCustomer (atau nama relasi Anda)
        'tours',     // Relasi ke TourCustomer (atau nama relasi Anda)
        'wakafs',    // Relasi ke WakafCustomer
        'dorongans.dorongan', // Relasi ke DoronganOrder
        'contents',  // Relasi ke ContentCustomer
        // Tambahkan relasi lain yang relevan di sini
    ]);

    $service->loadMissing(['transportationItem.transportation', 'transportationItem.route']);

foreach ($service->transportationItem as $item) {
    // Safety check: pastikan relasi & tanggal ada
    if ($item->transportation && $item->route && $item->dari_tanggal && $item->sampai_tanggal) {

        try {
            // 1. Ambil harga dasar per hari dari Tipe Transportasi
            $hargaPerHari = $item->transportation->harga ?? 0;

            // 2. Ambil harga tambahan rute (jika ada)
            $hargaRute = $item->route->price ?? 0; // Sesuaikan 'price' jika nama kolomnya beda

            // 3. Hitung jumlah hari penggunaan
            $tanggalMulai = Carbon::parse($item->dari_tanggal);
            $tanggalSelesai = Carbon::parse($item->sampai_tanggal);

            // diffInDays menghitung selisih hari. Jika sama, hasilnya 0.
            // Tambah 1 untuk mendapatkan jumlah hari penggunaan (inklusif).
            // Cth: 25 Okt - 25 Okt = 0 hari selisih -> jadi 1 hari penggunaan.
            // Cth: 26 Okt - 25 Okt = 1 hari selisih -> jadi 2 hari penggunaan.
            $jumlahHari = $tanggalMulai->diffInDays($tanggalSelesai) + 1;

            // 4. Kalkulasi subtotal untuk item ini
            // (Harga per hari * Jumlah Hari) + Harga Rute (jika ada)
            $subTotalDarat = ( ($hargaPerHari * $jumlahHari) + $hargaRute );

            // 5. Tambahkan ke total server
            $serverTotalAmount += $subTotalDarat;

        } catch (\Exception $e) {
            // Tangani jika format tanggal salah/invalid
            // info("Error calculating transport cost: " . $e->getMessage());
        }
    }
}

    // Kalkulasi Harga Dokumen
    foreach ($service->documents as $doc) {
        // Asumsi: CustomerDocument punya kolom 'harga' & 'jumlah'
        $serverTotalAmount += ($doc->harga ?? 0) * ($doc->jumlah ?? 0);
    }

    foreach ($service->hotels as $hotel) {

    // Safety check: pastikan kolom-kolom ada isinya
    if ($hotel->tanggal_checkin && $hotel->tanggal_checkout && $hotel->harga_perkamar > 0 && $hotel->jumlah_type > 0) {

        try {
            // 1. Ubah string tanggal menjadi objek Carbon
            $checkin = Carbon::parse($hotel->tanggal_checkin);
            $checkout = Carbon::parse($hotel->tanggal_checkout);

            // 2. Hitung jumlah malam.
            // diffInDays() adalah cara paling aman. Cth: checkout 25 - checkin 22 = 3 hari
            $jumlah_malam = $checkin->diffInDays($checkout);

            // 3. Jika jumlah malam adalah 0 (misal checkin/checkout di hari yg sama),
            // kita anggap itu minimal 1 malam.
            if ($jumlah_malam <= 0) {
                $jumlah_malam = 1;
            }

            // 4. Kalkulasi subtotal untuk baris ini
            $subTotalHotel = ($hotel->harga_perkamar * $hotel->jumlah_type) * $jumlah_malam;

            // 5. Tambahkan ke total server
            $serverTotalAmount += $subTotalHotel;

        } catch (\Exception $e) {
            // Tangani jika format tanggal salah/invalid, log error jika perlu
            // info($e->getMessage());
        }
    }
}

    // Kalkulasi Harga Badal
    foreach ($service->badals as $badal) {
        $serverTotalAmount += $badal->price ?? 0; // Asumsi: Badal punya kolom 'price'
    }

    // Kalkulasi Harga Meals
    foreach ($service->meals as $mealCustomer) { // Asumsi relasi namanya 'meals' -> MealCustomer
        // Asumsi: MealCustomer punya relasi 'mealItem' ke MealItem yg punya 'price'
        // dan MealCustomer punya kolom 'jumlah'
        $serverTotalAmount += ($mealCustomer->mealItem->price ?? 0) * ($mealCustomer->jumlah ?? 0); // Sesuaikan nama relasi/kolom
    }

    // Kalkulasi Harga Guides (Pendamping)
    foreach ($service->guides as $guideCustomer) { // Asumsi relasi namanya 'guides' -> GuideCustomer
        // Asumsi: GuideCustomer punya relasi 'guideItem' ke GuideItems yg punya 'harga'
        // dan GuideCustomer punya kolom 'jumlah'
        $serverTotalAmount += ($guideCustomer->guideItem->harga ?? 0) * ($guideCustomer->jumlah ?? 0); // Sesuaikan nama relasi/kolom
    }

    // Kalkulasi Harga Tours
    foreach ($service->tours as $tour) { // $tour adalah instance Model Tour
    // Ambil harga dari relasi (gunakan casting float untuk keamanan)
    $tourPrice = (float) ($tour->tourItem->price ?? 0); // Harga dasar tour (dari TourItem)
    $transportPrice = (float) ($tour->transportation->harga ?? 0); // Harga transport (dari Transportation)

    // Tambahkan ke total server
    $serverTotalAmount += ($tourPrice + $transportPrice);
}

    // Kalkulasi Harga Wakaf
    foreach ($service->wakafs as $wakafCustomer) { // Asumsi relasi namanya 'wakafs' -> WakafCustomer
         // Asumsi: WakafCustomer punya relasi 'wakafItem' ke Wakaf yg punya 'harga'
         // dan WakafCustomer punya kolom 'jumlah'
        $serverTotalAmount += ($wakafCustomer->wakaf->harga ?? 0) * ($wakafCustomer->jumlah ?? 0); // Sesuaikan nama relasi/kolom
    }

     // Kalkulasi Harga Dorongan
    foreach ($service->dorongans as $doronganOrder) { // Asumsi relasi namanya 'dorongans' -> DoronganOrder
         // Asumsi: DoronganOrder punya relasi 'doronganItem' ke Dorongan yg punya 'price'
         // dan DoronganOrder punya kolom 'jumlah'
        $serverTotalAmount += ($doronganOrder->dorongan->price ?? 0) * ($doronganOrder->jumlah ?? 0); // Sesuaikan nama relasi/kolom
    }

     // Kalkulasi Harga Content
    foreach ($service->contents as $contentCustomer) { // Asumsi relasi namanya 'contents' -> ContentCustomer
         // Asumsi: ContentCustomer punya relasi 'contentItem' ke ContentItem yg punya 'price'
         // dan ContentCustomer punya kolom 'jumlah'
        $serverTotalAmount += ($contentCustomer->content->price ?? 0) * ($contentCustomer->jumlah ?? 0); // Sesuaikan nama relasi/kolom
    }

    // ... Tambahkan kalkulasi untuk item lain jika ada (misal: Handling, Reyal jika ada biayanya) ...

    // ----------------------------------------------------
    // BUAT ORDER DENGAN TOTAL YANG AMAN DARI SERVER
    // ----------------------------------------------------
    // Hapus baris lama: $totalAmount = (float) $request->input('total_amount', 0);
    Order::create([
        'service_id' => $service->id,
        'total_amount' => $serverTotalAmount, // <-- Gunakan hasil perhitungan server
        'invoice' => 'INV-' . time(),
        'total_yang_dibayarkan' => 0,
        'sisa_hutang' => $serverTotalAmount, // <-- Gunakan hasil perhitungan server
        'status_pembayaran' => $serverTotalAmount == 0 ? 'lunas' : 'belum_bayar',
    ]);

    // ... (Redirect seperti sebelumnya) ...
    return redirect()->route('admin.services')->with('success', 'Data service berhasil disimpan.');
}

        // Buat order
        // $totalAmount = (float) $request->input('total_amount', 0);
        // Order::create([
        //     'service_id' => $service->id,
        //     'total_amount' => $totalAmount,
        //     'invoice' => 'INV-' . time(),
        //     'total_yang_dibayarkan' => 0,
        //     'sisa_hutang' => $totalAmount,
        //     'status_pembayaran' => $totalAmount == 0 ? 'lunas' : 'belum_bayar',
        // ]);
        // if ($status === 'deal') {
        //     return redirect()->route('service.uploadBerkas', [
        //         'service_id' => $service->id,
        //         'total_jamaah' => $request->total_jamaah,
        //     ])->with('success', 'Data service berhasil disimpan.');
        // }
        // return redirect()->route('admin.services')->with('success', 'Data nego berhasil diperbarui.');




    public function show($id)
    {
        // Muat SEMUA relasi yang dibutuhkan oleh view 'show.blade.php'
        $service = Service::with([
            'pelanggan',

            // Transportasi (Udara & Darat)
            'planes', // Sesuaikan jika nama relasi berbeda
            'transportationItem.transportation', // Master Transportasi
            'transportationItem.route',          // Master Rute

            // Hotel
            'hotels', // Eager load relasi hotels dari Service

            // Dokumen
            'documents.document',      // Relasi ke master Document
            'documents.documentChild', // Relasi ke master DocumentChildren

            // Handling & detailnya
            'handlings.handlingHotels',
            'handlings.handlingPlanes',

            // Pendamping & detailnya
            'guides.guideItem', // Asumsi relasi guideItem di model Guide

            // Konten & detailnya
            'contents.content', // Asumsi relasi content di model ContentCustomer

            // Reyal
            'reyals', // Asumsi nama relasi reyals()

            // Tour & detailnya
            'tours.tourItem', // Asumsi relasi tourItem di model Tour
            'tours.transportation', // Asumsi relasi transportation di model Tour

            // Meals & detailnya
            'meals.mealItem', // Asumsi relasi mealItem di model Meal

            // Dorongan & detailnya
            'dorongans.dorongan', // Asumsi relasi dorongan di model DoronganOrder

            // Wakaf & detailnya
            'wakafs.wakaf', // Asumsi relasi wakaf di model WakafCustomer

            // Badal Umrah
            'badals',

        ])->findOrFail($id);
        return view('admin.services.show', compact('service'));
    }


    public function nego($id)
    {
        // Eager load semua relasi yang mungkin dibutuhkan di view
        $service = Service::with([
            'pelanggan',
            'planes',
            'transportationItem.transportation.routes',
            'transportationItem.route',
            'hotels', // Asumsi ada relasi hotels() di model Service
            'documents',
            'guides',
            'contents',
            'meals',
            'dorongans',
            'wakafs',
            'badals',
            'tours.transportation', // Memuat tour yang dipilih beserta transportasinya
            'handlings.handlingHotels',
            'handlings.handlingPlanes'
        ])->findOrFail($id);

        // Siapkan semua data master yang dibutuhkan untuk form
        $data = [
            'service' => $service,
            'pelanggans' => Pelanggan::all(),
            'transportations' => Transportation::with('routes')->get(),
            'types' => TypeHotel::all(),
            'documents' => Document::with('childrens')->get(), // Ganti DocumentModel dengan nama model Anda
            'guides' => GuideItems::all(), // Master data pemandu
            'contents' => ContentItem::all(), // Master data konten
            'meals' => MealItem::all(), // Master data makanan
            'tours' => TourItem::all(), // Master data tour
            'dorongan' => Dorongan::all(), // Master data dorongan
            'wakaf' => Wakaf::all(), // Master data wakaf
        ];

        return view('admin.services.nego', $data);
    }





    public function uploadBerkas(Request $request, $service_id)
    {
        $service = Service::findOrFail($service_id);
        return view('admin.services.upload_berkas', [
            'service' => $service
        ]);
    }


    public function storeBerkas(Request $request, $id)
    {
        $service = Service::findOrFail($id);

        // Default null biar gak error kalau file gak diupload
        $path = $pathPaspor = $pathktp = $pathvisa = null;

        // Simpan file jika ada
        if ($request->hasFile('pas_foto')) {
            $path = $request->file('pas_foto')->store('/', 'public');
        }
        if ($request->hasFile('paspor')) {
            $pathPaspor = $request->file('paspor')->store('/', 'public');
        }
        if ($request->hasFile('ktp')) {
            $pathktp = $request->file('ktp')->store('/', 'public');
        }
        if ($request->hasFile('visa')) {
            $pathvisa = $request->file('visa')->store('/', 'public');
        }

        // Simpan ke tabel files
        File::create([
            'service_id' => $service->id,
            'pas_foto' => $path,
            'paspor' => $pathPaspor,
            'ktp' => $pathktp,
            'visa' => $pathvisa,
        ]);

        return redirect()->route('admin.services')->with('success', 'Berkas berhasil diupload.');


    }



    /**
     * Tampilkan daftar berkas.
     *
     * @return \Illuminate\View\View
     */
    public function showFile($id)
    {

        $service = Service::findOrFail($id);
        $files = File::where('service_id', $service->id)->get();
        return view('admin.services.show_file', compact('files', 'service'));
    }


    public function destroy($id)
    {
        $service = Service::findOrFail($id);
        $service->delete();
        return redirect()->route('admin.services')->with('success', 'Data layanan berhasil dihapus.');
    }

    public function updateNego(Request $request, $id)
    {
        $service = Service::findOrFail($id);
        $status = 'deal'; // status otomatis NEGO

        // ✅ Validasi dasar
        $request->validate([
            'travel' => 'required|exists:pelanggans,id',
            'services' => 'required|array',
            'tanggal_keberangkatan' => 'required|date',
            'tanggal_kepulangan' => 'required|date',
            'total_jamaah' => 'required|integer',
        ]);

        /* =====================================================
         * 🧩 GABUNGKAN SERVICES LAMA & BARU
         * ===================================================== */
        $existingServices = json_decode($service->services, true) ?? [];
        $newServices = $request->input('services', []);
        $mergedServices = array_unique(array_merge($existingServices, $newServices));

        // ✅ Update data utama
        $service->update([
            'pelanggan_id' => $request->travel,
            'services' => json_encode($mergedServices), // ← tidak menimpa, tapi menggabung
            'tanggal_keberangkatan' => $request->tanggal_keberangkatan,
            'tanggal_kepulangan' => $request->tanggal_kepulangan,
            'total_jamaah' => $request->total_jamaah,
            'status' => $status,
        ]);
        // Ambil total baru dari request
        $newAmount = (float) $request->input('total_amount', 0);

        // Cek apakah sudah ada order untuk service ini
        $order = Order::where('service_id', $service->id)->first();

        if ($order) {
            // Jika order sudah ada, tambahkan total_amount baru ke yang lama
            $order->update([
                'total_amount' => $order->total_amount + $newAmount,
                'sisa_hutang' => ($order->sisa_hutang ?? 0) + $newAmount,
                'status_pembayaran' => 'belum_bayar', // tetap belum lunas karena ada tambahan
            ]);
        } else {
            // Jika belum ada order, buat baru
            Order::create([
                'service_id' => $service->id,
                'total_amount' => $newAmount,
                'invoice' => 'INV-' . time(),
                'total_yang_dibayarkan' => 0,
                'sisa_hutang' => $newAmount,
                'status_pembayaran' => $newAmount == 0 ? 'lunas' : 'belum_bayar',
            ]);
        }


        /* =====================================================
         * ✈️ PESAWAT
         * ===================================================== */
        if ($request->has('rute') && is_array($request->rute) && collect($request->rute)->filter()->isNotEmpty()) {
            foreach ($request->rute as $i => $rute) {
                if (empty($rute))
                    continue;

                $planeId = $request->plane_id[$i] ?? null;
                $plane = Plane::find($planeId);

                $data = [
                    'service_id' => $service->id,
                    'tanggal_keberangkatan' => $request->tanggal[$i] ?? now(),
                    'rute' => $rute,
                    'maskapai' => $request->maskapai[$i] ?? null,
                    'harga' => $request->harga_tiket[$i] ?? 0,
                    'keterangan' => $request->keterangan[$i] ?? null,
                    'jumlah_jamaah' => $request->jumlah[$i] ?? 0,
                ];

                if ($request->hasFile("tiket_berangkat.$i")) {
                    $data['tiket_berangkat'] = $this->storeFileIfExists($request->file("tiket_berangkat.$i"), $i, 'tiket');
                }

                if ($request->hasFile("tiket_pulang.$i")) {
                    $data['tiket_pulang'] = $this->storeFileIfExists($request->file("tiket_pulang.$i"), $i, 'tiket');
                }

                if ($plane) {
                    $plane->update($data);
                } else {
                    foreach ($request->tanggal as $j => $tgl) {
                        if ($tgl) {
                            Plane::create([
                                'service_id' => $service->id,
                                'tanggal_keberangkatan' => $tgl,
                                'rute' => $request->rute[$j] ?? null,
                                'maskapai' => $request->maskapai[$j] ?? null,
                                'harga' => $request->harga_tiket[$j] ?? null,
                                'keterangan' => $request->keterangan[$j] ?? null,
                                'jumlah_jamaah' => $request->jumlah[$j] ?? 0,
                                'tiket_berangkat' => $this->storeFileIfExists($request->file('tiket_berangkat', []), $j, 'tiket'),
                                'tiket_pulang' => $this->storeFileIfExists($request->file('tiket_pulang', []), $j, 'tiket'),
                            ]);
                        }
                    }
                }
            }
        }

        /* =====================================================
         * 🚐 TRANSPORTASI
         * ===================================================== */
        if ($request->has('transportation_id') && collect($request->transportation_id)->filter()->isNotEmpty()) {
            foreach ($request->transportation_id as $ti => $transportId) {
                if (empty($transportId))
                    continue;

                $itemId = $request->item_id[$ti] ?? null;
                $routeId = $request->rute_id[$ti] ?? null;

                $transportItem = TransportationItem::find($itemId);

                if ($transportItem) {
                    $transportItem->update([
                        'transportation_id' => $transportId,
                        'route_id' => $routeId,
                    ]);
                } else {
                    TransportationItem::create([
                        'service_id' => $service->id,
                        'transportation_id' => $transportId,
                        'route_id' => $routeId,
                    ]);
                }
            }
        }

        /* =====================================================
         * 📄 DOKUMEN
         * ===================================================== */
        if ($request->has('dokumen_id') && collect($request->dokumen_id)->filter()->isNotEmpty()) {
            foreach ($request->dokumen_id as $index => $documentId) {
                if (empty($documentId))
                    continue;

                $cusdocid = $request->customer_document_id[$index] ?? null;
                $jumlah = $request->jumlah_doc_child[$index] ?? 0;

                $itemCusDoc = CustomerDocument::find($cusdocid);

                if ($itemCusDoc) {
                    $itemCusDoc->update(['jumlah' => $jumlah]);
                } else {
                    CustomerDocument::create([
                        'service_id' => $service->id,
                        'dokumen_id' => $documentId,
                        'jumlah' => $jumlah,
                    ]);
                }
            }
        }

        /* =====================================================
         * 🏨 HOTEL
         * ===================================================== */
        if ($request->has('tanggal_checkin') && is_array($request->tanggal_checkin)) {
            foreach ($request->tanggal_checkin as $index => $tanggalCheckin) {
                if (empty($tanggalCheckin))
                    continue;

                $hotelId = $request->hotel_id[$index] ?? null;
                $hotel = Hotel::find($hotelId);

                $typeHotel = $request->type_hotel[$index] ?? 'Standard';
                $jumlahType = $request->jumlah_type[$index] ?? 0;

                if ($hotel) {
                    $hotel->update([
                        'tanggal_checkin' => $tanggalCheckin,
                        'tanggal_checkout' => $request->tanggal_checkout[$index] ?? null,
                        'nama_hotel' => $request->nama_hotel[$index] ?? null,
                        'jumlah_kamar' => $request->jumlah_kamar[$index] ?? 0,
                        'type' => $typeHotel,
                        'jumlah_type' => $jumlahType,
                    ]);
                } else {
                    Hotel::create([
                        'service_id' => $service->id,
                        'tanggal_checkin' => $tanggalCheckin,
                        'tanggal_checkout' => $request->tanggal_checkout[$index] ?? null,
                        'nama_hotel' => $request->nama_hotel[$index] ?? null,
                        'jumlah_kamar' => $request->jumlah_kamar[$index] ?? 0,
                        'type' => $typeHotel,
                        'jumlah_type' => $jumlahType,
                    ]);
                }
            }
        }
        if ($request->has('nama_hotel_handling') && is_array($request->nama_hotel_handling)) {
            foreach ($request->nama_hotel_handling as $index => $namaHotelHandling) {
                if (empty($namaHotelHandling))
                    continue; // lewati jika kosong

                $handlingHotelId = $request->handling_hotel_id[$index] ?? null;
                $itemHandlingHotel = HandlingHotel::find($handlingHotelId);

                if ($itemHandlingHotel) {
                    // 🔸 Update data lama
                    $itemHandlingHotel->update([
                        'nama' => $namaHotelHandling,
                        'tanggal' => $request->tanggal_hotel_handling[$index] ?? null,
                        'harga' => $request->harga_hotel_handling[$index] ?? 0,
                        'pax' => $request->pax_hotel_handling[$index] ?? 0,
                    ]);
                } else {
                    // 🔹 Insert data baru
                    HandlingHotel::create([
                        'service_id' => $service->id,
                        'nama' => $namaHotelHandling,
                        'tanggal' => $request->tanggal_hotel_handling[$index] ?? null,
                        'harga' => $request->harga_hotel_handling[$index] ?? 0,
                        'pax' => $request->pax_hotel_handling[$index] ?? 0,
                    ]);
                }
            }
        }

        if ($request->has('nama_bandara_handling') && collect($request->nama_bandara_handling)->filter()->isNotEmpty()) {
            $handlingBandaraId = $request->handling_bandara_id;
            $itemHandlingBandara = HandlingPlanes::find($handlingBandaraId);
            if ($itemHandlingBandara) {
                $itemHandlingBandara->update([
                    'nama_bandara' => $request->nama_bandara_handling,
                    'jumlah_jamaah' => $request->jumlah_jamaah_handling,
                    'harga' => $request->harga_bandara_handling,
                    'kedatangan_jamaah' => $request->kedatangan_jamaah_handling,
                    "nama_supir" => $request->nama_supir,
                ]);
            }
        }

        if ($request->has('jumlah_pendamping') && is_array($request->jumlah_pendamping)) {
            foreach ($request->jumlah_pendamping as $guideId => $jumlah) {
                if (!is_null($jumlah) && $jumlah !== '') {
                    // Cari data pendamping sesuai service & guide_id
                    $guideItem = Guide::where('service_id', $service->id)
                        ->where('guide_id', $guideId);
                    if ($guideItem) {
                        $guideItem->update(['jumlah' => $jumlah]);
                    } else {
                        // 🔹 Tambahkan data baru kalau belum ada
                        Guide::create([
                            'service_id' => $service->id,
                            'guide_id' => $guideId,
                            'jumlah' => $jumlah,
                        ]);
                    }
                }
            }
        }
        if ($request->has('jumlah_konten') && is_array($request->jumlah_konten)) {
            foreach ($request->jumlah_konten as $contentId => $jumlah) {
                if (!is_null($jumlah) && $jumlah !== '') {
                    // Cari data konten berdasarkan service dan content_id
                    $contentItem = ContentCustomer::where('service_id', $service->id)
                        ->where('content_id', $contentId)
                        ->first();

                    if ($contentItem) {
                        // 🔸 Update data jika sudah ada
                        $contentItem->update(['jumlah' => $jumlah]);
                    } else {
                        // 🔹 Tambahkan data baru jika belum ada
                        ContentCustomer::create([
                            'service_id' => $service->id,
                            'content_id' => $contentId,
                            'jumlah' => $jumlah,
                            'keterangan' => $request->keterangan,
                        ]);
                    }
                }
            }
        }
        if ($request->has('jumlah_meals') && is_array($request->jumlah_meals)) {
            foreach ($request->jumlah_meals as $mealId => $jumlah) {
                if (!is_null($jumlah) && $jumlah !== '') {
                    // Cari data meal berdasarkan service dan meal_id
                    $mealItem = Meal::where('service_id', $service->id)
                        ->where('meal_id', $mealId)
                        ->first();

                    if ($mealItem) {
                        // 🔸 Update jumlah jika sudah ada
                        $mealItem->update(['jumlah' => $jumlah]);
                    } else {
                        // 🔹 Tambah data baru jika belum ada
                        Meal::create([
                            'service_id' => $service->id,
                            'meal_id' => $mealId,
                            'jumlah' => $jumlah,
                        ]);
                    }
                }
            }
        }
        if ($request->has('jumlah_dorongan') && is_array($request->jumlah_dorongan)) {
            foreach ($request->jumlah_dorongan as $doronganId => $jumlah) {
                if (!is_null($jumlah) && $jumlah !== '') {
                    // Cari data dorongan sesuai service & dorongan_id
                    $doronganItem = DoronganOrder::where('service_id', $service->id)
                        ->where('dorongan_id', $doronganId)
                        ->first();

                    if ($doronganItem) {
                        // 🔸 Jika sudah ada → update jumlah
                        $doronganItem->update(['jumlah' => $jumlah]);
                    } else {
                        // 🔹 Jika belum ada → tambahkan data baru
                        DoronganOrder::create([
                            'service_id' => $service->id,
                            'dorongan_id' => $doronganId,
                            'jumlah' => $jumlah,
                        ]);
                    }
                }
            }
        }
        if ($request->has('tour_id') && collect($request->tour_id)->filter()->isNotEmpty()) {
            foreach ($request->tour_id as $index => $tourItemId) {
                if (empty($tourItemId))
                    continue;

                $transportId = $request->tour_transport[$index] ?? null;

                // Cek apakah sudah ada data tour untuk service ini dan tour_id terkait
                $tourItem = Tour::where('service_id', $service->id)
                    ->where('tour_id', $tourItemId)
                    ->first();

                if ($tourItem) {
                    // 🔸 Update data jika sudah ada
                    $tourItem->update([
                        'transportation_id' => $transportId,
                    ]);
                } else {
                    // 🔹 Tambah baru jika belum ada
                    Tour::create([
                        'service_id' => $service->id,
                        'tour_id' => $tourItemId,
                        'transportation_id' => $transportId,

                    ]);
                }
            }
        }
        if ($request->has('jumlah_wakaf') && is_array($request->jumlah_wakaf)) {
            foreach ($request->jumlah_wakaf as $wakafId => $jumlah) {
                if (!is_null($jumlah) && $jumlah !== '') {
                    $wakafItem = WakafCustomer::where('service_id', $service->id)
                        ->where('wakaf_id', $wakafId)
                        ->first();

                    if ($wakafItem) {
                        // 🔸 Jika sudah ada, update jumlah
                        $wakafItem->update(['jumlah' => $jumlah]);
                    } else {
                        // 🔹 Jika belum ada, buat baru
                        WakafCustomer::create([
                            'service_id' => $service->id,
                            'wakaf_id' => $wakafId,
                            'jumlah' => $jumlah,
                        ]);
                    }
                }
            }
        }
        if ($request->has('nama_badal') && is_array($request->nama_badal)) {
            foreach ($request->nama_badal as $index => $namaBadal) {
                if (empty($namaBadal))
                    continue;

                $hargaBadal = $request->harga_badal[$index] ?? 0;
                $badalId = $request->badal_id[$index] ?? null; // pastikan hidden input badal_id[] di form

                Badal::updateOrCreate(
                    ['id' => $badalId, 'service_id' => $service->id],
                    [
                        'name' => $namaBadal,
                        'price' => $hargaBadal,
                    ]
                );
            }
        }

        // 🔁 Redirect
        return redirect()->route('admin.services', [
            'service_id' => $service->id,
            'total_jamaah' => $request->total_jamaah,
        ])->with('success', 'Data service berhasil diperbarui dengan status NEGO.');
    }






    public function edit($id)
    {
        $service = Service::with([
            'pelanggan',
            'hotels',
            'planes',
            'transportationItem.transportation.routes',
            'transportationItem.route',
            'handlings', // Simplified for clarity
            'meals',
            'guides',
            'tours', // Eager load the tours and their selected transportation
            'documents',
            'wakafs',
            'dorongans',
            'contents',
            'badals'
        ])->findOrFail($id);

        $data = [
            'service' => $service,
            // The selectedServices can be decoded directly from the service object
            'selectedServices' => $service->services ?? [],
            'pelanggans' => Pelanggan::all(),
            'transportations' => Transportation::with('routes')->get(),
            'guides' => Guide::all(),
            'tours' => Tour::all(),
            'meals' => Meal::all(),
            'documents' => DocumentModel::with('childrens')->get(),
            'wakaf' => WakafCustomer::all(),
            'dorongan' => DoronganOrder::all(),
            'contents' => ContentCustomer::all(),
            'types' => TypeHotel::all(),
        ];

        return view('admin.services.edit', $data);
    }
    public function update(Request $request, $id)
    {
        $service = Service::findOrFail($id);
        $status = $request->input('action') === 'nego' ? 'nego' : 'deal';

        /* =====================================================
         * ✅ VALIDASI INPUT
         * ===================================================== */
        $request->validate([
            'travel' => 'required|exists:pelanggans,id',
            'services' => 'required|array',
            'tanggal_keberangkatan' => 'required|date',
            'tanggal_kepulangan' => 'required|date',
            'total_jamaah' => 'required|integer',
        ]);

        /* =====================================================
         * 🔁 UPDATE DATA SERVICE UTAMA
         * ===================================================== */
        $service->update([
            'pelanggan_id' => $request->travel,
            'services' => json_encode($request->services),
            'tanggal_keberangkatan' => $request->tanggal_keberangkatan,
            'tanggal_kepulangan' => $request->tanggal_kepulangan,
            'total_jamaah' => $request->total_jamaah,
            'status' => $status,
        ]);

        /* =====================================================
         * ✈️ UPDATE / TAMBAH DATA PESAWAT
         * ===================================================== */
        if (
            $request->has('rute') &&
            is_array($request->rute) &&
            collect($request->rute)->filter()->isNotEmpty() &&
            $request->filled('tanggal')
        ) {
            foreach ($request->rute as $i => $rute) {
                if (empty($rute))
                    continue;

                $planeId = $request->plane_id[$i] ?? null;
                $plane = Plane::find($planeId) ?? new Plane(['service_id' => $service->id]);

                $plane->tanggal_keberangkatan = $request->tanggal[$i] ?? now();
                $plane->rute = $rute;
                $plane->maskapai = $request->maskapai[$i] ?? null;
                $plane->harga = $request->harga_tiket[$i] ?? null;
                $plane->keterangan = $request->keterangan[$i] ?? null;
                $plane->jumlah_jamaah = $request->jumlah[$i] ?? 0;

                if ($request->hasFile("tiket_berangkat.$i")) {
                    $plane->tiket_berangkat = $this->storeFileIfExists($request->file("tiket_berangkat.$i"), $i, 'tiket');
                }

                if ($request->hasFile("tiket_pulang.$i")) {
                    $plane->tiket_pulang = $this->storeFileIfExists($request->file("tiket_pulang.$i"), $i, 'tiket');
                }

                $plane->save();
            }
        }

        /* =====================================================
         * 🚌 TRANSPORTASI
         * ===================================================== */
        if ($request->has('transportation_id') && collect($request->transportation_id)->filter()->isNotEmpty()) {
            foreach ($request->transportation_id as $ti => $transportId) {
                if (empty($transportId))
                    continue;

                $itemId = $request->item_id[$ti] ?? null;
                $transp = TransportationItem::find($itemId) ?? new TransportationItem(['service_id' => $service->id]);

                $transp->transportation_id = $transportId;
                $transp->route_id = $request->rute_id[$ti];
                $transp->save();
            }
        }

        /* =====================================================
         * 📄 DOKUMEN
         * ===================================================== */
        if ($request->has('dokumen_id') && collect($request->dokumen_id)->filter()->isNotEmpty()) {
            foreach ($request->dokumen_id as $index => $documentId) {
                if (empty($documentId))
                    continue;

                $cusdocid = $request->customer_document_id[$index] ?? null;
                $jumlah = $request->jumlah_doc_child[$index] ?? 0;

                $itemCusDoc = CustomerDocument::find($cusdocid) ?? new CustomerDocument(['service_id' => $service->id]);
                $itemCusDoc->jumlah = $jumlah;
                $itemCusDoc->save();
            }
        }

        /* =====================================================
         * 🏨 HANDLING HOTEL
         * ===================================================== */
        if ($request->has('nama_hotel_handling') && collect($request->nama_hotel_handling)->filter()->isNotEmpty()) {
            $handlingHotelId = $request->handling_hotel_id;
            $item = HandlingHotel::find($handlingHotelId);
            if ($item) {
                $item->update([
                    'nama' => $request->nama_hotel_handling,
                    'tanggal' => $request->tanggal_hotel_handling,
                    'harga' => $request->harga_hotel_handling,
                    'pax' => $request->pax_hotel_handling,
                ]);
            }
        }

        /* =====================================================
         * 🛬 HANDLING BANDARA
         * ===================================================== */
        if ($request->has('nama_bandara_handling') && collect($request->nama_bandara_handling)->filter()->isNotEmpty()) {
            $handlingBandaraId = $request->handling_bandara_id;
            $item = HandlingPlanes::find($handlingBandaraId);
            if ($item) {
                $item->update([
                    'nama_bandara' => $request->nama_bandara_handling,
                    'jumlah_jamaah' => $request->jumlah_jamaah_handling,
                    'harga' => $request->harga_bandara_handling,
                    'kedatangan_jamaah' => $request->kedatangan_jamaah_handling,
                    'nama_supir' => $request->nama_supir,
                ]);
            }
        }

        /* =====================================================
         * 👥 PENDAMPING
         * ===================================================== */
        if ($request->has('jumlah_pendamping') && is_array($request->jumlah_pendamping)) {
            foreach ($request->jumlah_pendamping as $guideId => $jumlah) {
                if (!is_null($jumlah) && $jumlah !== '') {
                    $guideItem = Guide::where('service_id', $service->id)->where('guide_id', $guideId)->first();
                    if ($guideItem)
                        $guideItem->update(['jumlah' => $jumlah]);
                }
            }
        }

        /* =====================================================
         * 📸 KONTEN
         * ===================================================== */
        if ($request->has('jumlah_konten') && is_array($request->jumlah_konten)) {
            foreach ($request->jumlah_konten as $contentId => $jumlah) {
                if (!is_null($jumlah) && $jumlah !== '') {
                    $contentItem = ContentCustomer::where('service_id', $service->id)->where('content_id', $contentId)->first();
                    if ($contentItem)
                        $contentItem->update(['jumlah' => $jumlah]);
                }
            }
        }

        /* =====================================================
         * 🗺️ TOUR
         * ===================================================== */
        if ($request->has('tour_id') && collect($request->tour_id)->filter()->isNotEmpty()) {
            $tourId = $request->id_tour;
            $tourFinally = Tour::find($tourId);
            if ($tourFinally) {
                foreach ($request->tour_transport as $transport) {
                    $tourFinally->update([
                        'transportation_id' => $transport,
                        'tour_id' => $request->tour_id,
                    ]);
                }
            }
        }

        /* =====================================================
         * 🍱 MEALS
         * ===================================================== */
        if ($request->has('jumlah_meals') && is_array($request->jumlah_meals)) {
            foreach ($request->jumlah_meals as $mealId => $jumlah) {
                if (!is_null($jumlah) && $jumlah !== '') {
                    $mealItem = Meal::where('service_id', $service->id)->where('meal_id', $mealId)->first();
                    if ($mealItem)
                        $mealItem->update(['jumlah' => $jumlah]);
                }
            }
        }

        /* =====================================================
         * 💸 DORONGAN
         * ===================================================== */
        if ($request->has('jumlah_dorongan') && is_array($request->jumlah_dorongan)) {
            foreach ($request->jumlah_dorongan as $doronganId => $jumlah) {
                if (!is_null($jumlah) && $jumlah !== '') {
                    $doronganItem = DoronganOrder::where('service_id', $service->id)->where('dorongan_id', $doronganId)->first();
                    if ($doronganItem)
                        $doronganItem->update(['jumlah' => $jumlah]);
                }
            }
        }

        /* =====================================================
         * 🕋 BADAL
         * ===================================================== */
        if ($request->has('nama_badal') && is_array($request->nama_badal)) {
            foreach ($request->nama_badal as $index => $namaBadal) {
                if (empty($namaBadal))
                    continue;

                $hargaBadal = $request->harga_badal[$index] ?? 0;
                $badalItem = Badal::where('service_id', $service->id)->first();

                if ($badalItem) {
                    $badalItem->update([
                        'name' => $namaBadal,
                        'price' => $hargaBadal,
                    ]);
                }
            }
        }

        /* =====================================================
         * 🏨 HOTEL
         * ===================================================== */
        if ($request->has('tanggal_checkin') && is_array($request->tanggal_checkin)) {
            foreach ($request->tanggal_checkin as $index => $tanggalCheckin) {
                if (empty($tanggalCheckin))
                    continue;

                $hotel = Hotel::where('service_id', $service->id)->skip($index)->first();
                $typeHotel = $request->type_hotel[$index] ?? 'Standard';
                $jumlahType = $request->jumlah_type[$index] ?? 0;

                if ($hotel) {
                    $hotel->update([
                        'tanggal_checkin' => $tanggalCheckin,
                        'tanggal_checkout' => $request->tanggal_checkout[$index] ?? null,
                        'nama_hotel' => $request->nama_hotel[$index] ?? null,
                        'jumlah_kamar' => $request->jumlah_kamar[$index] ?? 0,
                        'type' => $typeHotel,
                        'jumlah_type' => $jumlahType
                    ]);
                }
            }
        }

        /* =====================================================
         * 💰 WAKAF
         * ===================================================== */
        if ($request->has('jumlah_wakaf') && is_array($request->jumlah_wakaf)) {
            foreach ($request->jumlah_wakaf as $wakafId => $jumlah) {
                if (!is_null($jumlah) && $jumlah !== '') {
                    $wakafItem = WakafCustomer::where('service_id', $service->id)
                        ->where('wakaf_id', $wakafId)
                        ->first();

                    if ($wakafItem) {
                        $wakafItem->update(['jumlah' => $jumlah]);
                    }
                }
            }
        }
        /* =====================================================
         * ✅ REDIRECT SELESAI
         * ===================================================== */
        return redirect()->route('admin.services', [
            'service_id' => $service->id,
            'total_jamaah' => $request->total_jamaah,
        ])->with('success', 'Data service berhasil diperbarui.');
    }








    private function storeFileIfExists(array $files, int $index, string $path)
    {
        if (isset($files[$index]) && $files[$index]->isValid()) {
            return $files[$index]->store($path, 'public');
        }
        return null;
    }

    /**
     * Memproses dan menyimpan item layanan.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Service $service
     * @return void
     */
    private function processServiceItems(Request $request, Service $service)
    {
        foreach ($request->services as $srv) {
            $srvLower = strtolower($srv);
            switch ($srvLower) {
                case 'hotel':
                    $this->handleHotelItems($request, $service);
                    break;
                case 'transportasi':
                    $this->handleTransportationItems($request, $service);
                    break;
                case 'handling':
                    $this->handleHandlingItems($request, $service);
                    break;
                case 'meals':
                    $this->handleMealItems($request, $service);
                    break;
                case 'pendamping':
                    $this->handleGuideItems($request, $service);
                    break;
                case 'tour':
                    $this->handleTourItems($request, $service);
                    break;
                case 'dokumen':
                    $this->handleDocumentItems($request, $service);
                    break;
                case 'reyal':
                    $this->handleReyalItems($request, $service);
                    break;
                case 'waqaf':
                    $this->handleWakafItems($request, $service);
                    break;
                case 'dorongan':
                    $this->handleDoronganItems($request, $service);
                    break;
                case 'konten':
                    $this->handleContentItems($request, $service);
                    break;
                case 'badal':
                    $this->handleBadalItems($request, $service);
                    break;
            }
        }
    }


    private function deleteServiceItems(Service $service)
    {
        $service->hotels()->delete();
        $service->planes()->delete();
        $service->transportationItem()->delete();
        $service->handlings()->delete();
        $service->meals()->delete();
        $service->guides()->delete();
        $service->tours()->delete();
        $service->documents()->delete();
        $service->reyals()->delete();
        $service->wakafs()->delete();
        $service->dorongans()->delete();
        $service->contents()->delete();
        $service->badals()->delete();
    }

    private function handleHotelItems(Request $request, Service $service)
{
    // 1. Kita loop data 'hotel_data' yang sudah terstruktur rapi
    if ($request->filled('hotel_data')) {

        foreach ($request->hotel_data as $i => $types) {

            // $i adalah indeks hotel (0, 1, dst.)
            // $types adalah array [typeId => data] untuk hotel itu

            // 2. Ambil data umum untuk hotel ini
            $namaHotel = $request->nama_hotel[$i] ?? null;
            if (empty($namaHotel)) {
                continue; // Lewati jika tidak ada nama hotel
            }

            // 3. Loop setiap TIPE KAMAR yang dipilih untuk hotel ini
            foreach ($types as $typeId => $typeData) {

                $jumlah = $typeData['jumlah'] ?? 0;

                // 4. Simpan ke database dengan data yang PASTI BENAR
                if ($jumlah > 0) {
                    $service->hotels()->create([
                        'nama_hotel' => $namaHotel,
                        'tanggal_checkin' => $request->tanggal_checkin[$i] ?? null,
                        'tanggal_checkout' => $request->tanggal_checkout[$i] ?? null,
                        'type' => $typeData['type_name'] ?? null, // Dari hidden input
                        'jumlah_kamar' => $request->jumlah_kamar[$i] ?? null, // Ini adalah "Total Kamar"

                        // Bersihkan format harga (misal: '100.000' menjadi '100000')
                        'harga_perkamar' => str_replace(['.', ','], '', $typeData['harga'] ?? 0),

                        'jumlah_type' => $jumlah, // INI JUMLAH YANG BENAR
                        'catatan' => $request->keterangan[$i] ?? null
                    ]);
                }
            }
        }
    }
}

    // private function handleHotelItems(Request $request, Service $service)
    // {
    //     if ($request->filled('nama_hotel')) {
    //         foreach ($request->nama_hotel as $i => $namaHotel) {
    //             foreach ($request->type as $t => $type) {
    //                 if (empty($namaHotel))
    //                     continue;
    //                 $hotel = $service->hotels()->create([
    //                     'nama_hotel' => $namaHotel,
    //                     'tanggal_checkin' => $request->tanggal_checkin[$i] ?? null,
    //                     'tanggal_checkout' => $request->tanggal_checkout[$i] ?? null,
    //                     'type' => $type,
    //                     'jumlah_kamar' => $request->jumlah_kamar[$i],
    //                     'harga_perkamar' => "0",
    //                     'jumlah_type' => $request->jumlah_type[$i],
    //                     'catatan' => $request->keterangan[$i]
    //                 ]);
    //             }
    //         }
    //     }
    // }

    private function handleTransportationItems(Request $request, Service $service)
    {
        // ✈️ Tiket Pesawat
        if ($request->filled('transportation') && in_array('airplane', $request->transportation)) {
            foreach ($request->tanggal as $j => $tgl) {
                if ($tgl) {
                    $service->planes()->create([
                        'tanggal_keberangkatan' => $tgl,
                        'rute' => $request->rute[$j] ?? null,
                        'maskapai' => $request->maskapai[$j] ?? null,
                        'harga' => $request->harga_tiket[$j] ?? null,
                        'keterangan' => $request->keterangan_tiket[$j] ?? null,
                        'jumlah_jamaah' => $request->jumlah[$j] ?? 0,
                        'tiket_berangkat' => $this->storeFileIfExists($request->file('tiket_berangkat', []), $j, 'tiket'),
                        'tiket_pulang' => $this->storeFileIfExists($request->file('tiket_pulang', []), $j, 'tiket'),
                    ]);
                }
            }
        }

        // 🚌 Transportasi Darat (Bus)
    if ($request->filled('transportation') && in_array('bus', $request->transportation)) {

        // 1. Validasi data yang masuk
        $request->validate([
            // Pastikan transportation_id adalah array
            'transportation_id' => 'nullable|array',
            // Setiap transportation_id yang dikirim WAJIB ada di tabel transportations
            'transportation_id.*' => 'required|exists:transportations,id',

            'rute_id' => 'nullable|array',
            // Setiap rute_id WAJIB diisi dan ada di tabel routes
            'rute_id.*' => 'required|exists:routes,id',

            'tanggal_transport' => 'nullable|array',
            // Setiap tanggal WAJIB diisi
            'tanggal_transport.*.dari' => 'required|date',
            'tanggal_transport.*.sampai' => 'required|date|after_or_equal:tanggal_transport.*.dari',
        ], [
            // Pesan error kustom
            'rute_id.*.required' => 'Rute wajib dipilih untuk setiap transportasi.',
            'tanggal_transport.*.dari.required' => 'Tanggal "Dari" wajib diisi.',
            'tanggal_transport.*.sampai.required' => 'Tanggal "Sampai" wajib diisi.',
        ]);

        // 2. Jika validasi lolos, kita bisa yakin data LENGKAP
        $transportationIds = $request->input('transportation_id', []);

        foreach ($transportationIds as $index => $transportId) {

            // Kita bisa yakin data ini ada karena sudah lolos validasi
            $ruteId = $request->input("rute_id.$index");
            $dariTanggal = $request->input("tanggal_transport.$index.dari");
            $sampaiTanggal = $request->input("tanggal_transport.$index.sampai");


            // 'if' ini sekarang hanya sebagai formalitas (karena validasi sudah menangani)
            if ($transportId && $ruteId && $dariTanggal && $sampaiTanggal) {
                $service->transportationItem()->create([
                    'transportation_id' => $transportId,
                    'route_id' => $ruteId,
                    'dari_tanggal' => $dariTanggal,
                    'sampai_tanggal' => $sampaiTanggal,
                ]);
            }
        }
    }
    }


    private function handleHandlingItems(Request $request, Service $service)
    {
        if ($request->filled('handlings')) {
            foreach ($request->handlings as $handling) {
                $handlingModel = $service->handlings()->create(['name' => $handling]);
                switch (strtolower($handling)) {
                    case 'hotel':
                        if ($request->filled('nama_hotel_handling')) {
                            $handlingModel->handlingHotels()->create([
                                'nama' => $request->nama_hotel_handling,
                                'tanggal' => $request->tanggal_hotel_handling,
                                'harga' => $request->harga_hotel_handling,
                                'pax' => $request->pax_hotel_handling,
                                'kode_booking' => $request->file('kode_booking_hotel_handling') ? $request->file('kode_booking_hotel_handling')->store('handling/hotel', 'public') : null,
                                'rumlis' => $request->file('rumlis_hotel_handling') ? $request->file('rumlis_hotel_handling')->store('handling/hotel', 'public') : null,
                                'identitas_koper' => $request->file('identitas_hotel_handling') ? $request->file('identitas_hotel_handling')->store('handling/hotel', 'public') : null,
                            ]);
                        }
                        break;
                    case 'bandara':
                        if ($request->filled('nama_bandara_handling')) {
                            $handlingModel->handlingPlanes()->create([
                                'nama_bandara' => $request->nama_bandara_handling,
                                'jumlah_jamaah' => $request->jumlah_jamaah_handling,
                                'harga' => $request->harga_bandara_handling,
                                'kedatangan_jamaah' => $request->kedatangan_jamaah_handling,
                                'paket_info' => $request->file('paket_info') ? $request->file('paket_info')->store('handling/bandara', 'public') : null,
                                'nama_supir' => $request->nama_supir,
                                'identitas_koper' => $request->file('identitas_koper_bandara_handling') ? $request->file('identitas_koper_bandara_handling')->store('handling/bandara', 'public') : null,
                            ]);
                        }
                        break;
                }
            }
        }
    }

    private function handleMealItems(Request $request, Service $service)
    {
        if ($request->filled('jumlah_meals')) {
            foreach ($request->jumlah_meals as $mealId => $jumlah) {
                if ($jumlah > 0) {
                    $dariTanggal = $request->input("dari_tanggal_makanan.$mealId.dari");
                    $sampaiTanggal = $request->input("sampai_tanggal_makanan.$mealId.sampai");

                    $service->meals()->create([
                        'meal_id' => $mealId,
                        'jumlah' => $jumlah,
                        'dari_tanggal' => $dariTanggal,
                        'sampai_tanggal' => $sampaiTanggal,
                    ]);
                }
            }
        }
    }


    private function handleGuideItems(Request $request, Service $service)
    {
        if ($request->filled('jumlah_pendamping')) {
            if ($request->filled('jumlah_pendamping')) {
                foreach ($request->jumlah_pendamping as $guideId => $jumlah) {
                    if ($jumlah > 0) {
                        $tanggal = $request->input("tanggal_pendamping[$guideId]");

                        $service->guides()->create([
                            'guide_id' => $guideId,
                            'jumlah' => $jumlah,
                            'keterangan' => $request->input("keterangan_pendamping.$guideId") ?? null,
                            'muthowif_dari' => $request->tanggal_pendamping[$guideId]["dari"],
                            'muthowif_sampai' => $request->tanggal_pendamping[$guideId]["sampai"],
                        ]);


                    }
                }
            }
        }
    }


    private function handleTourItems(Request $request, Service $service)
    {
        if ($request->filled('tour_ids') && is_array($request->tour_ids)) {
            foreach ($request->tour_ids as $tourId) {

                $transportationId = $request->input("tour_transport.$tourId"); // Contoh: input("tour_transport.5")
                $tanggal = $request->input("tanggal_tour.$tourId"); // Contoh: input("tanggal_tour.5")
                if ($tanggal) {
                    $service->tours()->create([
                        'tour_id' => $tourId, // ID dari master tour_items
                        'transportation_id' => $transportationId, // Bisa null jika tidak dipilih
                        'tanggal_keberangkatan' => $tanggal,
                    ]);
                }
                // Opsional: Tambahkan else log jika tanggal kosong padahal tour dipilih

            }
        }
    }

   private function handleDocumentItems(Request $request, Service $service)
{
    // 1. TANGANI UPLOAD FILE (DAN SIMPAN KE SERVICE)
    // Asumsi: Kolom 'paspor_dokumen' & 'pas_foto_dokumen' ada di tabel 'services'
    $fileData = [];
    if ($request->hasFile('paspor_dokumen')) {
        // Opsional: Hapus file lama jika ada sebelum menyimpan yang baru
        if ($service->paspor_dokumen) {
             Storage::disk('public')->delete($service->paspor_dokumen);
        }
        $fileData['paspor_dokumen'] = $request->file('paspor_dokumen')->store('service-docs', 'public'); // Simpan ke folder service-docs
    }
    if ($request->hasFile('pas_foto_dokumen')) {
        // Opsional: Hapus file lama
         if ($service->pas_foto_dokumen) {
             Storage::disk('public')->delete($service->pas_foto_dokumen);
         }
        $fileData['pas_foto_dokumen'] = $request->file('pas_foto_dokumen')->store('service-docs', 'public'); // Simpan ke folder service-docs
    }

    // Update service HANYA jika ada file baru yang diupload
    if (!empty($fileData)) {
        $service->update($fileData); // Pastikan kolom ada di $fillable model Service
    }

    // Ini akan menampung semua ID item CustomerDocument yang valid untuk service ini
    $validCustomerDocIds = [];

    // ---------------------------------------------------------------------
    // 2. PROSES DOKUMEN INDUK (YANG TIDAK PUNYA ANAK)
    // Memindai semua input request untuk mencari key 'jumlah_doc_{id}'
    // ---------------------------------------------------------------------
    foreach ($request->all() as $key => $jumlah) {
        // Cek jika nama input adalah 'jumlah_doc_' dan nilainya (jumlah) valid
        if (strpos($key, 'jumlah_doc_') === 0 && $jumlah > 0) {
            // Ambil ID dari nama input (misal: 'jumlah_doc_12' -> '12')
            $documentId = substr($key, 11);
            $document = Document::find($documentId); // Cari dokumen induk

            if ($document) {
                // Simpan (atau update jika sudah ada)
                $customerDoc = $service->documents()->updateOrCreate(
                    [
                        'document_id' => $documentId,
                        'document_children_id' => null // Tandai sebagai item induk
                    ],
                    [
                        'jumlah' => $jumlah,
                        'harga'  => $document->price ?? 0, // Ambil harga dari induk, default 0 jika null
                    ]
                );
                // Simpan ID yang baru dibuat/diupdate
                $validCustomerDocIds[] = $customerDoc->id;
            }
        }
    }

    // ---------------------------------------------------------------------
    // 3. PROSES DOKUMEN ANAK (YANG DICENTANG DAN ADA JUMLAHNYA)
    // ---------------------------------------------------------------------
    // Cek apakah ada input jumlah_child_doc (array) yang dikirim
    if ($request->has('jumlah_child_doc') && is_array($request->jumlah_child_doc)) {
        // Loop melalui array jumlah_child_doc[CHILD_ID] => JUMLAH
        foreach ($request->jumlah_child_doc as $childId => $jumlah) {
            // Pastikan jumlah valid dan anak dokumennya ada
            if ($jumlah > 0) {
                $itemChild = DocumentChildren::find($childId);
                if ($itemChild) {
                    // Simpan (atau update jika sudah ada)
                    $customerDoc = $service->documents()->updateOrCreate(
                        [
                            // Cari berdasarkan ID anak
                            'document_children_id' => $itemChild->id
                        ],
                        [
                            'document_id' => $itemChild->document_id, // Simpan ID induknya dari relasi
                            'jumlah'      => $jumlah, // <-- AMBIL JUMLAH DARI INPUT BARU
                            'harga'       => $itemChild->price ?? 0, // Ambil harga dari anak, default 0 jika null
                        ]
                    );
                    // Simpan ID yang baru dibuat/diupdate
                    $validCustomerDocIds[] = $customerDoc->id;
                }
            }
        }
    }

    // ---------------------------------------------------------------------
    // 4. PEMBERSIHAN (Hapus item yang tidak dipilih lagi)
    // ---------------------------------------------------------------------
    $service->documents()
            ->whereNotIn('id', $validCustomerDocIds)
            ->delete();
}


    private function handleReyalItems(Request $request, Service $service)
{
    // 1. Validasi semua input terlebih dahulu
    $validatedData = $request->validate([
        // 'tipe' dan 'tanggal_penyerahan' selalu wajib
        'tipe' => 'required|in:tamis,tumis',
        'tanggal_penyerahan' => 'required|date',

        // Wajib jika tipenya 'tamis'
        'jumlah_rupiah' => 'required_if:tipe,tamis|nullable|numeric|min:0',
        'kurs_tamis' => 'required_if:tipe,tamis|nullable|numeric|min:0',
        'hasil_tamis' => 'required_if:tipe,tamis|nullable|numeric|min:0',

        // Wajib jika tipenya 'tumis'
        'jumlah_reyal' => 'required_if:tipe,tumis|nullable|numeric|min:0',
        'kurs_tumis' => 'required_if:tipe,tumis|nullable|numeric|min:0',
        'hasil_tumis' => 'required_if:tipe,tumis|nullable|numeric|min:0',
    ]);

    // 2. Jika validasi lolos, data dijamin ada.
    // Gunakan 'if-else if' agar lebih jelas

    if ($validatedData['tipe'] === 'tamis') {
        $service->reyals()->create([
            'tipe' => 'tamis',
            'jumlah_input' => $validatedData['jumlah_rupiah'],
            'kurs' => $validatedData['kurs_tamis'],
            'hasil' => $validatedData['hasil_tamis'],
            'tanggal_penyerahan' => $validatedData['tanggal_penyerahan'],
        ]);
    }
    else if ($validatedData['tipe'] === 'tumis') {
        $service->reyals()->create([
            'tipe' => 'tumis',
            'jumlah_input' => $validatedData['jumlah_reyal'],
            'kurs' => $validatedData['kurs_tumis'],
            'hasil' => $validatedData['hasil_tumis'],
            'tanggal_penyerahan' => $validatedData['tanggal_penyerahan'],
        ]);
    }
}
    // private function handleReyalItems(Request $request, Service $service)
    // {
    //     $tipe = $request->input('tipe');
    //     $tanggalPenyerahan = $request->input('tanggal_penyerahan');
    //     if ($tanggalPenyerahan) {
    //         if ($tipe === 'tamis') {
    //             $service->reyals()->create([
    //                 'tipe' => 'tamis',
    //                 'jumlah_input' => $request->input('jumlah_rupiah'),
    //                 'kurs' => $request->input('kurs_tamis'),
    //                 'hasil' => $request->input('hasil_tamis'),
    //                 'tanggal_penyerahan' => $tanggalPenyerahan,
    //             ]);
    //         }

    //         if ($tipe === 'tumis') {
    //             $service->reyals()->create([
    //                 'tipe' => 'tumis',
    //                 'jumlah_input' => $request->input('jumlah_reyal'),
    //                 'kurs' => $request->input('kurs_tumis'),
    //                 'hasil' => $request->input('hasil_tumis'),
    //                 'tanggal_penyerahan' => $tanggalPenyerahan,
    //             ]);
    //         }
    //     }
    // }


    private function handleWakafItems(Request $request, Service $service)
    {
        if ($request->filled('jumlah_wakaf')) {
            foreach ($request->jumlah_wakaf as $wakafId => $jumlah) {
                if ($jumlah > 0) {
                    $service->wakafs()->create([
                        'wakaf_id' => $wakafId,
                        'jumlah' => $jumlah
                    ]);
                }
            }
        }
    }

    private function handleDoronganItems(Request $request, Service $service)
    {
        if ($request->filled('jumlah_dorongan')) {
            foreach ($request->jumlah_dorongan as $doronganId => $jumlah) {
                if ($jumlah > 0) {
                    $tanggal = $request->input("tanggal_dorongan.$doronganId");

                    DoronganOrder::create([
                        'service_id' => $service->id,
                        'dorongan_id' => $doronganId,
                        'jumlah' => $jumlah,
                        'tanggal_pelaksanaan' => $tanggal,
                    ]);
                }
            }
        }
    }


    private function handleContentItems(Request $request, Service $service)
    {
        if ($request->filled('jumlah_konten')) {
            foreach ($request->jumlah_konten as $contentId => $jumlah) {
                if ($jumlah > 0) {
                    ContentCustomer::create([
                        'service_id' => $service->id,
                        'content_id' => $contentId,
                        'jumlah' => $jumlah,
                        'tanggal_pelaksanaan' => $request->input("tanggal_konten.$contentId") ?? null,
                    ]);
                }
            }
        }
    }


    private function handleBadalItems(Request $request, Service $service)
    {
        if ($request->has('nama_badal')) {
            foreach ($request->nama_badal as $index => $nama) {
                if (!empty($nama)) {
                    Badal::create([
                        'service_id' => $service->id,
                        'name' => $nama,
                        'price' => $request->harga_badal[$index] ?? 0,
                        'tanggal_pelaksanaan' => $request->tanggal_pelaksanaan_badal[$index] ?? ''
                    ]);
                }
            }
        }
    }

    public function bayar(Order $order)
    {
        // Muat semua relasi yang mungkin terkait dengan service
        $order->load([
            'service.pelanggan',

            // Transportasi (Udara & Darat)
            'service.planes',
            'service.transportationItem.transportation',
            'service.transportationItem.route',

            // Hotel & Tipe Kamar
            'service.hotels', // <-- HAPUS .types DARI SINI

            // Dokumen
            'service.documents.document',      // Untuk memuat nama dokumen induk
            'service.documents.documentChild', // Untuk memuat nama dokumen turunan

            // Handling
            'service.handlings.handlingHotels',
            'service.handlings.handlingPlanes',

            // Pendamping
            'service.guides.guideItem',

            // Konten
            'service.contents.content',

            // Reyal
            'service.reyals', // Asumsi nama relasi di Service.php adalah reyals()

            // Tour
            'service.tours.tourItem',
            'service.tours.transportation',

            // Meals
            'service.meals.mealItem',

            // Dorongan
            'service.dorongans.dorongan',

            // Wakaf
            'service.wakafs.wakaf',

            // Badal Umrah
            'service.badals',
        ]);

        return view('admin.order.bayar', compact('order'));
    }

    public function payment(Request $request, Order $order)
    {
        $request->validate([
            'jumlah_dibayarkan' => 'required|numeric|min:1',
        ]);

        $jumlahBayar = (int) $request->jumlah_dibayarkan;

        DB::beginTransaction();

        try {
            // Hitung total pembayaran & sisa hutang
            $totalDibayarBaru = $order->total_yang_dibayarkan + $jumlahBayar;
            $sisaHutangBaru = $order->total_amount - $totalDibayarBaru;

            // Tentukan status order lama
            $statusLama = $sisaHutangBaru <= 0 ? 'lunas' : 'sudah_bayar';

            // Update order lama
            $order->update([
                'total_yang_dibayarkan' => $totalDibayarBaru,
                'sisa_hutang' => max(0, $sisaHutangBaru),
                'status_pembayaran' => $statusLama,
            ]);

            // Kalau masih ada hutang → buat order baru khusus sisa hutang
            if ($sisaHutangBaru > 0) {
                $newInvoice = 'INV-' . date('YmdHis') . '-' . mt_rand(100, 999);

                Order::create([
                    'service_id' => $order->service_id,
                    'total_amount' => $sisaHutangBaru,
                    'total_yang_dibayarkan' => 0,
                    'sisa_hutang' => $sisaHutangBaru,
                    'invoice' => $newInvoice,
                    'status_pembayaran' => 'belum_bayar',
                ]);
            }

            DB::commit();

            return redirect()->route('admin.order')
                ->with('success', 'Pembayaran berhasil! Sisa hutang: Rp. ' . number_format(max(0, $sisaHutangBaru), 0, ',', '.'));
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Gagal memproses pembayaran: ' . $e->getMessage());
        }
    }
}
