<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Service;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\Pelanggan;

class InvoiceController extends Controller
{
    // Tampilkan di browser
    public function show($id)
    {
        // 1. Ambil Data Order beserta Service dan semua detailnya
        // Kita mulai dari 'Order' agar dapat nomor Invoice & Total Tagihan
        $order = Order::with([
            'service.pelanggan',
            'service.hotels',
            'service.planes',               // Ganti 'transportationItem' dengan relasi spesifik jika perlu
            'service.transportationItem.transportation', // Load nama mobil/bus
            'service.meals.mealItem',
            'service.guides.guideItem',
            'service.dorongans.dorongan',
            'service.wakafs.wakaf',
            'service.badals',
            'service.tours.tourItem',
            'service.documents.document',   // Load nama dokumen induk
            'service.handlings',
            'service.contents.content',
            'service.exchanges',
        ])->findOrFail($id);

        // 2. Siapkan Data Tambahan (Opsional)
        $data = [
            'order'   => $order,
            'service' => $order->service,
            'client'  => $order->service->pelanggan,
            'company' => [
                'name'    => 'PT. JASA HARAMAIN GRUP',
                'address' => 'Jl. Mesjid Taqwa, No. 57, Desa Seutui, Kec. Baiturrahman, Kota Banda Aceh, 23243', // Ganti dengan alamat asli
                'phone'   => '+62 823 6462 3556',
                'email'   => 'jasaharamainagrup@gmail.com',
            ]
        ];

        // 3. Render PDF
        $pdf = Pdf::loadView('invoices.show', $data)
                ->setPaper('A4', 'portrait');

        // 4. Stream (Tampilkan di browser) atau Download
        return $pdf->stream('Invoice_' . $order->invoice . '.pdf');
    }

    // Download PDF
    public function download(Service $service)
    {
        $pdf = Pdf::loadView('invoices.show', compact('service'))
            ->setPaper('a4', 'portrait');

        $filename = "invoice_{$service->id}.pdf";
        return $pdf->download($filename);
    }

    public function cetak($id)
    {
        $service = Service::with([
            'hotels', 'transportationItem', 'meals', 'guides',
            'dorongans.dorongan', 'wakafs.wakaf', 'badals.badal',
            'tours','handlings', 'contents', 'exchanges'
        ])->findOrFail($id);

        $pdf = Pdf::loadView('invoices.cetak', compact('service'))
                  ->setPaper('A4', 'portrait');

        return $pdf->stream('Invoice_'.$service->id.'.pdf');
        // kalau mau langsung download:
        // return $pdf->download('Invoice_'.$service->id.'.pdf');
    }
}
