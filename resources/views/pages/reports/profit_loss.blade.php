@extends('layouts.main')
@section('title', 'RetailPro | Profit & Loss Statement')

@section('content')
<main class="overflow-y-auto p-4 md:p-8 pt-24 bg-slate-50 min-h-screen">
    <div class="max-w-7xl mx-auto">
        
        {{-- Header Section --}}
        <div class="flex flex-col md:flex-row md:items-center justify-between mb-8 gap-4">
            <div>
                <h1 class="text-3xl md:text-4xl font-black text-slate-900 uppercase tracking-tighter italic">P&L Statement</h1>
                <p class="text-[10px] md:text-sm text-amber-600 font-bold uppercase tracking-widest flex items-center gap-2">
                    <i class="fa-solid fa-circle text-[6px] md:text-[8px] animate-pulse"></i> Net Income Analysis Terminal
                </p>
            </div>
            
            {{-- Filter Form --}}
            <form action="{{ route('reports.profit_loss') }}" method="GET" class="flex flex-wrap items-end gap-3 bg-white p-5 rounded-3xl shadow-xl border border-slate-100">
                <div class="group">
                    <label class="block text-[10px] font-black text-slate-400 uppercase mb-1 ml-1">Period From</label>
                    <input type="date" name="start_date" value="{{ $startDate }}" class="px-4 py-2.5 bg-slate-50 border-none rounded-2xl text-sm font-bold outline-none ring-1 ring-slate-200 focus:ring-2 focus:ring-amber-500 transition-all">
                </div>
                <div class="group">
                    <label class="block text-[10px] font-black text-slate-400 uppercase mb-1 ml-1">Period To</label>
                    <input type="date" name="end_date" value="{{ $endDate }}" class="px-4 py-2.5 bg-slate-50 border-none rounded-2xl text-sm font-bold outline-none ring-1 ring-slate-200 focus:ring-2 focus:ring-amber-500 transition-all">
                </div>
                <button type="submit" class="bg-[#0f172a] text-[#f59e0b] px-6 py-2.5 rounded-2xl font-black text-xs uppercase tracking-widest hover:bg-slate-800 transition-all active:scale-95 shadow-lg flex items-center">
                    <i class="fa-solid fa-calculator mr-2"></i> Sync Audit
                </button>
            </form>
        </div>

        {{-- Summary Cards --}}
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-10">
            {{-- Using high-contrast card style --}}
            <div class="bg-white p-6 rounded-[2rem] shadow-lg border border-slate-50 relative overflow-hidden group">
                <div class="absolute -right-4 -top-4 w-20 h-20 bg-slate-100 rounded-full opacity-40"></div>
                <p class="text-[9px] font-black text-slate-400 uppercase tracking-widest relative z-10">Total Revenue</p>
                <h2 class="text-xl md:text-2xl font-black text-slate-900 mt-1 relative z-10 tracking-tighter italic">PKR {{ number_format($totalRevenue) }}</h2>
                <div class="mt-4 flex items-center justify-between relative z-10">
                    <span class="text-[8px] font-black text-slate-600 bg-slate-100 px-2 py-1 rounded-lg uppercase italic">Gross Intake</span>
                    <i class="fa-solid fa-money-bill-trend-up text-slate-200 text-xl"></i>
                </div>
            </div>

            <div class="bg-white p-6 rounded-[2rem] shadow-lg border border-slate-50 relative overflow-hidden group">
                <div class="absolute -right-4 -top-4 w-20 h-20 bg-red-50 rounded-full opacity-40"></div>
                <p class="text-[9px] font-black text-slate-400 uppercase tracking-widest relative z-10">Cost of Goods</p>
                <h2 class="text-xl md:text-2xl font-black text-slate-900 mt-1 relative z-10 tracking-tighter italic">PKR {{ number_format($totalCost) }}</h2>
                <div class="mt-4 flex items-center justify-between relative z-10">
                    <span class="text-[8px] font-black text-red-600 bg-red-50 px-2 py-1 rounded-lg uppercase italic">Inventory Outflow</span>
                    <i class="fa-solid fa-tags text-red-100 text-xl"></i>
                </div>
            </div>

            <div class="bg-white p-6 rounded-[2rem] shadow-lg border border-slate-50 relative overflow-hidden group">
                <div class="absolute -right-4 -top-4 w-20 h-20 bg-amber-50 rounded-full opacity-60"></div>
                <p class="text-[9px] font-black text-amber-600 uppercase tracking-widest relative z-10">Gross Profit</p>
                <h2 class="text-xl md:text-2xl font-black text-slate-900 mt-1 relative z-10 tracking-tighter italic">PKR {{ number_format($grossProfit) }}</h2>
                <div class="mt-4 flex items-center justify-between relative z-10">
                    <span class="text-[8px] font-black text-amber-600 bg-amber-100 px-2 py-1 rounded-lg uppercase italic">Net Gains</span>
                    <i class="fa-solid fa-sack-dollar text-amber-200 text-xl"></i>
                </div>
            </div>

            <div class="bg-white p-6 rounded-[2rem] shadow-lg border border-slate-50 relative overflow-hidden group">
                <div class="absolute -right-4 -top-4 w-20 h-20 bg-[#0f172a]/5 rounded-full"></div>
                <p class="text-[9px] font-black text-slate-400 uppercase tracking-widest relative z-10">Net Margin</p>
                <h2 class="text-xl md:text-2xl font-black text-[#0f172a] mt-1 relative z-10 tracking-tighter italic">{{ number_format($profitMargin, 1) }}%</h2>
                <div class="mt-4 flex items-center justify-between relative z-10">
                    <span class="text-[8px] font-black text-slate-900 bg-slate-100 px-2 py-1 rounded-lg uppercase italic">Efficiency</span>
                    <i class="fa-solid fa-chart-pie text-slate-200 text-xl"></i>
                </div>
            </div>
        </div>

        {{-- Profit Trend Chart --}}
        <div class="bg-white p-8 rounded-[2.5rem] shadow-2xl border border-slate-50 mb-10">
            <h3 class="font-black text-slate-800 uppercase italic tracking-tighter mb-6 flex items-center gap-2">
                <span class="w-1.5 h-6 bg-amber-500 rounded-full"></span>
                Daily Profit Growth trajectory
            </h3>
            <div class="h-[350px]">
                <canvas id="profitTrendChart"></canvas>
            </div>
        </div>

        {{-- Simplified Ledger --}}
        <div class="bg-[#0f172a] rounded-[2.5rem] shadow-2xl overflow-hidden mb-10">
            <div class="p-8 border-b border-slate-800 flex justify-between items-center">
                <h3 class="font-black text-white uppercase italic text-xl tracking-tighter">Financial Audit Journal</h3>
                <span class="text-[10px] font-black text-slate-400 uppercase tracking-widest">Verified Merchant Statement</span>
            </div>
            <div class="p-8 space-y-6">
                <div class="flex justify-between items-center text-lg font-bold text-slate-300">
                    <span class="uppercase tracking-wide text-xs">Total Sales (Tax/Charges Included)</span>
                    <span class="text-white font-black italic">PKR {{ number_format($totalRevenue, 2) }}</span>
                </div>
                <div class="flex justify-between items-center text-lg font-bold text-red-400">
                    <span class="uppercase tracking-wide text-xs">Total Cost of Inventory Sold</span>
                    <span class="font-black italic">- PKR {{ number_format($totalCost, 2) }}</span>
                </div>
                <div class="border-t border-slate-700 border-dashed pt-6 flex justify-between items-center">
                    <div class="flex flex-col">
                        <span class="text-[10px] font-black text-amber-600 uppercase tracking-widest">Final Audit</span>
                        <span class="text-3xl font-black text-white italic uppercase tracking-tighter leading-none mt-1">Gross Income</span>
                    </div>
                    <span class="text-4xl font-black text-amber-500 italic tracking-tighter">PKR {{ number_format($grossProfit, 2) }}</span>
                </div>
            </div>
        </div>
    </div>
</main>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    const ctx = document.getElementById('profitTrendChart').getContext('2d');
    new Chart(ctx, {
        type: 'line',
        data: {
            labels: {!! json_encode($chartData->keys()) !!},
            datasets: [{
                label: 'Net Profit',
                data: {!! json_encode($chartData->values()) !!},
                borderColor: '#f59e0b',
                backgroundColor: (context) => {
                    const ctx = context.chart.ctx;
                    const gradient = ctx.createLinearGradient(0, 0, 0, 300);
                    gradient.addColorStop(0, 'rgba(245, 158, 11, 0.1)');
                    gradient.addColorStop(1, 'rgba(245, 158, 11, 0)');
                    return gradient;
                },
                borderWidth: 5,
                tension: 0.4,
                fill: true,
                pointRadius: 0,
                pointHoverRadius: 8,
                pointHoverBackgroundColor: '#0f172a',
                pointHoverBorderColor: '#f59e0b',
                pointHoverBorderWidth: 3
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: { legend: { display: false } },
            scales: {
                y: { 
                    grid: { color: '#f1f5f9', borderDash: [5, 5] },
                    ticks: { color: '#64748b', font: { weight: '800', size: 10 } }
                },
                x: { 
                    grid: { display: false },
                    ticks: { color: '#64748b', font: { weight: '800', size: 10 } }
                }
            }
        }
    });
</script>
@endpush