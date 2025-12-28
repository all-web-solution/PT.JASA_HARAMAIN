<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\ContentCustomer;
use App\Models\CustomerDocument;
use App\Models\Guide;
use App\Models\HandlingHotel;
use App\Models\HandlingPlanes;
use App\Models\Hotel;
use App\Models\Plane;
use App\Models\TransportationItem;
use App\Models\Meal;
use App\Models\Tour;
use App\Models\Badal;
use App\Models\WakafCustomer;
use App\Models\DoronganOrder;
use App\Models\Exchange;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Carbon;

class AgendaController extends Controller
{
    public function index()
    {
        return view('agenda.index');
    }

    /**
     * Main function to aggregate all events
     */
    public function getEvents(Request $request)
    {
        $user = Auth::user();
        $events = [];

        $events = array_merge(
            $events,
            $this->getTransportationEvents($user),
            $this->getHotelEvents($user),
            $this->getDocumentEvents($user),
            $this->getHandlingEvents($user),
            $this->getGuideEvents($user),
            $this->getContentEvents($user),
            $this->getMealEvents($user),
            $this->getTourEvents($user),
            $this->getBadalEvents($user),
            $this->getWakafEvents($user),
            $this->getDoronganEvents($user),
            $this->getExchangeEvents($user)
        );

        return response()->json($events);
    }

    // =========================================================================
    // PRIVATE METHODS (MODULAR LOGIC)
    // =========================================================================

    /**
     * 1. TRANSPORTATION & TICKET DIVISION
     */
    private function getTransportationEvents($user): array
    {
        if (!in_array($user->role, ['admin', 'transportasi & tiket'])) {
            return [];
        }

        $events = [];

        // A. TIKET PESAWAT
        $planes = Plane::with('service.pelanggan')->get();
        foreach ($planes as $item) {
            if ($item->tanggal_keberangkatan) {
                $pelanggan = $item->service->pelanggan->nama_travel ?? 'N/A';

                $desc = "✈️ DETAIL TIKET PESAWAT\n-------------------\n";
                $desc .= "Maskapai: " . ($item->maskapai ?? '-') . "\n";
                $desc .= "Rute: " . ($item->rute ?? '-') . "\n";
                $desc .= "Tanggal: " . $item->tanggal_keberangkatan . "\n";
                $desc .= "Customer: $pelanggan\n";
                $desc .= "Supplier: " . ($item->supplier ?? '-') . "\n";
                $desc .= "Status: " . ($item->status ?? '-') . "\n";
                $desc .= "Ket: " . ($item->keterangan ?? '-') . "\n";

                $events[] = [
                    'title' => "✈️ " . ($item->maskapai ?? 'Pesawat') . " ({$item->rute})",
                    'start' => $item->tanggal_keberangkatan,
                    'allDay' => true,
                    'color' => '#0dcaf0',
                    'textColor' => '#000',
                    'extendedProps' => ['description' => $desc]
                ];
            }
        }

        // B. TRANSPORT DARAT
        $landTransports = TransportationItem::with(['service.pelanggan', 'transportation', 'route'])->get();
        foreach ($landTransports as $item) {
            if ($item->dari_tanggal) {
                $pelanggan = $item->service->pelanggan->nama_travel ?? 'N/A';
                $kendaraan = $item->transportation->nama ?? 'Bus';
                $ruteInfo = $item->route->route ?? '-';

                $desc = "🚌 DETAIL TRANSPORT DARAT\n-------------------\n";
                $desc .= "Kendaraan: $kendaraan\n";
                $desc .= "Customer: $pelanggan\n";
                $desc .= "Rute: $ruteInfo\n";
                $desc .= "Periode: " . ($item->dari_tanggal ?? '-') . " s/d " . ($item->sampai_tanggal ?? '-') . "\n";
                $desc .= "Supplier: " . ($item->supplier ?? '-') . "\n";
                $desc .= "Status: " . ($item->status ?? '-') . "\n";

                $events[] = [
                    'title' => "▶️ START: {$kendaraan} ({$pelanggan})",
                    'start' => $item->dari_tanggal,
                    'allDay' => true,
                    'color' => '#198754',
                    'extendedProps' => ['description' => $desc]
                ];

                if ($item->sampai_tanggal) {
                    $events[] = [
                        'title' => "⏹️ END: {$kendaraan} ({$pelanggan})",
                        'start' => $item->sampai_tanggal,
                        'allDay' => true,
                        'color' => '#6c757d',
                        'extendedProps' => ['description' => $desc]
                    ];
                }
            }
        }

        return $events;
    }

    /**
     * 2. HOTEL DIVISION
     */
    private function getHotelEvents($user): array
    {
        if (!in_array($user->role, ['admin', 'hotel'])) {
            return [];
        }

        $events = [];
        $hotels = Hotel::with('service.pelanggan')->get();

        foreach ($hotels as $item) {
            if ($item->tanggal_checkin && $item->tanggal_checkout) {
                $pelanggan = $item->service->pelanggan->nama_travel ?? 'N/A';
                $hotelName = $item->nama_hotel ?? 'Hotel';

                $checkin = Carbon::parse($item->tanggal_checkin);
                $checkout = Carbon::parse($item->tanggal_checkout);

                $diffInDays = $checkin->diffInDays($checkout);

                for ($i = 0; $i <= $diffInDays; $i++) {
                    $currentDate = $checkin->copy()->addDays($i);
                    $dayNumber = $i + 1;

                    if ($i == 0) {
                        $statusTitle = "⬇️ H{$dayNumber}: IN";
                        $bgColor = '#0d6efd';
                        $statusDesc = "Check-in Hari ke-{$dayNumber}";
                    } elseif ($i == $diffInDays) {
                        $statusTitle = "⬆️ H{$dayNumber}: OUT";
                        $bgColor = '#dc3545';
                        $statusDesc = "Check-out Hari ke-{$dayNumber}";
                    } else {
                        $statusTitle = "🛏️ H{$dayNumber}: STAY";
                        $bgColor = '#6ea8fe';
                        $statusDesc = "Menginap Hari ke-{$dayNumber}";
                    }

                    $desc = "🏨 DETAIL HOTEL (H{$dayNumber})\n-------------------\n";
                    $desc .= "Status: $statusDesc\n";
                    $desc .= "Hotel: $hotelName\n";
                    $desc .= "Customer: $pelanggan\n";
                    $desc .= "Tanggal Ini: " . $currentDate->format('d M Y') . "\n";
                    $desc .= "-------------------\n";
                    $desc .= "Periode Full: " . $checkin->format('d M') . " - " . $checkout->format('d M Y') . "\n";
                    $desc .= "Tipe Kamar: " . ($item->type ?? '-') . "\n";
                    $desc .= "Total Kamar: " . ($item->jumlah_kamar ?? '-') . "\n";
                    $desc .= "Catatan: " . ($item->catatan ?? '-') . "\n";

                    $events[] = [
                        'title' => "{$statusTitle} - {$hotelName}",
                        'start' => $currentDate->format('Y-m-d'),
                        'allDay' => true,
                        'color' => $bgColor,
                        'textColor' => '#ffffff',
                        'extendedProps' => ['description' => $desc]
                    ];
                }

            } elseif ($item->tanggal_checkin) {
                $checkin = Carbon::parse($item->tanggal_checkin);
                $pelanggan = $item->service->pelanggan->nama_travel ?? 'N/A';
                $hotelName = $item->nama_hotel ?? 'Hotel';

                $desc = "🏨 DETAIL HOTEL\n-------------------\n";
                $desc .= "Hotel: $hotelName\n";
                $desc .= "Check-in: " . $checkin->format('d M Y') . "\n";
                $desc .= "Status: Check-in Only (Belum ada Checkout)\n";

                $events[] = [
                    'title' => "⬇️ IN: {$hotelName} ({$pelanggan})",
                    'start' => $checkin->format('Y-m-d'),
                    'allDay' => true,
                    'backgroundColor' => '#0d6efd',
                    'extendedProps' => ['description' => $desc]
                ];
            }
        }

        return $events;
    }

    /**
     * 3. DOCUMENT DIVISION
     */
    private function getDocumentEvents($user): array
    {
        if (!in_array($user->role, ['admin', 'visa dan acara'])) {
            return [];
        }

        $events = [];
        $rawDocs = CustomerDocument::with(['service.pelanggan', 'document', 'documentChild'])->get();

        // Grouping
        $groupedDocs = $rawDocs->groupBy(function ($item) {
            return $item->service_id . '_' . $item->document_id . '_' . $item->created_at->format('Y-m-d');
        });

        foreach ($groupedDocs as $group) {
            $firstItem = $group->first();
            if (!$firstItem->created_at)
                continue;

            $pelanggan = $firstItem->service->pelanggan->nama_travel ?? 'N/A';
            $jenisDokumen = $firstItem->document->name ?? 'Dokumen';
            $totalPax = $group->sum('jumlah');

            $desc = "📄 DETAIL DOKUMEN\n-------------------\n";
            $desc .= "Jenis: $jenisDokumen\n";
            $desc .= "Customer: $pelanggan\n";
            $desc .= "Total: $totalPax Pax\n";
            $desc .= "Tgl Request: " . $firstItem->created_at->format('d M Y') . "\n";
            $desc .= "Status: " . ($firstItem->status ?? '-') . "\n";
            $desc .= "-------------------\nRincian Item:\n";

            foreach ($group as $detail) {
                $itemName = $detail->documentChild->name ?? $detail->document->name ?? '-';
                $itemPax = $detail->jumlah ?? 0;
                $desc .= "• $itemName: $itemPax Pax\n";
            }

            // Tentukan Warna
            $color = '#6c757d';
            if (stripos($jenisDokumen, 'Visa') !== false)
                $color = '#fd7e14';
            elseif (stripos($jenisDokumen, 'Sisko') !== false)
                $color = '#20c997';
            elseif (stripos($jenisDokumen, 'Vaksin') !== false)
                $color = '#6f42c1';

            $events[] = [
                'title' => "📄 {$jenisDokumen}: {$totalPax} Pax ({$pelanggan})",
                'start' => $firstItem->created_at->format('Y-m-d'),
                'allDay' => true,
                'color' => $color,
                'extendedProps' => ['description' => $desc]
            ];
        }

        return $events;
    }

    /**
     * 4. HANDLING DIVISION (Hotel & Planes)
     */
    private function getHandlingEvents($user): array
    {
        if (!in_array($user->role, ['admin', 'handling'])) {
            return [];
        }

        $events = [];

        // A. HANDLING HOTEL
        $handlingHotels = HandlingHotel::with(['handling.service.pelanggan'])->get();
        foreach ($handlingHotels as $item) {
            if ($item->tanggal) {
                $pelanggan = $item->handling->service->pelanggan->nama_travel ?? 'N/A';
                $hotelName = $item->nama_hotel ?? 'Handling Hotel';

                $kodeBookingDisplay = '-';
                if (!empty($item->kode_booking)) {
                    $fileUrl = asset('storage/' . $item->kode_booking);
                    $kodeBookingDisplay = "<a href='{$fileUrl}' target='_blank' class='text-primary text-decoration-underline'>Lihat File</a>";
                }

                $desc = "🏨 DETAIL HANDLING HOTEL\n-------------------\n";
                $desc .= "Hotel: $hotelName\n";
                $desc .= "Tanggal: " . date('d M Y', strtotime($item->tanggal)) . "\n";
                $desc .= "Customer: $pelanggan\n";
                $desc .= "Pax: " . ($item->pax ?? '-') . "\n";
                $desc .= "Kode Booking: $kodeBookingDisplay\n";

                $desc .= "Status: " . ($item->status ?? '-') . "\n";
                $desc .= "Ket: " . ($item->keterangan ?? '-') . "\n";

                $events[] = [
                    'title' => "🏨 H-Hotel: {$hotelName} ({$pelanggan})",
                    'start' => $item->tanggal,
                    'allDay' => true,
                    'color' => '#ffc107',
                    'textColor' => '#000',
                    'extendedProps' => ['description' => $desc]
                ];
            }
        }

        $handlingPlanes = HandlingPlanes::with(['handling.service.pelanggan'])->get();
        foreach ($handlingPlanes as $item) {
            if ($item->kedatangan_jamaah) {
                $pelanggan = $item->handling->service->pelanggan->nama_travel ?? 'N/A';
                $bandara = $item->nama_bandara ?? 'Bandara';
                $supir = $item->nama_supir ?? '-';
                $tglKedatangan = Carbon::parse($item->kedatangan_jamaah);

                $desc = "✈️ DETAIL HANDLING BANDARA\n-------------------\n";
                $desc .= "Bandara: $bandara\n";
                $desc .= "Kedatangan: " . $tglKedatangan->format('d M Y') . "\n";
                $desc .= "Customer: $pelanggan\n";
                $desc .= "Jamaah: " . ($item->jumlah_jamaah ?? '-') . " Pax\n";
                $desc .= "Sopir: " . $supir . "\n";
                $desc .= "Status: " . ($item->status ?? '-') . "\n";

                $events[] = [
                    'title' => "🛬 H-Bandara: {$bandara} ({$pelanggan})",
                    'start' => $tglKedatangan->format('Y-m-d'),
                    'allDay' => true,
                    'color' => '#fd7e14',
                    'textColor' => '#fff',
                    'extendedProps' => ['description' => $desc]
                ];
            }
        }

        return $events;
    }

    /**
     * 5. GUIDE / MUTHAWIF DIVISION
     */
    private function getGuideEvents($user): array
    {
        if (!in_array($user->role, ['admin', 'handling'])) {
            return [];
        }

        $events = [];
        $guides = Guide::with(['service.pelanggan', 'guideItem'])->get();

        foreach ($guides as $item) {
            if ($item->muthowif_dari) {
                $pelanggan = $item->service->pelanggan->nama_travel ?? 'N/A';
                $namaPendamping = $item->guideItem->nama ?? 'Muthawif';

                $desc = "👳 DETAIL PENDAMPING (MUTHAWIF)\n-------------------\n";
                $desc .= "Nama: $namaPendamping\n";
                $desc .= "Customer: $pelanggan\n";
                $desc .= "Periode: " . date('d M Y', strtotime($item->muthowif_dari));
                if ($item->muthowif_sampai) {
                    $desc .= " s/d " . date('d M Y', strtotime($item->muthowif_sampai));
                }
                $desc .= "\n";
                $desc .= "Jumlah: " . ($item->jumlah ?? '-') . "\n";
                $desc .= "Supplier: " . ($item->supplier ?? '-') . "\n";
                $desc .= "Status: " . ($item->status ?? '-') . "\n";
                $desc .= "Ket: " . ($item->keterangan ?? '-') . "\n";

                $events[] = [
                    'title' => "▶️ START: 👳 {$namaPendamping} ({$pelanggan})",
                    'start' => $item->muthowif_dari,
                    'allDay' => true,
                    'color' => '#6610f2',
                    'extendedProps' => ['description' => $desc]
                ];

                if ($item->muthowif_sampai) {
                    $events[] = [
                        'title' => "⏹️ END: 👳 {$namaPendamping}",
                        'start' => $item->muthowif_sampai,
                        'allDay' => true,
                        'color' => '#6c757d',
                        'extendedProps' => ['description' => $desc]
                    ];
                }
            }
        }

        return $events;
    }

    /**
     * 6. CONTENT & DOCUMENTATION DIVISION
     */
    private function getContentEvents($user): array
    {
        if (!in_array($user->role, ['admin', 'konten dan dokumentasi'])) {
            return [];
        }

        $events = [];
        $contents = ContentCustomer::with(['service.pelanggan', 'content'])->get();

        foreach ($contents as $item) {
            if ($item->tanggal_pelaksanaan) {
                $pelanggan = $item->service->pelanggan->nama_travel ?? 'N/A';
                $namaKonten = $item->content->name ?? 'Dokumentasi';

                $desc = "📸 DETAIL KONTEN & DOKUMENTASI\n-------------------\n";
                $desc .= "Paket: $namaKonten\n";
                $desc .= "Customer: $pelanggan\n";
                $desc .= "Tanggal: " . date('d M Y', strtotime($item->tanggal_pelaksanaan)) . "\n";
                $desc .= "Jumlah: " . ($item->jumlah ?? '-') . "\n";
                $desc .= "Supplier: " . ($item->supplier ?? '-') . "\n";
                $desc .= "Status: " . ($item->status ?? '-') . "\n";
                $desc .= "Ket: " . ($item->keterangan ?? '-') . "\n";

                $events[] = [
                    'title' => "📸 {$namaKonten} ({$pelanggan})",
                    'start' => $item->tanggal_pelaksanaan,
                    'allDay' => true,
                    'color' => '#17a2b8',
                    'textColor' => '#fff',
                    'extendedProps' => ['description' => $desc]
                ];
            }
        }

        return $events;
    }

    /**
     * 7. CATERING / MEALS DIVISION
     */
    private function getMealEvents($user): array
    {
        // Sesuaikan role dengan database Anda, misal 'konsumsi' atau 'catering'
        if (!in_array($user->role, ['admin', 'handling'])) {
            return [];
        }

        $events = [];
        $meals = Meal::with(['service.pelanggan', 'mealItem'])->get();

        foreach ($meals as $item) {
            if ($item->dari_tanggal) {
                $pelanggan = $item->service->pelanggan->nama_travel ?? 'N/A';
                $menu = $item->mealItem->name ?? 'Menu Catering';

                $desc = "🍱 DETAIL CATERING (MEALS)\n-------------------\n";
                $desc .= "Menu: $menu\n";
                $desc .= "Customer: $pelanggan\n";
                $desc .= "Periode: " . date('d M', strtotime($item->dari_tanggal));
                if ($item->sampai_tanggal) {
                    $desc .= " s/d " . date('d M', strtotime($item->sampai_tanggal));
                }
                $desc .= "\n";
                $desc .= "Jumlah: " . ($item->jumlah ?? '-') . " Pax\n";
                $desc .= "Supplier: " . ($item->supplier ?? '-') . "\n";
                $desc .= "Status: " . ($item->status ?? '-') . "\n";

                // Event Start
                $events[] = [
                    'title' => "🍱 START: {$menu} ({$pelanggan})",
                    'start' => $item->dari_tanggal,
                    'allDay' => true,
                    'color' => '#d63384', // Pink
                    'textColor' => '#fff',
                    'extendedProps' => ['description' => $desc]
                ];

                // Event End (Jika tanggal beda)
                if ($item->sampai_tanggal && $item->sampai_tanggal != $item->dari_tanggal) {
                    $events[] = [
                        'title' => "🍱 END: {$menu}",
                        'start' => $item->sampai_tanggal,
                        'allDay' => true,
                        'color' => '#e6a4c4', // Pink Soft
                        'textColor' => '#000',
                        'extendedProps' => ['description' => $desc]
                    ];
                }
            }
        }

        return $events;
    }

    /**
     * 8. TOUR DIVISION
     */
    private function getTourEvents($user): array
    {
        if (!in_array($user->role, ['admin', 'handling'])) {
            return [];
        }

        $events = [];
        $tours = Tour::with(['service.pelanggan', 'tourItem', 'transportation'])->get();

        foreach ($tours as $item) {
            if ($item->tanggal_keberangkatan) {
                $pelanggan = $item->service->pelanggan->nama_travel ?? 'N/A';
                $destinasi = $item->tourItem->name ?? 'City Tour';
                $transport = $item->transportation->nama ?? '-';
                $supplier = $item->supplier ?? '-';

                $desc = "🗺️ DETAIL PAKET TOUR\n-------------------\n";
                $desc .= "Destinasi: $destinasi\n";
                $desc .= "Tanggal: " . date('d M Y', strtotime($item->tanggal_keberangkatan)) . "\n";
                $desc .= "Customer: $pelanggan\n";
                $desc .= "Transport: $transport\n";
                $desc .= "Supplier: $supplier\n";
                $desc .= "Status: " . ($item->status ?? '-') . "\n";

                $events[] = [
                    'title' => "🗺️ Tour: {$destinasi} ({$pelanggan})",
                    'start' => $item->tanggal_keberangkatan,
                    'allDay' => true,
                    'color' => '#20c997', // Teal
                    'textColor' => '#fff',
                    'extendedProps' => ['description' => $desc]
                ];
            }
        }

        return $events;
    }

    /**
     * 9. BADAL UMRAH DIVISION
     */
    private function getBadalEvents($user): array
    {
        if (!in_array($user->role, ['admin', 'palugada'])) {
            return [];
        }

        $events = [];
        $badals = Badal::with('service.pelanggan')->get();

        foreach ($badals as $item) {
            if ($item->tanggal_pelaksanaan) {
                $pelanggan = $item->service->pelanggan->nama_travel ?? 'N/A';

                $desc = "🕋 DETAIL BADAL UMRAH\n-------------------\n";
                $desc .= "Atas Nama: " . ($item->name ?? '-') . "\n";
                $desc .= "Pelaksanaan: " . date('d M Y', strtotime($item->tanggal_pelaksanaan)) . "\n";
                $desc .= "Customer: $pelanggan\n";
                $desc .= "Harga: SAR " . number_format($item->price ?? 0) . "\n";
                $desc .= "Supplier: " . ($item->supplier ?? '-') . "\n";
                $desc .= "Status: " . ($item->status ?? '-') . "\n";

                $events[] = [
                    'title' => "🕋 Badal: {$item->name} ({$pelanggan})",
                    'start' => $item->tanggal_pelaksanaan,
                    'allDay' => true,
                    'color' => '#6f42c1', // Purple
                    'textColor' => '#fff',
                    'extendedProps' => ['description' => $desc]
                ];
            }
        }

        return $events;
    }

    /**
     * 10. WAKAF DIVISION
     */
    private function getWakafEvents($user): array
    {
        if (!in_array($user->role, ['admin', 'palugada'])) {
            return [];
        }

        $events = [];
        $wakafs = WakafCustomer::with(['service.pelanggan', 'wakaf'])->get();

        foreach ($wakafs as $item) {
            // Karena wakaf biasanya tidak ada 'tanggal pelaksanaan' spesifik di schema sebelumnya,
            // Kita gunakan created_at sebagai tanggal pencatatan, atau service departure jika ada.
            // Di sini saya gunakan created_at.
            $tgl = $item->created_at ? $item->created_at->format('Y-m-d') : null;

            if ($tgl) {
                $pelanggan = $item->service->pelanggan->nama_travel ?? 'N/A';
                $jenisWakaf = $item->wakaf->nama ?? 'Wakaf';

                $desc = "🎁 DETAIL WAKAF\n-------------------\n";
                $desc .= "Jenis: $jenisWakaf\n";
                $desc .= "Customer: $pelanggan\n";
                $desc .= "Tanggal Catat: " . date('d M Y', strtotime($tgl)) . "\n";
                $desc .= "Jumlah: " . ($item->jumlah ?? 0) . " Paket\n";
                $desc .= "Supplier: " . ($item->supplier ?? '-') . "\n";
                $desc .= "Status: " . ($item->status ?? '-') . "\n";

                $events[] = [
                    'title' => "🎁 {$jenisWakaf} ({$item->jumlah} Pax)",
                    'start' => $tgl,
                    'allDay' => true,
                    'color' => '#198754', // Green Success
                    'textColor' => '#fff',
                    'extendedProps' => ['description' => $desc]
                ];
            }
        }

        return $events;
    }

    /**
     * 11. DORONGAN / WHEELCHAIR DIVISION
     */
    private function getDoronganEvents($user): array
    {
        if (!in_array($user->role, ['admin', 'palugada'])) {
            return [];
        }

        $events = [];
        $dorongans = DoronganOrder::with(['service.pelanggan', 'dorongan'])->get();

        foreach ($dorongans as $item) {
            if ($item->tanggal_pelaksanaan) {
                $pelanggan = $item->service->pelanggan->nama_travel ?? 'N/A';
                $tipe = $item->dorongan->name ?? 'Kursi Roda';

                $desc = "♿ DETAIL DORONGAN\n-------------------\n";
                $desc .= "Tipe: $tipe\n";
                $desc .= "Tanggal: " . date('d M Y', strtotime($item->tanggal_pelaksanaan)) . "\n";
                $desc .= "Customer: $pelanggan\n";
                $desc .= "Jumlah: " . ($item->jumlah ?? 0) . " Unit\n";
                $desc .= "Supplier: " . ($item->supplier ?? '-') . "\n";
                $desc .= "Status: " . ($item->status ?? '-') . "\n";

                $events[] = [
                    'title' => "♿ {$tipe}: {$item->jumlah} Unit ({$pelanggan})",
                    'start' => $item->tanggal_pelaksanaan,
                    'allDay' => true,
                    'color' => '#0dcaf0', // Cyan
                    'textColor' => '#000',
                    'extendedProps' => ['description' => $desc]
                ];
            }
        }

        return $events;
    }

    /**
     * 12. EXCHANGE / REYAL DIVISION
     */
    private function getExchangeEvents($user): array
    {
        if (!in_array($user->role, ['admin', 'reyal'])) {
            return [];
        }

        $events = [];
        $exchanges = Exchange::with('service.pelanggan')->get();

        foreach ($exchanges as $item) {
            if ($item->tanggal_penyerahan) {
                $pelanggan = $item->service->pelanggan->nama_travel ?? 'N/A';
                $tipe = strtoupper($item->tipe ?? 'Tukar'); // TAMIS / TUMIS

                $desc = "💱 DETAIL PENUKARAN UANG\n-------------------\n";
                $desc .= "Tipe: $tipe\n";
                $desc .= "Tanggal: " . date('d M Y', strtotime($item->tanggal_penyerahan)) . "\n";
                $desc .= "Customer: $pelanggan\n";
                $desc .= "Input: " . number_format($item->jumlah_input ?? 0) . "\n";
                $desc .= "Hasil: " . ($item->hasil ?? '-') . "\n";
                $desc .= "Kurs: " . ($item->kurs ?? '-') . "\n";
                $desc .= "Supplier: " . ($item->supplier ?? '-') . "\n";
                $desc .= "Status: " . ($item->status ?? '-') . "\n";

                $events[] = [
                    'title' => "💱 {$tipe} ({$pelanggan})",
                    'start' => $item->tanggal_penyerahan,
                    'allDay' => true,
                    'color' => '#343a40', // Dark Grey
                    'textColor' => '#fff',
                    'extendedProps' => ['description' => $desc]
                ];
            }
        }

        return $events;
    }
}
