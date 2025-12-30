<?php

namespace App\Http\Controllers;

use App\Models\Sale;
use App\Models\Customer;
use App\Models\MedicineVariant;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        $todaySales = Sale::whereDate('sale_date', Carbon::today())->sum('total_amount');
        $yesterdaySales = Sale::whereDate('sale_date', Carbon::yesterday())->sum('total_amount');
        
        $percentageIncrease = $yesterdaySales > 0 
            ? (($todaySales - $yesterdaySales) / $yesterdaySales) * 100 
            : ($todaySales > 0 ? 100 : 0);

        $lowStockCount = MedicineVariant::whereColumn('stock_level', '<=', 'reorder_level')->count();

        $expiringCount = MedicineVariant::whereBetween('expiry_date', [Carbon::now(), Carbon::now()->addDays(30)])->count();

        $totalCreditDue = Customer::sum('credit_balance');

        $salesTrend = Sale::where('sale_date', '>=', Carbon::now()->subDays(30))
            ->select(DB::raw('DATE(sale_date) as date'), DB::raw('SUM(total_amount) as total'))
            ->groupBy('date')
            ->orderBy('date')
            ->get();

        $topSelling = DB::table('sale_items')
            ->join('medicine_variants', 'sale_items.medicine_variant_id', '=', 'medicine_variants.id')
            ->join('medicines', 'medicine_variants.medicine_id', '=', 'medicines.id')
            ->select('medicines.name', DB::raw('SUM(sale_items.quantity) as units'), DB::raw('SUM(sale_items.quantity * sale_items.unit_price) as revenue'))
            ->groupBy('medicines.name')
            ->orderBy('units', 'desc')
            ->limit(5)
            ->get();

        $categoryBreakdown = DB::table('medicine_variants')
            ->join('medicines', 'medicine_variants.medicine_id', '=', 'medicines.id')
            ->select('medicines.category', DB::raw('SUM(medicine_variants.stock_level * medicine_variants.purchase_price) as value'))
            ->groupBy('medicines.category')
            ->get();

        return view('pages.dashboard', compact(
            'todaySales', 'percentageIncrease', 'lowStockCount', 
            'expiringCount', 'totalCreditDue', 'salesTrend', 
            'topSelling', 'categoryBreakdown'
        ));
    }
}