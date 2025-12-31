@extends('layouts.main')
@section('title', 'RetailPro | Profit & Loss')

@section('content')
    <main class="overflow-y-auto p-4 md:p-8 pt-24 bg-[#f1f5f9] min-h-screen">
        <div class="max-w-[1600px] mx-auto w-full">

            {{-- Header Section --}}
            <div class="flex flex-col md:flex-row md:items-center justify-between mb-8 gap-4 px-2">
                <div>
                    <h1 class="text-3xl md:text-4xl font-black text-slate-900 uppercase tracking-tighter italic">Profit &
                        Loss</h1>
                    <p
                        class="text-[10px] md:text-sm text-amber-600 font-bold uppercase tracking-widest flex items-center gap-2">
                        <span class="w-2 h-2 bg-amber-500 rounded-full animate-pulse"></span> Net Earnings Analysis
                    </p>
                </div>

                {{-- Simple Filter Form --}}
                <form action="{{ route('reports.profit_loss') }}" method="GET"
                    class="flex flex-wrap items-end gap-3 bg-white p-5 rounded-3xl shadow-xl border border-slate-100">
                    <div class="group">
                        <label class="block text-[10px] font-black text-slate-400 uppercase mb-1 ml-1">From Date</label>
                        <input type="date" name="start_date" value="{{ $startDate }}"
                            class="px-4 py-2.5 bg-slate-50 border-none rounded-2xl text-sm font-bold outline-none ring-1 ring-slate-200 focus:ring-2 focus:ring-amber-500 transition-all">
                    </div>
                    <div class="group">
                        <label class="block text-[10px] font-black text-slate-400 uppercase mb-1 ml-1">To Date</label>
                        <input type="date" name="end_date" value="{{ $endDate }}"
                            class="px-4 py-2.5 bg-slate-50 border-none rounded-2xl text-sm font-bold outline-none ring-1 ring-slate-200 focus:ring-2 focus:ring-amber-500 transition-all">
                    </div>
                    <button type="submit"
                        class="bg-[#0f172a] text-[#f59e0b] px-6 py-2.5 rounded-2xl font-black text-xs uppercase tracking-widest hover:bg-slate-800 transition-all active:scale-95 shadow-lg flex items-center">
                        <i class="fa-solid fa-calculator mr-2"></i> Update Report
                    </button>
                </form>
            </div>

            {{-- Summary Cards --}}
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-10 px-2">
                {{-- Revenue Card --}}
                <div class="bg-white p-6 rounded-[2rem] shadow-lg border border-slate-50 relative overflow-hidden group">
                    <div class="absolute -right-4 -top-4 w-20 h-20 bg-slate-100 rounded-full opacity-40"></div>
                    <p class="text-[9px] font-black text-slate-400 uppercase tracking-widest relative z-10">Total Sales</p>
                    <h2
                        class="text-xl md:text-2xl font-black text-slate-900 mt-1 relative z-10 tracking-tighter italic leading-none">
                        PKR {{ number_format($totalRevenue) }}</h2>
                    <div class="mt-4 flex items-center justify-between relative z-10">
                        <span
                            class="text-[8px] font-black text-slate-600 bg-slate-100 px-2 py-1 rounded-lg uppercase italic">Total
                            Intake</span>
                        <i class="fa-solid fa-money-bill-wave text-slate-200 text-xl"></i>
                    </div>
                </div>

                {{-- Cost Card --}}
                <div class="bg-white p-6 rounded-[2rem] shadow-lg border border-slate-50 relative overflow-hidden group">
                    <div class="absolute -right-4 -top-4 w-20 h-20 bg-red-50 rounded-full opacity-40"></div>
                    <p class="text-[9px] font-black text-slate-400 uppercase tracking-widest relative z-10">Purchase Cost
                    </p>
                    <h2
                        class="text-xl md:text-2xl font-black text-slate-900 mt-1 relative z-10 tracking-tighter italic leading-none">
                        PKR {{ number_format($totalCost) }}</h2>
                    <div class="mt-4 flex items-center justify-between relative z-10">
                        <span
                            class="text-[8px] font-black text-red-600 bg-red-50 px-2 py-1 rounded-lg uppercase italic">Buying
                            Price</span>
                        <i class="fa-solid fa-cart-flatbed text-red-100 text-xl"></i>
                    </div>
                </div>

                {{-- Profit Card --}}
                <div class="bg-white p-6 rounded-[2rem] shadow-lg border border-slate-50 relative overflow-hidden group">
                    <div class="absolute -right-4 -top-4 w-20 h-20 bg-amber-50 rounded-full opacity-60"></div>
                    <p class="text-[9px] font-black text-amber-600 uppercase tracking-widest relative z-10">Sale Profit</p>
                    <h2
                        class="text-xl md:text-2xl font-black text-slate-900 mt-1 relative z-10 tracking-tighter italic leading-none">
                        PKR {{ number_format($grossProfit) }}</h2>
                    <div class="mt-4 flex items-center justify-between relative z-10">
                        <span
                            class="text-[8px] font-black text-amber-600 bg-amber-100 px-2 py-1 rounded-lg uppercase italic">Net
                            Margin</span>
                        <i class="fa-solid fa-hand-holding-dollar text-amber-200 text-xl"></i>
                    </div>
                </div>

                {{-- Percentage Card --}}
                <div class="bg-white p-6 rounded-[2rem] shadow-lg border border-slate-50 relative overflow-hidden group">
                    <div class="absolute -right-4 -top-4 w-20 h-20 bg-[#0f172a]/5 rounded-full"></div>
                    <p class="text-[9px] font-black text-slate-400 uppercase tracking-widest relative z-10">Profit %</p>
                    <h2
                        class="text-xl md:text-2xl font-black text-[#0f172a] mt-1 relative z-10 tracking-tighter italic leading-none">
                        {{ number_format($profitMargin, 1) }}%</h2>
                    <div class="mt-4 flex items-center justify-between relative z-10">
                        <span
                            class="text-[8px] font-black text-slate-900 bg-slate-100 px-2 py-1 rounded-lg uppercase italic">Efficiency</span>
                        <i class="fa-solid fa-chart-line text-slate-200 text-xl"></i>
                    </div>
                </div>
            </div>

            {{-- Growth Chart --}}
            <div class="bg-white p-6 md:p-8 rounded-[2.5rem] shadow-2xl border border-slate-50 mb-10 mx-2">
                <h3 class="font-black text-slate-800 uppercase italic tracking-tighter mb-6 flex items-center gap-2">
                    <span class="w-1.5 h-6 bg-[#f59e0b] rounded-full"></span>
                    Daily Profit Performance
                </h3>
                <div class="h-[350px]">
                    <canvas id="profitTrendChart"></canvas>
                </div>
            </div>

            {{-- Simple Account Summary --}}
            <div class="bg-[#0f172a] rounded-[2.5rem] shadow-2xl overflow-hidden mb-10 mx-2">
                <div class="p-8 border-b border-slate-800 flex justify-between items-center bg-[#0f172a]">
                    <h3 class="font-black text-white uppercase italic text-xl tracking-tighter">Final Account Summary</h3>
                    <span class="text-[10px] font-black text-slate-400 uppercase tracking-widest">Verified Report</span>
                </div>
                <div class="p-8 space-y-6">
                    <div class="flex justify-between items-center text-lg font-bold text-slate-300">
                        <span class="uppercase tracking-wide text-xs">Total Sales Income</span>
                        <span class="text-white font-black italic">PKR {{ number_format($totalRevenue, 2) }}</span>
                    </div>
                    <div class="flex justify-between items-center text-lg font-bold text-red-400">
                        <span class="uppercase tracking-wide text-xs">Total Stock Cost</span>
                        <span class="font-black italic">- PKR {{ number_format($totalCost, 2) }}</span>
                    </div>
                    <div class="border-t border-slate-700 border-dashed pt-6 flex justify-between items-center">
                        <div class="flex flex-col">
                            <span class="text-[10px] font-black text-amber-600 uppercase tracking-widest">Net Result</span>
                            <span
                                class="text-3xl font-black text-white italic uppercase tracking-tighter leading-none mt-1">Gross
                                Profit</span>
                        </div>
                        <span class="text-4xl font-black text-amber-500 italic tracking-tighter">PKR
                            {{ number_format($grossProfit, 2) }}</span>
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
                    data: {!! json_encode($chartData->values()) !!},
                    borderColor: '#f59e0b',
                    backgroundColor: (context) => {
                        const ctx = context.chart.ctx;
                        const gradient = ctx.createLinearGradient(0, 0, 0, 300);
                        gradient.addColorStop(0, 'rgba(245, 158, 11, 0.15)');
                        gradient.addColorStop(1, 'rgba(245, 158, 11, 0)');
                        return gradient;
                    },
                    borderWidth: 4,
                    tension: 0.4,
                    fill: true,
                    pointRadius: 4,
                    pointBackgroundColor: '#fff',
                    pointBorderColor: '#f59e0b',
                    pointBorderWidth: 2,
                    pointHoverRadius: 8
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: { legend: { display: false } },
                scales: {
                    y: {
                        grid: { color: '#f1f5f9' },
                        ticks: { color: '#64748b', font: { weight: '900', size: 10 } }
                    },
                    x: {
                        grid: { display: false },
                        ticks: { color: '#64748b', font: { weight: '900', size: 10 } }
                    }
                }
            }
        });
    </script>
@endpush