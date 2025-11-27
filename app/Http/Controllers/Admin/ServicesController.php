<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\ServiceRequest;
use App\Models\ContentCustomer;
use App\Models\ContentItem;
use App\Models\Exchange;
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
use Illuminate\Validation\Rule;

class ServicesController extends Controller
{
    public function index(Request $request)
    {
        $searchKeyword = $request->input('search');

        $query = Service::query()->latest();

        if ($searchKeyword) {
            $query->where(function ($q) use ($searchKeyword) {
                $q->where('unique_code', 'LIKE', '%' . $searchKeyword . '%')

                    ->orWhere('services', 'LIKE', '%' . $searchKeyword . '%')

                    ->orWhereHas('pelanggan', function ($subQ) use ($searchKeyword) {
                        $subQ->where('nama_travel', 'LIKE', '%' . $searchKeyword . '%');
                    });
            });
        }

        // 7. Eager load & Paginate
        $services = $query->with('pelanggan') // Muat relasi pelanggan
            ->paginate(10)      // Ambil 10 data per halaman
            ->appends($request->query()); // Pertahankan filter di pagination

        $countBadalNego = Badal::where('status', 'nego')->count();
        $countContentCustomerNego = ContentCustomer::where('status', 'nego')->count();
        $countCustomerDocumentNego = CustomerDocument::where('status', 'nego')->count();
        $countDoronganOrderNego = DoronganOrder::where('status', 'nego')->count();
        $countExchangeNego = Exchange::where('status', 'nego')->count(); // Corrected typo: Exchange
        $countGuideNego = Guide::where('status', 'nego')->count();
        $countHandlingHotelNego = HandlingHotel::where('status', 'nego')->count();
        $countHandlingPlaneNego = HandlingPlanes::where('status', 'nego')->count();
        $countHotelNego = Hotel::where('status', 'nego')->count();
        $countMealNego = Meal::where('status', 'nego')->count();
        $countPlaneNego = Plane::where('status', 'nego')->count();
        $countTourNego = Tour::where('status', 'nego')->count();
        $countTransportationItemNego = TransportationItem::where('status', 'nego')->count();
        $countWakafCustomerNego = WakafCustomer::where('status', 'nego')->count();

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

        $countBadalDeal = Badal::where('status', 'deal')->count();
        $countContentCustomerDeal = ContentCustomer::where('status', 'deal')->count();
        $countCustomerDocumentDeal = CustomerDocument::where('status', 'deal')->count();
        $countDoronganOrderDeal = DoronganOrder::where('status', 'deal')->count();
        $countExchangeDeal = Exchange::where('status', 'deal')->count(); // Corrected typo: Exchange
        $countGuideDeal = Guide::where('status', 'deal')->count();
        $countHandlingHotelDeal = HandlingHotel::where('status', 'deal')->count();
        $countHandlingPlaneDeal = HandlingPlanes::where('status', 'deal')->count();
        $countHotelDeal = Hotel::where('status', 'deal')->count();
        $countMealDeal = Meal::where('status', 'deal')->count();
        $countPlaneDeal = Plane::where('status', 'deal')->count();
        $countTourDeal = Tour::where('status', 'deal')->count();
        $countTransportationItemDeal = TransportationItem::where('status', 'deal')->count();
        $countWakafCustomerDeal = WakafCustomer::where('status', 'deal')->count();

        $totalDealOverall =
            $countBadalDeal +
            $countContentCustomerDeal +
            $countCustomerDocumentDeal +
            $countDoronganOrderDeal +
            $countExchangeDeal +
            $countGuideDeal +
            $countHandlingHotelDeal +
            $countHandlingPlaneDeal +
            $countHotelDeal +
            $countMealDeal +
            $countPlaneDeal +
            $countTourDeal +
            $countTransportationItemDeal +
            $countWakafCustomerDeal;

        $countBadalPersiapan = Badal::where('status', 'tahap persiapan')->count();
        $countContentCustomerPersiapan = ContentCustomer::where('status', 'tahap persiapan')->count();
        $countCustomerDocumentPersiapan = CustomerDocument::where('status', 'tahap persiapan')->count();
        $countDoronganOrderPersiapan = DoronganOrder::where('status', 'tahap persiapan')->count();
        $countExchangePersiapan = Exchange::where('status', 'tahap persiapan')->count();
        $countGuidePersiapan = Guide::where('status', 'tahap persiapan')->count();
        $countHandlingHotelPersiapan = HandlingHotel::where('status', 'tahap persiapan')->count();

        $countHandlingPlanePersiapan = HandlingPlanes::where('status', 'tahap persiapan')->count();
        $countHotelPersiapan = Hotel::where('status', 'tahap persiapan')->count();
        $countMealPersiapan = Meal::where('status', 'tahap persiapan')->count();
        $countPlanePersiapan = Plane::where('status', 'tahap persiapan')->count();
        $countTourPersiapan = Tour::where('status', 'tahap persiapan')->count();
        $countTransportationItemPersiapan = TransportationItem::where('status', 'tahap persiapan')->count();
        $countWakafCustomerPersiapan = WakafCustomer::where('status', 'tahap persiapan')->count();

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
        $countBadalProduksi = Badal::where('status', 'tahap_produksi')->count();
        $countContentCustomerProduksi = ContentCustomer::where('status', 'tahap_produksi')->count();
        $countCustomerDocumentProduksi = CustomerDocument::where('status', 'tahap_produksi')->count();
        $countDoronganOrderProduksi = DoronganOrder::where('status', 'tahap_produksi')->count();
        $countExchangeProduksi = Exchange::where('status', 'tahap_produksi')->count();
        $countGuideProduksi = Guide::where('status', 'tahap_produksi')->count();
        $countHandlingHotelProduksi = HandlingHotel::where('status', 'tahap_produksi')->count();
        $countHandlingPlaneProduksi = HandlingPlanes::where('status', 'tahap_produksi')->count();
        $countHotelProduksi = Hotel::where('status', 'tahap_produksi')->count();
        $countMealProduksi = Meal::where('status', 'tahap_produksi')->count();
        $countPlaneProduksi = Plane::where('status', 'tahap_produksi')->count();
        $countTourProduksi = Tour::where('status', 'tahap_produksi')->count();
        $countTransportationItemProduksi = TransportationItem::where('status', 'tahap_produksi')->count();
        $countWakafCustomerProduksi = WakafCustomer::where('status', 'tahap_produksi')->count();

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
        $countBadalDone = Badal::where('status', 'done')->count();
        $countContentCustomerDone = ContentCustomer::where('status', 'done')->count();
        $countCustomerDocumentDone = CustomerDocument::where('status', 'done')->count();
        $countDoronganOrderDone = DoronganOrder::where('status', 'done')->count();
        $countExchangeDone = Exchange::where('status', 'done')->count();
        $countGuideDone = Guide::where('status', 'done')->count();
        $countHandlingHotelDone = HandlingHotel::where('status', 'done')->count();
        $countHandlingPlaneDone = HandlingPlanes::where('status', 'done')->count();
        $countHotelDone = Hotel::where('status', 'done')->count();
        $countMealDone = Meal::where('status', 'done')->count();
        $countPlaneDone = Plane::where('status', 'done')->count();
        $countTourDone = Tour::where('status', 'done')->count();
        $countTransportationItemDone = TransportationItem::where('status', 'done')->count();
        $countWakafCustomerDone = WakafCustomer::where('status', 'done')->count();

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

        return view('admin.services.index', compact('services', 'totalNegoOverall', 'totalDealOverall', 'totalPersiapanOverall', 'totalProduksiOverall', 'totalDoneOverall'));
    }

    public function create()
    {
        $data = [
            'pelanggans' => Pelanggan::where('status', 'active')->get(),
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

    public function store(ServiceRequest $request)
    {
        try {
            DB::beginTransaction();

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

            $serverTotalAmount = $this->calculateTotalServicePrice($service);

            Order::create([
                'service_id' => $service->id,
                'invoice' => 'INV-' . time(),
                'total_estimasi' => $serverTotalAmount,
                'total_amount_final' => null,
                'total_yang_dibayarkan' => 0,
                'sisa_hutang' => $serverTotalAmount,
                'status_pembayaran' => 'belum_bayar',
                'status_harga' => 'provisional'
            ]);
            DB::commit();

            return redirect()->route('admin.services')->with('success', 'Data service berhasil disimpan.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()
                ->withInput()
                ->withErrors(['msg' => 'Terjadi kesalahan saat menyimpan data: ' . $e->getMessage()]);
        }
    }

    public function show($id)
    {
        $service = Service::with([
            'pelanggan',
            'planes',
            'transportationItem.transportation',
            'transportationItem.route',
            'hotels',
            'documents.document',
            'documents.documentChild',
            'handlings.handlingHotels',
            'handlings.handlingPlanes',
            'guides.guideItem',
            'contents.content',
            'exchanges',
            'tours.tourItem',
            'tours.transportation',
            'meals.mealItem',
            'dorongans.dorongan',
            'wakafs.wakaf',
            'badals',

        ])->findOrFail($id);
        return view('admin.services.show', compact('service'));
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

        // 1. Tambahkan Validasi di sini
        $validated = $request->validate([
            'pas_foto' => 'required|file|image|max:2048', // Wajib, file, gambar, maks 2MB
            'paspor' => 'required|file|mimes:pdf,jpg,png|max:2048', // Wajib, file, tipe tertentu
            'ktp' => 'required|file|mimes:pdf,jpg,png|max:2048',
            'visa' => 'required|file|mimes:pdf,jpg,png|max:2048',
        ]);

        // 2. Karena sudah divalidasi 'required', kita tahu filenya ada.
        // Kita bisa langsung store tanpa 'if'.
        $path = $request->file('pas_foto')->store('/', 'public');
        $pathPaspor = $request->file('paspor')->store('/', 'public');
        $pathktp = $request->file('ktp')->store('/', 'public');
        $pathvisa = $request->file('visa')->store('/', 'public');

        // 3. Simpan ke tabel files
        File::create([
            'service_id' => $service->id,
            'pas_foto' => $path,
            'paspor' => $pathPaspor,
            'ktp' => $pathktp,
            'visa' => $pathvisa,
        ]);

        return redirect()->route('admin.services')->with('success', 'Berkas berhasil diupload.');
    }

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

    public function edit($id)
    {
        $service = Service::with([
            'pelanggan',
            'hotels',
            'planes',
            'transportationItem',
            'handlings.handlingHotels',
            'handlings.handlingPlanes',
            'meals',
            'guides',
            'tours',
            'documents',
            'wakafs',
            'dorongans',
            'contents',
            'badals',
            'exchanges'
        ])->findOrFail($id);

        $data = [
            'service' => $service,
            'selectedServices' => json_decode($service->services, true) ?? [],
            'pelanggans' => Pelanggan::all(),
            'transportations' => Transportation::with('routes')->get(),
            'guides' => GuideItems::all(),
            'tours' => TourItem::all(),
            'meals' => MealItem::all(),
            'documents' => DocumentModel::with('childrens')->get(),
            'wakaf' => Wakaf::all(),
            'dorongan' => Dorongan::all(),
            'contents' => ContentItem::all(),
            'types' => TypeHotel::all(),
        ];

        return view('admin.services.edit', $data);
    }
    public function update(Request $request, $id)
    {
        $service = Service::findOrFail($id);
        $status = $request->input('action') === 'nego' ? 'nego' : 'deal';

        DB::transaction(function () use ($request, $service, $status) {

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
             * ✈️ UPDATE / TAMBAH / HAPUS DATA PESAWAT
             * ===================================================== */

            // PERBAIKAN: Cek dulu apakah service 'transportasi' masih DIPILIH di form utama
            if ($request->has('services') && in_array('transportasi', $request->services)) {

                // JIKA 'transportasi' MASIH DIPILIH:

                // Cek apakah sub-service 'airplane' DIPILIH
                if ($request->has('transportation_types') && in_array('airplane', $request->transportation_types)) {
                    $existingPlaneIds = collect($request->plane_id)->filter()->toArray();

                    // Hapus tiket yang checkbox-nya dihapus oleh user
                    Plane::where('service_id', $service->id)
                        ->whereNotIn('id', $existingPlaneIds)
                        ->delete();

                    // Update / Tambah tiket yang ada di form
                    foreach ($request->rute as $i => $rute) {
                        if (empty($rute))
                            continue;

                        $plane = $service->planes()->find($request->plane_id[$i]) ?? new Plane();

                        $plane->service_id = $service->id;
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
                } else {
                    // 'transportasi' DIPILIH, TAPI tidak ada data 'rute'.
                    // Artinya user hanya memilih 'Transportasi Darat'
                    // Kita hapus semua data Pesawat.
                    Plane::where('service_id', $service->id)->delete();
                }
            } else {
                // JIKA 'transportasi' TIDAK DIPILIH SAMA SEKALI
                // Hapus semua data pesawat yang terkait dengan service ini.
                Plane::where('service_id', $service->id)->delete();
            }

            /* =====================================================
             * 🚌 TRANSPORTASI
             * ===================================================== */

            // PERBAIKAN: Cek dulu apakah service 'transportasi' masih DIPILIH di form utama
            if ($request->has('services') && in_array('transportasi', $request->services)) {

                // JIKA 'transportasi' MASIH DIPILIH:

                // Cek apakah sub-service 'bus' DIPILIH
                if ($request->has('transportation_types') && in_array('bus', $request->transportation_types)) {
                    // Hapus semua item lama (logika delete-dan-recreate Anda sudah benar)
                    TransportationItem::where('service_id', $service->id)->delete();

                    // Buat ulang berdasarkan data form
                    foreach ($request->transportation_id as $i => $transportId) {
                        if (empty($transportId))
                            continue;

                        TransportationItem::create([
                            'service_id' => $service->id,
                            'transportation_id' => $transportId,
                            'route_id' => $request->rute_id[$i] ?? null,
                            'dari_tanggal' => $request->transport_dari[$i] ?? null,
                            'sampai_tanggal' => $request->transport_sampai[$i] ?? null,
                        ]);
                    }
                } else {
                    // 'transportasi' DIPILIH, TAPI tidak ada data 'transportation_id'.
                    // Artinya user hanya memilih 'Pesawat'.
                    // Kita hapus semua data Transportasi Darat.
                    TransportationItem::where('service_id', $service->id)->delete();
                }
            } else {
                // JIKA 'transportasi' TIDAK DIPILIH SAMA SEKALI
                // Hapus semua data transportasi darat yang terkait dengan service ini.
                TransportationItem::where('service_id', $service->id)->delete();
            }

            /* =====================================================
             * 📄 DOKUMEN
             * ===================================================== */

            // PERIKSA: Apakah 'dokumen' ada di array service utama?
            if ($request->has('services') && in_array('dokumen', $request->services)) {

                // JIKA YA: Hapus data lama untuk diganti dengan data baru
                CustomerDocument::where('service_id', $service->id)->delete();

                // --- (FIX) Ambil data master ---
                $childDocs = DocumentChildren::get()->keyBy('id');

                // --- (FIX) PROSES BASE DOCUMENTS (Siskopatuh, dll) ---
                // Kita baca array 'base_documents[]' yang baru kita buat di view
                if ($request->has('base_documents')) {
                    // Ambil array asosiatif [ID => jumlah]
                    $baseDocumentQuantities = $request->input('jumlah_base_doc', []);

                    foreach ($request->base_documents as $baseDocId) {
                        if (empty($baseDocId))
                            continue;

                        // Ambil jumlah dari array asosiatif
                        $jumlah = $baseDocumentQuantities[$baseDocId] ?? 0;

                        if ($jumlah > 0) {
                            CustomerDocument::create([
                                'service_id' => $service->id,
                                'jumlah' => $jumlah,
                                'document_id' => $baseDocId, // ID Parent (Misal: Siskopatuh)
                                'document_children_id' => null, // Ini adalah dokumen dasar, jadi null
                                'harga' => 0, // Asumsi base doc tidak ada harga
                            ]);
                        }
                    }
                }

                // --- (FIX) PROSES CHILD DOCUMENTS (Visa Ziarah, dll) ---
                // Kita baca array 'child_documents[]' yang baru kita buat di view
                if ($request->has('child_documents')) {
                    // Ambil array asosiatif [ID => jumlah]
                    $childDocumentQuantities = $request->input('jumlah_child_doc', []);

                    foreach ($request->child_documents as $childDocId) {
                        if (empty($childDocId))
                            continue;

                        // Ambil data child dari collection
                        $child = $childDocs->get($childDocId);

                        if ($child) { // Pastikan child-nya ada
                            // Ambil jumlah dari array asosiatif
                            $jumlah = $childDocumentQuantities[$childDocId] ?? 0;

                            if ($jumlah > 0) {
                                CustomerDocument::create([
                                    'service_id' => $service->id,
                                    'jumlah' => $jumlah,
                                    'document_id' => $child->document_id, // ID Parent (Misal: Visa)
                                    'document_children_id' => $childDocId, // ID Child (Misal: Visa Ziarah)
                                    'harga' => $child->price ?? 0,
                                ]);
                            }
                        }
                    }
                }

            } else {
                // JIKA TIDAK: 'dokumen' di-uncheck, HAPUS SEMUA data dokumen
                CustomerDocument::where('service_id', $service->id)->delete();
            }

            /* =====================================================
             * 🏨 HANDLING HOTEL & 🛬 HANDLING BANDARA
             * ===================================================== */

            if ($request->has('services') && in_array('handling', $request->services)) {

                // (PERBAIKAN) Cek sub-item 'hotel'
                if ($request->has('handlings') && in_array('hotel', $request->handlings)) {

                    // Cari parent 'Handling' dulu, atau buat baru
                    $handlingModel = $service->handlings()->firstOrCreate(['name' => 'hotel']);

                    // Cari HandlingHotel, atau buat baru
                    $handlingHotel = $handlingModel->handlingHotels()->first() ?? new HandlingHotel();

                    // Siapkan data
                    $hotelData = [
                        'nama' => $request->nama_hotel_handling,
                        'tanggal' => $request->tanggal_hotel_handling,
                        'harga' => $request->harga_hotel_handling,
                        'pax' => $request->pax_hotel_handling,
                    ];

                    // Handle file uploads
                    if ($request->hasFile('kode_booking_hotel_handling')) {
                        if ($handlingHotel->kode_booking) {
                            Storage::disk('public')->delete($handlingHotel->kode_booking);
                        }
                        $hotelData['kode_booking'] = $request->file('kode_booking_hotel_handling')->store('handling/hotel', 'public');
                    }
                    if ($request->hasFile('rumlis_hotel_handling')) {
                        if ($handlingHotel->rumlis) {
                            Storage::disk('public')->delete($handlingHotel->rumlis);
                        }
                        $hotelData['rumlis'] = $request->file('rumlis_hotel_handling')->store('handling/hotel', 'public');
                    }
                    if ($request->hasFile('identitas_hotel_handling')) {
                        if ($handlingHotel->identitas_koper) {
                            Storage::disk('public')->delete($handlingHotel->identitas_koper);
                        }
                        $hotelData['identitas_koper'] = $request->file('identitas_hotel_handling')->store('handling/hotel', 'public');
                    }

                    // Simpan data
                    $handlingModel->handlingHotels()->updateOrCreate(['id' => $handlingHotel->id], $hotelData);

                } else {
                    // 'hotel' tidak dicentang, hapus datanya
                    $handlingModel = $service->handlings()->where('name', 'hotel')->first();
                    if ($handlingModel) {
                        // Hapus file terkait sebelum menghapus record
                        if ($handlingModel->handlingHotels) {
                            if ($handlingModel->handlingHotels->kode_booking)
                                Storage::disk('public')->delete($handlingModel->handlingHotels->kode_booking);
                            if ($handlingModel->handlingHotels->rumlis)
                                Storage::disk('public')->delete($handlingModel->handlingHotels->rumlis);
                            if ($handlingModel->handlingHotels->identitas_koper)
                                Storage::disk('public')->delete($handlingModel->handlingHotels->identitas_koper);
                        }
                        $handlingModel->handlingHotels()->delete(); // Hapus child
                        $handlingModel->delete(); // Hapus parent
                    }
                }

                // Cek sub-item 'bandara'
                if ($request->has('handlings') && in_array('bandara', $request->handlings)) {

                    $handlingModel = $service->handlings()->firstOrCreate(['name' => 'bandara']);
                    $handlingPlanes = $handlingModel->handlingPlanes()->first() ?? new HandlingPlanes();

                    $planeData = [
                        'nama_bandara' => $request->nama_bandara_handling,
                        'jumlah_jamaah' => $request->jumlah_jamaah_handling,
                        'harga' => $request->harga_bandara_handling,
                        'kedatangan_jamaah' => $request->kedatangan_jamaah_handling,
                        'nama_supir' => $request->nama_supir,
                    ];

                    // Handle file uploads
                    if ($request->hasFile('paket_info')) {
                        if ($handlingPlanes->paket_info) {
                            Storage::disk('public')->delete($handlingPlanes->paket_info);
                        }
                        $planeData['paket_info'] = $request->file('paket_info')->store('handling/bandara', 'public');
                    }
                    if ($request->hasFile('identitas_koper_bandara_handling')) {
                        if ($handlingPlanes->identitas_koper) {
                            Storage::disk('public')->delete($handlingPlanes->identitas_koper);
                        }
                        $planeData['identitas_koper'] = $request->file('identitas_koper_bandara_handling')->store('handling/bandara', 'public');
                    }

                    // Simpan data
                    $handlingModel->handlingPlanes()->updateOrCreate(['id' => $handlingPlanes->id], $planeData);

                } else {
                    // 'bandara' tidak dicentang, hapus datanya
                    $handlingModel = $service->handlings()->where('name', 'bandara')->first();
                    if ($handlingModel) {
                        // Hapus file terkait sebelum menghapus record
                        if ($handlingModel->handlingPlanes) {
                            if ($handlingModel->handlingPlanes->paket_info)
                                Storage::disk('public')->delete($handlingModel->handlingPlanes->paket_info);
                            if ($handlingModel->handlingPlanes->identitas_koper)
                                Storage::disk('public')->delete($handlingModel->handlingPlanes->identitas_koper);
                        }
                        $handlingModel->handlingPlanes()->delete(); // Hapus child
                        $handlingModel->delete(); // Hapus parent
                    }
                }

            } else {
                // 'handling' utama tidak dicentang, hapus semua
                $service->handlings()->each(function ($handling) {
                    // Hapus semua file terkait
                    if ($handling->handlingHotels) {
                        if ($handling->handlingHotels->kode_booking)
                            Storage::disk('public')->delete($handling->handlingHotels->kode_booking);
                        if ($handling->handlingHotels->rumlis)
                            Storage::disk('public')->delete($handling->handlingHotels->rumlis);
                        if ($handling->handlingHotels->identitas_koper)
                            Storage::disk('public')->delete($handling->handlingHotels->identitas_koper);
                    }
                    if ($handling->handlingPlanes) {
                        if ($handling->handlingPlanes->paket_info)
                            Storage::disk('public')->delete($handling->handlingPlanes->paket_info);
                        if ($handling->handlingPlanes->identitas_koper)
                            Storage::disk('public')->delete($handling->handlingPlanes->identitas_koper);
                    }

                    $handling->handlingHotels()->delete();
                    $handling->handlingPlanes()->delete();
                    $handling->delete();
                });
            }

            /* =====================================================
             * 👥 PENDAMPING (GUIDES) - PERBAIKAN
             * ===================================================== */
            // Cek apakah service 'pendamping' aktif
            if ($request->has('services') && in_array('pendamping', $request->services)) {
                // Ya, service aktif. Hapus data lama.
                Guide::where('service_id', $service->id)->delete();

                // Buat ulang data dari form
                if ($request->has('jumlah_pendamping')) {
                    foreach ($request->jumlah_pendamping as $id => $jumlah) {
                        // Hanya buat jika jumlah lebih dari 0 dan datanya dikirim (tidak disabled)
                        if ($jumlah !== null && $jumlah > 0) {
                            Guide::create([
                                'service_id' => $service->id,
                                'guide_id' => $id,
                                'jumlah' => $jumlah,
                                'muthowif_dari' => $request->pendamping_dari[$id] ?? null,
                                'muthowif_sampai' => $request->pendamping_sampai[$id] ?? null,
                            ]);
                        }
                    }
                }
            } else {
                // Tidak, service 'pendamping' di-uncheck. Hapus semua.
                Guide::where('service_id', $service->id)->delete();
            }

            /* =====================================================
             * 📸 KONTEN (CONTENT) - PERBAIKAN
             * ===================================================== */
            if ($request->has('services') && in_array('konten', $request->services)) {
                // Service aktif, hapus data lama
                ContentCustomer::where('service_id', $service->id)->delete();

                // Buat ulang dari form
                if ($request->has('jumlah_konten')) {
                    foreach ($request->jumlah_konten as $id => $jumlah) {
                        if ($jumlah !== null && $jumlah > 0) {
                            ContentCustomer::create([
                                'service_id' => $service->id,
                                'content_id' => $id,
                                'jumlah' => $jumlah,
                                'tanggal_pelaksanaan' => $request->konten_tanggal[$id] ?? null,
                            ]);
                        }
                    }
                }
            } else {
                // Service tidak aktif, hapus semua
                ContentCustomer::where('service_id', $service->id)->delete();
            }

            /* =====================================================
             * 🍱 MEALS - PERBAIKAN
             * ===================================================== */
            if ($request->has('services') && in_array('meals', $request->services)) {
                // Service aktif, hapus data lama
                Meal::where('service_id', $service->id)->delete();

                // Buat ulang dari form
                if ($request->has('jumlah_meals')) {
                    foreach ($request->jumlah_meals as $id => $jumlah) {
                        if ($jumlah !== null && $jumlah > 0) {
                            Meal::create([
                                'service_id' => $service->id,
                                'meal_id' => $id,
                                'jumlah' => $jumlah,
                                'dari_tanggal' => $request->meals_dari[$id] ?? null,
                                'sampai_tanggal' => $request->meals_sampai[$id] ?? null,
                            ]);
                        }
                    }
                }
            } else {
                // Service tidak aktif, hapus semua
                Meal::where('service_id', $service->id)->delete();
            }

            /* =====================================================
             * 💸 DORONGAN - PERBAIKAN
             * ===================================================== */
            if ($request->has('services') && in_array('dorongan', $request->services)) {
                // Service aktif, hapus data lama
                DoronganOrder::where('service_id', $service->id)->delete();

                // Buat ulang dari form
                if ($request->has('jumlah_dorongan')) {
                    foreach ($request->jumlah_dorongan as $id => $jumlah) {
                        if ($jumlah !== null && $jumlah > 0) {
                            DoronganOrder::create([
                                'service_id' => $service->id,
                                'dorongan_id' => $id,
                                'jumlah' => $jumlah,
                                'tanggal_pelaksanaan' => $request->dorongan_tanggal[$id] ?? null,
                            ]);
                        }
                    }
                }
            } else {
                // Service tidak aktif, hapus semua
                DoronganOrder::where('service_id', $service->id)->delete();
            }

            /* =====================================================
             * 💰 WAKAF - PERBAIKAN
             * ===================================================== */
            if ($request->has('services') && in_array('waqaf', $request->services)) {
                // Service aktif, hapus data lama
                WakafCustomer::where('service_id', $service->id)->delete();

                // Buat ulang dari form
                if ($request->has('jumlah_wakaf')) {
                    foreach ($request->jumlah_wakaf as $id => $jumlah) {
                        if ($jumlah !== null && $jumlah > 0) {
                            WakafCustomer::create([
                                'service_id' => $service->id,
                                'wakaf_id' => $id,
                                'jumlah' => $jumlah,
                            ]);
                        }
                    }
                }
            } else {
                // Service tidak aktif, hapus semua
                WakafCustomer::where('service_id', $service->id)->delete();
            }

            /* =====================================================
             * 💸 REYAL - PERBAIKAN BARU
             * ===================================================== */
            // Cek apakah service 'reyal' aktif
            if ($request->has('services') && in_array('reyal', $request->services)) {

                // Ya, service aktif. Hapus data lama (jika ada)
                Exchange::where('service_id', $service->id)->delete();

                // Validasi data baru (diambil dari 'handleReyalItems')
                $validatedData = $request->validate([
                    'tipe' => 'required|in:tamis,tumis',
                    'tanggal_penyerahan' => 'required|date',
                    'jumlah_rupiah' => 'required_if:tipe,tamis|nullable|numeric|min:0',
                    'kurs_tamis' => 'required_if:tipe,tamis|nullable|numeric|min:0',
                    'hasil_tamis' => 'required_if:tipe,tamis|nullable|numeric|min:0',
                    'jumlah_reyal' => 'required_if:tipe,tumis|nullable|numeric|min:0',
                    'kurs_tumis' => 'required_if:tipe,tumis|nullable|numeric|min:0',
                    'hasil_tumis' => 'required_if:tipe,tumis|nullable|numeric|min:0',
                ]);

                // Buat data Reyal yang baru
                if ($validatedData['tipe'] === 'tamis') {
                    $service->exchanges()->create([
                        'tipe' => 'tamis',
                        'jumlah_input' => $validatedData['jumlah_rupiah'],
                        'kurs' => $validatedData['kurs_tamis'],
                        'hasil' => $validatedData['hasil_tamis'],
                        'tanggal_penyerahan' => $validatedData['tanggal_penyerahan'],
                    ]);
                } else if ($validatedData['tipe'] === 'tumis') {
                    $service->exchanges()->create([
                        'tipe' => 'tumis',
                        'jumlah_input' => $validatedData['jumlah_reyal'],
                        'kurs' => $validatedData['kurs_tumis'],
                        'hasil' => $validatedData['hasil_tumis'],
                        'tanggal_penyerahan' => $validatedData['tanggal_penyerahan'],
                    ]);
                }

            } else {
                // Tidak, service 'reyal' di-uncheck. Hapus semua data Reyal.
                Exchange::where('service_id', $service->id)->delete();
            }

            /* =====================================================
             * 🕋 BADAL - PERBAIKAN
             * ===================================================== */
            // Cek apakah service 'badal' (layanan utama) masih aktif
            if ($request->has('services') && in_array('badal', $request->services)) {

                // Ya, service aktif. Hapus semua data badal lama.
                Badal::where('service_id', $service->id)->delete();

                // Buat ulang data dari form, HANYA JIKA 'nama_badal' dikirim
                if ($request->has('nama_badal')) {
                    foreach ($request->nama_badal as $i => $nama) {
                        if (empty($nama))
                            continue;

                        Badal::create([
                            'service_id' => $service->id,
                            'name' => $nama,
                            'price' => $request->harga_badal[$i] ?? 0,
                            'tanggal_pelaksanaan' => $request->tanggal_badal[$i] ?? null,
                        ]);
                    }
                }

            } else {
                // Tidak, service 'badal' di-uncheck. Hapus semua data badal.
                Badal::where('service_id', $service->id)->delete();
            }

            /* =====================================================
             * 🏨 HOTEL
             * ===================================================== */

            if ($request->has('services') && in_array('hotel', $request->services)) {

                if ($request->has('tanggal_checkin')) {

                    Hotel::where('service_id', $service->id)->delete();

                    foreach ($request->tanggal_checkin as $i => $checkin) {
                        if (empty($checkin))
                            continue;

                        Hotel::create([
                            'service_id' => $service->id,
                            'tanggal_checkin' => $checkin,
                            'tanggal_checkout' => $request->tanggal_checkout[$i] ?? null,
                            'nama_hotel' => $request->nama_hotel[$i] ?? null,
                            'jumlah_kamar' => $request->jumlah_kamar[$i] ?? 0,
                            'type' => $request->type_hotel[$i] ?? 'Standard',
                            'jumlah_type' => $request->jumlah_type[$i] ?? 0,
                        ]);
                    }
                } else {
                    Hotel::where('service_id', $service->id)->delete();
                }

            } else {
                Hotel::where('service_id', $service->id)->delete();
            }

            /* =====================================================
             * 🗺️ TOUR - PERBAIKAN
             * ===================================================== */
            // Cek apakah service 'tour' (layanan utama) masih aktif
            if ($request->has('services') && in_array('tour', $request->services)) {

                // Ya, service aktif. Hapus semua data tour lama.
                Tour::where('service_id', $service->id)->delete();

                // Buat ulang data dari form, HANYA JIKA ada tour_id yang dikirim
                // tour_id adalah array checkbox yang dicentang di view
                if ($request->has('tour_id') && is_array($request->tour_id)) {

                    // Loop SEMUA tour_id yang dicentang
                    foreach ($request->tour_id as $tourItemId) {
                        if (empty($tourItemId))
                            continue; // Lewati jika ada nilai kosong

                        // Ambil data transport & tanggal yang sesuai dari array asosiatif
                        $transportId = $request->input("tour_transport.$tourItemId") ?? null;
                        $tanggal = $request->input("tour_tanggal.$tourItemId") ?? null;

                        // Hanya simpan jika tanggal diisi (sesuai logika 'create')
                        if ($tanggal) {
                            Tour::create([
                                'service_id' => $service->id,
                                'tour_id' => $tourItemId, // Ini adalah ID dari master tour_items
                                'transportation_id' => $transportId,
                                'tanggal_keberangkatan' => $tanggal,
                            ]);
                        }
                    }
                }

            } else {
                // Tidak, service 'tour' di-uncheck. Hapus semua data tour.
                Tour::where('service_id', $service->id)->delete();
            }
        });

        return redirect()->route('admin.services.show', $service)
            ->with('success', 'Data service dan seluruh relasinya berhasil diperbarui.');
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
        $service->exchanges()->delete();
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
        // 1️⃣ Upload file dokumen (paspor & pas foto)
        $fileData = [];
        if ($request->hasFile('paspor_dokumen')) {
            if ($service->paspor_dokumen) {
                Storage::disk('public')->delete($service->paspor_dokumen);
            }
            $fileData['paspor_dokumen'] = $request->file('paspor_dokumen')->store('service-docs', 'public');
        }
        if ($request->hasFile('pas_foto_dokumen')) {
            if ($service->pas_foto_dokumen) {
                Storage::disk('public')->delete($service->pas_foto_dokumen);
            }
            $fileData['pas_foto_dokumen'] = $request->file('pas_foto_dokumen')->store('service-docs', 'public');
        }
        if (!empty($fileData)) {
            $service->update($fileData);
        }

        $validCustomerDocIds = [];
        $parentsReferencedByChildren = [];

        // --------------------------------------------------------------------------------------------------
        // 2️⃣ (Perubahan Urutan) PROSES DOKUMEN ANAK (Child Documents) TERLEBIH DAHULU
        // --------------------------------------------------------------------------------------------------
        $selectedChildren = $request->input('child_documents', []); //
        foreach ($selectedChildren as $childId) {
            $jumlah = $request->input("jumlah_child_doc.$childId", 1);
            $itemChild = DocumentChildren::find($childId);

            if ($itemChild && $jumlah > 0) {
                $customerDoc = $service->documents()->updateOrCreate(
                    [
                        'document_children_id' => $itemChild->id,
                    ],
                    [
                        'document_id' => $itemChild->document_id,
                        'jumlah' => $jumlah,
                        'harga' => $itemChild->price ?? 0,
                    ]
                );
                $validCustomerDocIds[] = $customerDoc->id;

                // 🆕 Rekam ID Parent (ID Dokumen Induk)
                $parentsReferencedByChildren[] = $itemChild->document_id;
            }
        }

        // --------------------------------------------------------------------------------------------------
        // 3️⃣ (Perubahan Urutan) PROSES DOKUMEN INDUK (Parent Documents)
        // --------------------------------------------------------------------------------------------------

        // Pastikan daftar parent yang ter-referensi unik
        $parentsReferencedByChildren = array_unique($parentsReferencedByChildren);

        // Ambil hanya dokumen INDUK yang dicentang
        $selectedParents = $request->input('dokumen_id', []); //

        foreach ($selectedParents as $parentId) {
            $parentId = (int) $parentId;

            // 🆕 KUNCI PERBAIKAN: Jika Parent ID sudah dicatat karena Dokumen Anaknya dipilih, skip.
            if (in_array($parentId, $parentsReferencedByChildren)) {
                continue;
            }

            $jumlah = $request->input("jumlah_doc_$parentId", 1);
            $document = Document::find($parentId);

            if ($document && $jumlah > 0) {
                // Simpan Parent Document (Standalone)
                $customerDoc = $service->documents()->updateOrCreate(
                    [
                        'document_id' => $parentId,
                        'document_children_id' => null, // Ini entri untuk Parent Dokumen
                    ],
                    [
                        'jumlah' => $jumlah,
                        'harga' => $document->price ?? 0,
                    ]
                );
                $validCustomerDocIds[] = $customerDoc->id;
            }
        }

        // 4️⃣ Hapus item yang tidak dipilih
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
            $service->exchanges()->create([
                'tipe' => 'tamis',
                'jumlah_input' => $validatedData['jumlah_rupiah'],
                'kurs' => $validatedData['kurs_tamis'],
                'hasil' => $validatedData['hasil_tamis'],
                'tanggal_penyerahan' => $validatedData['tanggal_penyerahan'],
            ]);
        } else if ($validatedData['tipe'] === 'tumis') {
            $service->exchanges()->create([
                'tipe' => 'tumis',
                'jumlah_input' => $validatedData['jumlah_reyal'],
                'kurs' => $validatedData['kurs_tumis'],
                'hasil' => $validatedData['hasil_tumis'],
                'tanggal_penyerahan' => $validatedData['tanggal_penyerahan'],
            ]);
        }
    }

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

    /**
     * Helper: Menghitung total harga service secara server-side
     * Digunakan oleh method store() dan update()
     */
    private function calculateTotalServicePrice(Service $service): float
    {
        $serverTotalAmount = 0;

        // Refresh relasi agar data yang diambil adalah data terbaru dari DB
        $service->load([
            'documents',
            'hotels',
            'badals',
            'meals.mealItem',
            'guides.guideItem',
            'tours.tourItem',
            'tours.transportation',
            'wakafs.wakaf',
            'dorongans.dorongan',
            'contents.content',
            'transportationItem.transportation',
            'transportationItem.route'
        ]);

        // 1. Transportasi Darat
        foreach ($service->transportationItem as $item) {
            if ($item->transportation && $item->route && $item->dari_tanggal && $item->sampai_tanggal) {
                try {
                    $hargaPerHari = $item->transportation->harga ?? 0;
                    $hargaRute = $item->route->price ?? 0;
                    $tanggalMulai = Carbon::parse($item->dari_tanggal);
                    $tanggalSelesai = Carbon::parse($item->sampai_tanggal);
                    $jumlahHari = $tanggalMulai->diffInDays($tanggalSelesai) + 1;
                    $serverTotalAmount += (($hargaPerHari * $jumlahHari) + $hargaRute);
                } catch (\Exception $e) {
                }
            }
        }

        // 2. Hotel
        foreach ($service->hotels as $hotel) {
            if ($hotel->tanggal_checkin && $hotel->tanggal_checkout && $hotel->harga_perkamar > 0 && $hotel->jumlah_type > 0) {
                try {
                    $checkin = Carbon::parse($hotel->tanggal_checkin);
                    $checkout = Carbon::parse($hotel->tanggal_checkout);
                    $jumlah_malam = $checkin->diffInDays($checkout);
                    if ($jumlah_malam <= 0)
                        $jumlah_malam = 1;
                    $serverTotalAmount += ($hotel->harga_perkamar * $hotel->jumlah_type) * $jumlah_malam;
                } catch (\Exception $e) {
                }
            }
        }

        // 3. Dokumen
        foreach ($service->documents as $doc) {
            $serverTotalAmount += ($doc->harga ?? 0) * ($doc->jumlah ?? 0);
        }

        // 4. Badal
        foreach ($service->badals as $badal) {
            $serverTotalAmount += $badal->price ?? 0;
        }

        // 5. Meals
        foreach ($service->meals as $mealCustomer) {
            $serverTotalAmount += ($mealCustomer->mealItem->price ?? 0) * ($mealCustomer->jumlah ?? 0);
        }

        // 6. Guides
        foreach ($service->guides as $guideCustomer) {
            $serverTotalAmount += ($guideCustomer->guideItem->harga ?? 0) * ($guideCustomer->jumlah ?? 0);
        }

        // 7. Tours (Harga Tour + Harga Transportasi Tour)
        foreach ($service->tours as $tour) {
            $tourPrice = (float) ($tour->tourItem->price ?? 0);
            $transportPrice = (float) ($tour->transportation->harga ?? 0);
            $serverTotalAmount += ($tourPrice + $transportPrice);
        }

        // 8. Wakaf
        foreach ($service->wakafs as $wakafCustomer) {
            $serverTotalAmount += ($wakafCustomer->wakaf->harga ?? 0) * ($wakafCustomer->jumlah ?? 0);
        }

        // 9. Dorongan
        foreach ($service->dorongans as $doronganOrder) {
            $serverTotalAmount += ($doronganOrder->dorongan->price ?? 0) * ($doronganOrder->jumlah ?? 0);
        }

        // 10. Content
        foreach ($service->contents as $contentCustomer) {
            $serverTotalAmount += ($contentCustomer->content->price ?? 0) * ($contentCustomer->jumlah ?? 0);
        }

        // 11. Handling & Lainnya (Tambahkan logika handling jika handling memiliki harga fix per pax)
        // Jika HandlingHotel / HandlingPlane punya harga dan jumlah, tambahkan disini.
        // Contoh:
        foreach ($service->handlings as $handling) {
            foreach ($handling->handlingHotels as $hh) {
                $serverTotalAmount += ($hh->harga ?? 0) * ($hh->pax ?? 0);
            }
            foreach ($handling->handlingPlanes as $hp) {
                $serverTotalAmount += ($hp->harga ?? 0) * ($hp->jumlah_jamaah ?? 0);
            }
        }

        return $serverTotalAmount;
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
            'service.exchanges', // Asumsi nama relasi di Service.php adalah exchanges()

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
