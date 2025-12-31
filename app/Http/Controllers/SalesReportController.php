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
        $startDate = $request->input('start_date', Carbon::now()->startOfMonth()->toDateString());
        $endDate   = $request->input('end_date', Carbon::now()->toDateString());
        $status    = $request->input('status');

        $query = Sale::with(['customer', 'items.medicineVariant.medicine'])
            ->whereBetween('sale_date', [
                Carbon::parse($startDate)->startOfDay(),
                Carbon::parse($endDate)->endOfDay(),
            ]);

        if ($status) {
            $query->where('status', $status);
        }
        $lowStockCount = MedicineVariant::whereColumn('stock_level', '<=', 'reorder_level')->count();

        $sales = $query->latest('sale_date')->get();

        $totalRevenue    = $sales->sum('total_amount');
        $totalSalesCount = $sales->count();
        $cashReceived    = $sales->sum('cash_received');
        $remainingDebt   = $totalRevenue - $cashReceived;

     
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
