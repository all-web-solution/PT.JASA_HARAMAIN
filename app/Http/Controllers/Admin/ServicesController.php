<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
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
    /**
     * Tampilkan daftar layanan.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\View\View
     */
    public function index(Request $request)
    {
        // 1. Ambil input search
        $searchKeyword = $request->input('search');

        // 2. Mulai query
        $query = Service::query()->latest(); // Urutkan terbaru dulu

        // 3. Terapkan Search
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
        $services = $request->input('services', []);
        // 1. Kondisi untuk Layanan Utama Transportasi
        $isMainTransportationSelected = $request->has('services') && is_array($request->services) && in_array('transportasi', $request->services);

        // 2. Kondisi untuk Transportasi Darat ('bus')
        $isBusSelected = $isMainTransportationSelected &&
            $request->has('transportation') && is_array($request->transportation) && in_array('bus', $request->transportation);

        // 3. Kondisi untuk Transportasi Udara ('airplane')
        $isPlaneSelected = $isMainTransportationSelected &&
            $request->has('transportation') && is_array($request->transportation) && in_array('airplane', $request->transportation);

        // 4. Kondisi untuk Layanan Hotel
        $isHotelSelected = $request->has('services') && is_array($request->services) && in_array('hotel', $request->services);

        // 5. Kondisi untuk Layanan Dokumen
        $isDocumentSelected = $request->has('services') && is_array($request->services) && in_array('dokumen', $request->services);
        // Kondisi Baru: Handling & Pendamping
        $isHandlingSelected = in_array('handling', $services);
        $isPendampingSelected = in_array('pendamping', $services);

        // Handling (Baru)
        $handlingTypes = $request->input('handlings', []);
        $isHandlingHotelSelected = $isHandlingSelected && in_array('hotel', $handlingTypes);
        $isHandlingBandaraSelected = $isHandlingSelected && in_array('bandara', $handlingTypes);

        // Konten
        $isKontenSelected = in_array('konten', $services);
        $isReyalSelected = in_array('reyal', $services);

        // Cek tipe reyal untuk validasi kondisional
        $reyalType = $request->input('tipe');

        $isTourSelected = in_array('tour', $services);
        $isMealSelected = in_array('meals', $services);
        $isDoronganSelected = in_array('dorongan', $services);

        $request->validate([
            'travel' => 'required|exists:pelanggans,id',
            'services' => 'required|array',
            'tanggal_keberangkatan' => 'required|date',
            'tanggal_kepulangan' => 'required|date',
            'total_jamaah' => 'required|integer',
            'email' => 'required|email',
            'phone' => 'required|string',

            // --- VALIDASI UNTUK PEMILIHAN SUB-LAYANAN TRANSPORTASI ---
            'transportation' => $isMainTransportationSelected ? 'required|array|min:1' : 'nullable|array',

            // --- TRANSPORTASI DARAT (GROUND) ---
            'transportation_id' => $isBusSelected ? 'required|array|min:1' : 'nullable|array',
            'transportation_id.*' => $isBusSelected ? 'required|exists:transportations,id' : 'nullable',
            'rute_id' => $isBusSelected ? 'required|array|min:1' : 'nullable|array',
            'rute_id.*' => $isBusSelected ? 'required|exists:routes,id' : 'nullable',
            'tanggal_transport' => $isBusSelected ? 'required|array|min:1' : 'nullable|array',
            'tanggal_transport.*.dari' => $isBusSelected ? 'required|date' : 'nullable|date',
            'tanggal_transport.*.sampai' => $isBusSelected ? 'required|date|after_or_equal:tanggal_transport.*.dari' : 'nullable|date',

            // --- TRANSPORTASI UDARA (PESAWAT) ---
            'rute' => $isPlaneSelected ? 'required|array|min:1' : 'nullable|array',
            'tanggal' => $isPlaneSelected ? 'required|array|min:1' : 'nullable|array',
            'rute.*' => $isPlaneSelected ? 'required|string' : 'nullable|string',
            'tanggal.*' => $isPlaneSelected ? 'required|date' : 'nullable|date',
            'maskapai.*' => $isPlaneSelected ? 'required|string' : 'nullable|string',
            'harga_tiket.*' => $isPlaneSelected ? 'required|numeric|min:0' : 'nullable|numeric|min:0',
            'jumlah.*' => $isPlaneSelected ? 'required|integer|min:1' : 'nullable|integer|min:0',
            'tiket_berangkat.*' => 'nullable|file|mimes:pdf,jpg,png|max:2048',
            'tiket_pulang.*' => 'nullable|file|mimes:pdf,jpg,png|max:2048',

            // --- VALIDASI HOTEL ---
            'nama_hotel' => $isHotelSelected ? 'required|array|min:1' : 'nullable|array',
            'nama_hotel.*' => $isHotelSelected ? 'required|string|filled' : 'nullable',

            'tanggal_checkin' => $isHotelSelected ? 'required|array|min:1' : 'nullable|array',
            'tanggal_checkin.*' => $isHotelSelected ? 'required|date' : 'nullable',

            'tanggal_checkout' => $isHotelSelected ? 'required|array|min:1' : 'nullable|array',
            'tanggal_checkout.*' => $isHotelSelected ? 'required|date|after:tanggal_checkin.*' : 'nullable',

            'jumlah_kamar' => $isHotelSelected ? 'required|array|min:1' : 'nullable|array',
            'jumlah_kamar.*' => $isHotelSelected ? 'required|integer|min:1' : 'nullable',

            'hotel_data' => [
                $isHotelSelected ? 'required' : 'nullable',
                'array',
                function ($attribute, $value, $fail) use ($request, $isHotelSelected) {
                    if (!$isHotelSelected)
                        return;

                    $hotelIndexes = array_keys($request->input('nama_hotel', []));

                    foreach ($hotelIndexes as $index) {
                        if (!isset($value[$index]) || !is_array($value[$index]) || count($value[$index]) < 1) {
                            $namaHotel = $request->input("nama_hotel.$index", "Hotel ke-" . ($index + 1));
                            $fail("Hotel '$namaHotel' wajib memiliki minimal satu Tipe Kamar yang dipilih.");
                        }
                    }
                },
            ],

            'hotel_data.*.*.jumlah' => $isHotelSelected ? 'required|integer|min:1' : 'nullable',

            // --- VALIDASI DOKUMEN ---

            // 1. Validasi Child Documents
            'child_documents' => [
                // Wajib diisi JIKA dokumen dipilih DAN dokumen_id kosong
                $isDocumentSelected ? 'required_without:dokumen_id' : 'nullable',
                'array',
                'exists:document_childrens,id'
            ],

            // 2. Validasi Dokumen Induk (Gabungan Logic)
            'dokumen_id' => [
                // Wajib diisi JIKA dokumen dipilih DAN child_documents kosong
                $isDocumentSelected ? 'required_without:child_documents' : 'nullable',
                'array',

                // Custom Rule: Cek apakah Induk yang dipilih mewajibkan anak
                function ($attribute, $value, $fail) use ($request) {
                    // $value adalah array ID dokumen induk (bisa null/kosong)
                    if (empty($value) || !is_array($value))
                        return;

                    // Ambil dokumen induk yang dipilih user, tapi HANYA yang punya 'childrens'
                    // Pastikan namespace Document sesuai model Anda (misal: \App\Models\Document)
                    $parentsWithChildren = Document::whereIn('id', $value)
                        ->has('childrens')
                        ->with('childrens')
                        ->get();

                    // Ambil daftar ID anak yang dipilih user dari form
                    $selectedChildIds = $request->input('child_documents', []);

                    // Loop setiap Dokumen Induk yang punya anak
                    foreach ($parentsWithChildren as $parent) {
                        // Ambil semua ID anak yang valid milik induk ini
                        $validChildIds = $parent->childrens->pluck('id')->toArray();

                        // Cek irisan: Apakah ada ID anak yang dipilih user yang cocok dengan induk ini?
                        $hasSelectedChild = !empty(array_intersect($selectedChildIds, $validChildIds));

                        // Jika user memilih Induk (yang punya anak), tapi TIDAK memilih satu pun anaknya:
                        if (!$hasSelectedChild) {
                            $fail("Dokumen '{$parent->name}' memiliki opsi turunan (seperti Visa Ziarah/Umrah). Anda wajib memilih minimal satu sub-jenis dokumen tersebut.");
                        }
                    }
                },
            ],

            // ====================================================
            // D. VALIDASI HANDLING (BARU)
            // ====================================================

            // 1. Pastikan sub-jenis handling dipilih (Hotel / Bandara)
            'handlings' => $isHandlingSelected ? 'required|array|min:1' : 'nullable',

            // 2. Validasi Handling Hotel
            'nama_hotel_handling' => $isHandlingHotelSelected ? 'required|string|max:255' : 'nullable',
            'tanggal_hotel_handling' => $isHandlingHotelSelected ? 'required|date' : 'nullable',
            'harga_hotel_handling' => $isHandlingHotelSelected ? 'required|numeric|min:0' : 'nullable',
            'pax_hotel_handling' => $isHandlingHotelSelected ? 'required|integer|min:1' : 'nullable',

            // 3. Validasi Handling Bandara
            'nama_bandara_handling' => $isHandlingBandaraSelected ? 'required|string|max:255' : 'nullable',
            'jumlah_jamaah_handling' => $isHandlingBandaraSelected ? 'required|integer|min:1' : 'nullable',
            'harga_bandara_handling' => $isHandlingBandaraSelected ? 'required|numeric|min:0' : 'nullable',
            'kedatangan_jamaah_handling' => $isHandlingBandaraSelected ? 'required|date' : 'nullable',
            'nama_supir' => $isHandlingBandaraSelected ? 'required|string|max:255' : 'nullable',

            // ====================================================
            // E. VALIDASI PENDAMPING (BARU)
            // ====================================================

            // 1. Pastikan ada minimal satu pendamping yang dipilih (jumlah > 0)
            'jumlah_pendamping' => [
                $isPendampingSelected ? 'required' : 'nullable',
                'array',
                function ($attribute, $value, $fail) use ($isPendampingSelected) {
                    if (!$isPendampingSelected)
                        return;

                    // Cek apakah ada setidaknya satu item dengan jumlah > 0
                    $hasSelection = false;
                    foreach ($value as $qty) {
                        if ((int) $qty > 0) {
                            $hasSelection = true;
                            break;
                        }
                    }

                    if (!$hasSelection) {
                        $fail('Anda memilih layanan Pendamping, wajib mengisi jumlah minimal untuk satu pendamping.');
                    }
                },
            ],

            // 2. Validasi Tanggal untuk setiap Pendamping yang dipilih
            'tanggal_pendamping' => [
                $isPendampingSelected ? 'required' : 'nullable',
                'array',
                function ($attribute, $dates, $fail) use ($request, $isPendampingSelected) {
                    if (!$isPendampingSelected)
                        return;

                    $jumlahs = $request->input('jumlah_pendamping', []);

                    foreach ($jumlahs as $guideId => $qty) {
                        if ((int) $qty > 0) {
                            // Jika pendamping ID ini dipilih (qty > 0), wajib punya tanggal valid
                            $start = $dates[$guideId]['dari'] ?? null;
                            $end = $dates[$guideId]['sampai'] ?? null;

                            if (empty($start) || empty($end)) {
                                $guide = GuideItems::find($guideId);
                                $name = $guide ? $guide->nama : 'Pendamping';
                                $fail("Tanggal 'Dari' dan 'Sampai' wajib diisi untuk $name.");
                            }
                        }
                    }
                }
            ],

            // ====================================================
            // F. VALIDASI KONTEN
            // ====================================================

            // 1. Pastikan minimal ada satu konten yang jumlahnya > 0
            'jumlah_konten' => [
                $isKontenSelected ? 'required' : 'nullable',
                'array',
                function ($attribute, $value, $fail) use ($isKontenSelected) {
                    if (!$isKontenSelected)
                        return;

                    $hasSelection = false;
                    foreach ($value as $qty) {
                        if ((int) $qty > 0) {
                            $hasSelection = true;
                            break;
                        }
                    }
                    if (!$hasSelection) {
                        $fail('Anda memilih layanan Konten, wajib mengisi jumlah minimal untuk satu item konten.');
                    }
                },
            ],

            // 2. Validasi Tanggal Pelaksanaan untuk setiap Konten yang dipilih
            'tanggal_konten' => [
                $isKontenSelected ? 'required' : 'nullable',
                'array',
                function ($attribute, $dates, $fail) use ($request, $isKontenSelected) {
                    if (!$isKontenSelected)
                        return;

                    $jumlahs = $request->input('jumlah_konten', []);

                    foreach ($jumlahs as $contentId => $qty) {
                        if ((int) $qty > 0) {
                            $date = $dates[$contentId] ?? null;

                            if (empty($date)) {
                                $content = ContentItem::find($contentId);
                                $name = $content ? $content->name : 'Konten';
                                $fail("Tanggal pelaksanaan wajib diisi untuk $name.");
                            }
                        }
                    }
                }
            ],

            // ====================================================
            // G. VALIDASI REYAL (BARU)
            // ====================================================

            // 1. Validasi Umum Reyal
            'tipe' => $isReyalSelected ? 'required|in:tamis,tumis' : 'nullable',
            'tanggal_penyerahan' => $isReyalSelected ? 'required|date' : 'nullable',

            // 2. Validasi Jika Tipe = TAMIS (Rupiah -> Reyal)
            'jumlah_rupiah' => ($isReyalSelected && $reyalType === 'tamis') ? 'required|numeric|min:1' : 'nullable',
            'kurs_tamis' => ($isReyalSelected && $reyalType === 'tamis') ? 'required|numeric|min:1' : 'nullable',

            // 3. Validasi Jika Tipe = TUMIS (Reyal -> Rupiah)
            'jumlah_reyal' => ($isReyalSelected && $reyalType === 'tumis') ? 'required|numeric|min:1' : 'nullable',
            'kurs_tumis' => ($isReyalSelected && $reyalType === 'tumis') ? 'required|numeric|min:1' : 'nullable',

            // ====================================================
            // H. VALIDASI TOUR (BARU)
            // ====================================================

            // 1. Wajib pilih minimal 1 lokasi tour
            'tour_ids' => $isTourSelected ? 'required|array|min:1' : 'nullable',

            // 2. Validasi Tanggal Tour untuk setiap lokasi yang dipilih
            'tanggal_tour' => [
                $isTourSelected ? 'required' : 'nullable',
                'array',
                function ($attribute, $dates, $fail) use ($request, $isTourSelected) {
                    if (!$isTourSelected)
                        return;

                    $selectedTours = $request->input('tour_ids', []);
                    foreach ($selectedTours as $tourId) {
                        if (empty($dates[$tourId])) {
                            $tour = TourItem::find($tourId);
                            $name = $tour ? $tour->name : 'Tour';
                            $fail("Tanggal pelaksanaan wajib diisi untuk tour: $name.");
                        }
                    }
                }
            ],

            // ====================================================
            // I. VALIDASI MEALS (BARU)
            // ====================================================

            // 1. Wajib isi minimal 1 item dengan jumlah > 0
            'jumlah_meals' => [
                $isMealSelected ? 'required' : 'nullable',
                'array',
                function ($attribute, $value, $fail) use ($isMealSelected) {
                    if (!$isMealSelected)
                        return;
                    $hasSelection = false;
                    foreach ($value as $qty) {
                        if ((int) $qty > 0) {
                            $hasSelection = true;
                            break;
                        }
                    }
                    if (!$hasSelection) {
                        $fail('Anda memilih layanan Meals, wajib mengisi jumlah minimal untuk satu menu.');
                    }
                },
            ],

            // 2. Validasi Tanggal (Dari & Sampai) untuk meals yang dipilih
            'dari_tanggal_makanan' => [
                $isMealSelected ? 'required' : 'nullable',
                'array',
                function ($attribute, $dates, $fail) use ($request, $isMealSelected) {
                    if (!$isMealSelected)
                        return;
                    $jumlahs = $request->input('jumlah_meals', []);

                    foreach ($jumlahs as $id => $qty) {
                        if ((int) $qty > 0) {
                            $start = $dates[$id]['dari'] ?? null;
                            // Cek pasangannya di array 'sampai_tanggal_makanan'
                            $endArray = $request->input('sampai_tanggal_makanan', []);
                            $end = $endArray[$id]['sampai'] ?? null;

                            if (empty($start) || empty($end)) {
                                $meal = MealItem::find($id);
                                $name = $meal ? $meal->name : 'Menu';
                                $fail("Tanggal 'Dari' dan 'Sampai' wajib diisi untuk $name.");
                            }
                        }
                    }
                }
            ],

            // ====================================================
            // J. VALIDASI DORONGAN (BARU)
            // ====================================================

            // 1. Wajib isi minimal 1 item dengan jumlah > 0
            'jumlah_dorongan' => [
                $isDoronganSelected ? 'required' : 'nullable',
                'array',
                function ($attribute, $value, $fail) use ($isDoronganSelected) {
                    if (!$isDoronganSelected)
                        return;
                    $hasSelection = false;
                    foreach ($value as $qty) {
                        if ((int) $qty > 0) {
                            $hasSelection = true;
                            break;
                        }
                    }
                    if (!$hasSelection) {
                        $fail('Anda memilih layanan Dorongan, wajib mengisi jumlah minimal untuk satu item.');
                    }
                },
            ],

            // 2. Validasi Tanggal Pelaksanaan untuk dorongan yang dipilih
            'tanggal_dorongan' => [
                $isDoronganSelected ? 'required' : 'nullable',
                'array',
                function ($attribute, $dates, $fail) use ($request, $isDoronganSelected) {
                    if (!$isDoronganSelected)
                        return;
                    $jumlahs = $request->input('jumlah_dorongan', []);
                    foreach ($jumlahs as $id => $qty) {
                        if ((int) $qty > 0) {
                            if (empty($dates[$id])) {
                                $item = Dorongan::find($id);
                                $name = $item ? $item->name : 'Dorongan';
                                $fail("Tanggal pelaksanaan wajib diisi untuk $name.");
                            }
                        }
                    }
                }
            ],

        ], [
            // Custmom Error Messages
            // Transport
            'transportation.required' => 'Anda memilih layanan Transportasi, wajib memilih minimal salah satu sub-layanan (Pesawat atau Transportasi Darat).',
            'transportation.min' => 'Anda memilih layanan Transportasi, wajib memilih minimal salah satu sub-layanan (Pesawat atau Transportasi Darat).',
            'transportation_id.required' => 'Anda memilih Transportasi Darat, tapi belum menambahkan satu pun item transportasi.',
            'transportation_id.min' => 'Anda memilih Transportasi Darat, tapi belum menambahkan satu pun item transportasi.',
            'rute_id.required' => 'Rute wajib dipilih untuk setiap transportasi darat.',
            'rute_id.min' => 'Rute wajib dipilih untuk setiap transportasi darat.',
            'rute_id.*.required' => 'Rute wajib dipilih untuk setiap transportasi darat.',
            'tanggal_transport.required' => 'Tanggal transportasi darat wajib diisi.',
            'tanggal_transport.min' => 'Tanggal transportasi darat wajib diisi.',
            'tanggal_transport.*.dari.required' => 'Tanggal "Dari" wajib diisi untuk setiap transportasi darat.',
            'tanggal_transport.*.sampai.required' => 'Tanggal "Sampai" wajib diisi untuk setiap transportasi darat.',
            'tanggal_transport.*.sampai.after_or_equal' => 'Tanggal "Sampai" harus sama atau setelah Tanggal "Dari".',
            'rute.required' => 'Anda memilih Tiket Pesawat, tapi belum menambahkan satu pun rute penerbangan.',
            'rute.min' => 'Anda memilih Tiket Pesawat, tapi belum menambahkan satu pun rute penerbangan.',
            'tanggal.required' => 'Tanggal keberangkatan wajib diisi untuk setiap penerbangan.',
            'tanggal.min' => 'Tanggal keberangkatan wajib diisi untuk setiap penerbangan.',
            'rute.*.required' => 'Rute (contoh: JKT-JED) wajib diisi untuk setiap penerbangan.',
            'tanggal.*.required' => 'Tanggal keberangkatan wajib diisi untuk setiap penerbangan.',
            'maskapai.*.required' => 'Nama maskapai wajib diisi untuk setiap penerbangan.',
            'harga_tiket.*.required' => 'Harga tiket wajib diisi untuk setiap penerbangan.',
            'jumlah.*.required' => 'Jumlah jamaah wajib diisi untuk setiap penerbangan.',
            'jumlah.*.min' => 'Jumlah jamaah harus minimal 1.',

            // Hotel
            'nama_hotel.required' => 'Anda memilih layanan Hotel, wajib mengisi data minimal satu hotel.',
            'nama_hotel.*.required' => 'Nama hotel wajib diisi.',
            'nama_hotel.*.filled' => 'Nama hotel tidak boleh kosong.',
            'tanggal_checkin.*.required' => 'Tanggal Check-in wajib diisi.',
            'tanggal_checkout.*.required' => 'Tanggal Check-out wajib diisi.',
            'tanggal_checkout.*.after' => 'Tanggal Check-out harus setelah tanggal Check-in.',
            'jumlah_kamar.*.required' => 'Total jumlah kamar wajib diisi.',
            'jumlah_kamar.*.min' => 'Total jumlah kamar minimal 1.',
            'jumlah_kamar.*.integer' => 'Total jumlah kamar harus berupa angka.',

            'hotel_data.*.*.jumlah.required' => 'Jumlah kamar untuk tipe yang dipilih wajib diisi.',
            'hotel_data.*.*.jumlah.min' => 'Jumlah kamar untuk tipe yang dipilih minimal 1.',

            // Dokumen
            'dokumen_id.required_without' => 'Anda memilih layanan Dokumen, wajib memilih minimal satu jenis dokumen (Induk atau Turunan).',
            'child_documents.required_without' => 'Anda memilih layanan Dokumen, wajib memilih minimal satu jenis dokumen (Induk atau Turunan).',

            // Handling
            'handlings.required' => 'Anda memilih layanan Handling, wajib memilih jenis handling (Hotel atau Bandara).',

            'nama_hotel_handling.required' => 'Nama hotel (Handling) wajib diisi.',
            'tanggal_hotel_handling.required' => 'Tanggal hotel (Handling) wajib diisi.',
            'harga_hotel_handling.required' => 'Harga hotel (Handling) wajib diisi.',
            'pax_hotel_handling.required' => 'Jumlah Pax hotel (Handling) wajib diisi.',

            'nama_bandara_handling.required' => 'Nama bandara wajib diisi.',
            'jumlah_jamaah_handling.required' => 'Jumlah jamaah (Bandara) wajib diisi.',
            'harga_bandara_handling.required' => 'Harga handling bandara wajib diisi.',
            'kedatangan_jamaah_handling.required' => 'Tanggal kedatangan jamaah wajib diisi.',
            'nama_supir.required' => 'Nama supir wajib diisi.',

            // Pendamping
            'jumlah_pendamping.required' => 'Data pendamping wajib diisi.',

            // Konten
            'jumlah_konten.required' => 'Data konten wajib diisi.',

            // Reyal
            'tipe.required' => 'Tipe penukaran (Tamis/Tumis) wajib dipilih.',
            'tipe.in' => 'Tipe penukaran tidak valid.',
            'tanggal_penyerahan.required' => 'Tanggal penyerahan uang wajib diisi.',

            'jumlah_rupiah.required' => 'Jumlah Rupiah wajib diisi untuk transaksi Tamis.',
            'kurs_tamis.required' => 'Kurs Tamis wajib diisi.',

            'jumlah_reyal.required' => 'Jumlah Reyal wajib diisi untuk transaksi Tumis.',
            'kurs_tumis.required' => 'Kurs Tumis wajib diisi.',

            // Tour
            'tour_ids.required' => 'Mohon pilih minimal satu lokasi tour.',

            // Meals
            'jumlah_meals.required' => 'Data meals wajib diisi.',

            // Dorongan
            'jumlah_dorongan.required' => 'Data dorongan wajib diisi.',
        ]);

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
                        $subTotalDarat = (($hargaPerHari * $jumlahHari) + $hargaRute);

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
                'invoice' => 'INV-' . time(),
                'total_estimasi' => $serverTotalAmount,     // Simpan hasil hitung ke estimasi
                'total_amount_final' => null,             // Harga final masih KOSONG
                'total_yang_dibayarkan' => 0,
                'sisa_hutang' => $serverTotalAmount,      // Sisa hutang = estimasi awal
                'status_pembayaran' => 'belum_bayar',
                'status_harga' => 'provisional'
            ]);
            DB::commit();

            return redirect()->route('admin.services.show', $service)->with('success', 'Data service berhasil disimpan.');
        } catch (\Exception $e) {
            DB::rollBack();

            return redirect()->back()
                ->withInput()
                ->withErrors(['msg' => 'Terjadi kesalahan saat menyimpan data: ' . $e->getMessage()]);
        }
    }

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
            'exchanges', // Asumsi nama relasi exchanges()

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
    // private function handleReyalItems(Request $request, Service $service)
    // {
    //     $tipe = $request->input('tipe');
    //     $tanggalPenyerahan = $request->input('tanggal_penyerahan');
    //     if ($tanggalPenyerahan) {
    //         if ($tipe === 'tamis') {
    //             $service->exchanges()->create([
    //                 'tipe' => 'tamis',
    //                 'jumlah_input' => $request->input('jumlah_rupiah'),
    //                 'kurs' => $request->input('kurs_tamis'),
    //                 'hasil' => $request->input('hasil_tamis'),
    //                 'tanggal_penyerahan' => $tanggalPenyerahan,
    //             ]);
    //         }

    //         if ($tipe === 'tumis') {
    //             $service->exchanges()->create([
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
