<?php
namespace App\Http\Controllers;

use App\Models\MedicineVariant;
use App\Models\Sale;
use Carbon\Carbon;
use Illuminate\Http\Request;

class SalesReportController extends Controller
{
    public function index(Request $request)
    {
        // 1. Get Filter Inputs (Defaults to current month)
        $startDate = $request->input('start_date', Carbon::now()->startOfMonth()->toDateString());
        $endDate   = $request->input('end_date', Carbon::now()->toDateString());
        $status    = $request->input('status');

        // 2. Build Query with Inclusive Dates
        // Carbon::parse($date)->endOfDay() use karne se us din ki aakhri second (23:59:59) tak ka data shamil ho jata hai
        $query = Sale::with(['customer', 'items.medicineVariant.medicine'])
            ->whereBetween('sale_date', [
                Carbon::parse($startDate)->startOfDay(),
                Carbon::parse($endDate)->endOfDay(),
            ]);

        if ($status) {
            $query->where('status', $status);
        }
        // Low Stock Count (based on reorder_level)
        $lowStockCount = MedicineVariant::whereColumn('stock_level', '<=', 'reorder_level')->count();

        // Data fetch karein (latest first for table)
        $sales = $query->latest('sale_date')->get();

        // 3. Calculate Summary Cards
        $totalRevenue    = $sales->sum('total_amount');
        $totalSalesCount = $sales->count();
        $cashReceived    = $sales->sum('cash_received');
        $remainingDebt   = $totalRevenue - $cashReceived;

        // 4. Grouped Data for Charts (Daily Revenue)
        // Pehle hum data ko date wise sort karenge taake chart ki line seedhi chale
        $chartData = $sales->sortBy('sale_date')
            ->groupBy(function ($sale) {
                return Carbon::parse($sale->sale_date)->format('d M');
            })
            ->map(function ($day) {
                return $day->sum('total_amount');
            });

        return view('pages.reports.sales', compact(
            'sales',
            'totalRevenue',
            'totalSalesCount',
            'cashReceived',
            'remainingDebt',
            'startDate',
            'endDate',
            'chartData',
            'lowStockCount'
        ));
    }
}
