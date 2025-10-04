<?php

namespace App\Http\Controllers;

use App\Models\Service;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\Pelanggan;

class InvoiceController extends Controller
{
    // Tampilkan di browser
    public function show($id)
    {
         $pelanggan = Pelanggan::with([
            'services.hotels',
            'services.transportationItem',
            'services.meals',
            'services.guides',
            'services.dorongans.dorongan',
            'services.wakafs.wakaf',
            'services.badals',
            'services.tours',
            'services.documents',
            'services.handlings',
            'services.contents',
            'services.documents',
            'services.reyals',
        ])->findOrFail($id);

        $pdf = Pdf::loadView('invoices.show', compact('pelanggan'))
                  ->setPaper('A4', 'portrait');

        return $pdf->stream('Invoice_'.$pelanggan->nama.'.pdf');
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
            'tours','handlings', 'contents', 'reyals'
        ])->findOrFail($id);

        $pdf = Pdf::loadView('invoices.cetak', compact('service'))
                  ->setPaper('A4', 'portrait');

        return $pdf->stream('Invoice_'.$service->id.'.pdf');
        // kalau mau langsung download:
        // return $pdf->download('Invoice_'.$service->id.'.pdf');
    }
}
