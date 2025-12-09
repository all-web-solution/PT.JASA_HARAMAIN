<?php

namespace App\Http\Controllers\Admin;

use App\Helper\ServiceHelper;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\Service;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        // 1. DATA FILTER TAHUN
        $selectedYear = $request->input('year', Carbon::now()->year);
        $availableYears = Order::selectRaw('YEAR(created_at) as year')
            ->distinct()
            ->orderBy('year', 'desc')
            ->pluck('year');

        // ---------------------------------------------------------
        // 2. DATA CHART KEUANGAN LENGKAP (Stacked Chart)
        // ---------------------------------------------------------

        // A. PENDAPATAN REAL (Uang Masuk / Cash In)
        // Menghitung total_yang_dibayarkan dari semua status (Lunas/Cicil)
        $cashInQuery = Order::selectRaw('MONTH(created_at) as month, SUM(total_yang_dibayarkan) as total')
            ->whereYear('created_at', $selectedYear)
            ->where('status_pembayaran', '!=', 'batal')
            ->groupBy('month')
            ->pluck('total', 'month');

        // B. SISA PIUTANG (Uang Tertunda / Outstanding)
        // Menghitung sisa_hutang dari transaksi yang belum lunas
        $debtQuery = Order::selectRaw('MONTH(created_at) as month, SUM(sisa_hutang) as total')
            ->whereYear('created_at', $selectedYear)
            ->where('status_pembayaran', '!=', 'batal')
            ->groupBy('month')
            ->pluck('total', 'month');

        // Siapkan array data 12 bulan
        $monthlyCashIn = [];
        $monthlyDebt = [];

        for ($i = 1; $i <= 12; $i++) {
            $monthlyCashIn[] = $cashInQuery->get($i, 0);
            $monthlyDebt[]   = $debtQuery->get($i, 0);
        }

        // ---------------------------------------------------------
        // 3. DATA CHART DISTRIBUSI SERVICE
        // ---------------------------------------------------------

        $countHotel     = Service::has('hotels')->count();
        $countTransport = Service::whereHas('planes')->orWhereHas('transportationItem')->count();
        $countTour      = Service::has('tours')->count();
        $countHandling  = Service::has('handlings')->count();
        $countDocument  = Service::has('documents')->count();
        $countBadal     = Service::has('badals')->count();
        $countGuide     = Service::has('guides')->count();
        $countContent   = Service::has('contents')->count();
        $countReyal     = Service::has('exchanges')->count();
        $countMeal      = Service::has('meals')->count();
        $countDorongan  = Service::has('dorongans')->count();
        $countWakaf     = Service::has('wakafs')->count();

        $serviceDistribution = [
            'labels' => [
                'Hotel', 'Transportasi', 'Tour', 'Handling', 'Dokumen/Visa', 'Badal',
                'Pendamping', 'Konten', 'Reyal', 'Meals', 'Dorongan', 'Wakaf'
            ],
            'data'   => [
                $countHotel, $countTransport, $countTour, $countHandling, $countDocument, $countBadal,
                $countGuide, $countContent, $countReyal, $countMeal, $countDorongan, $countWakaf
            ]
        ];

        $serviceStatus = ServiceHelper::allStatusCount();

        return view('admin.dashboard', compact(
            'serviceStatus',
            'monthlyCashIn',
            'monthlyDebt',
            'serviceDistribution',
            'availableYears',
            'selectedYear'
        ));
    }
}
