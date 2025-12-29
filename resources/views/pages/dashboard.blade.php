@extends('layouts.main')
@section('title', 'RetailPro | Overview')

@section('content')
<main class="overflow-y-auto p-6 md:p-8 pt-24 bg-[#f8fafc] min-h-screen">
    <div class="max-w-[1600px] mx-auto">
        
        {{-- Header Section: Minimal Dark, More White --}}
        <div class="flex flex-col md:flex-row md:items-end justify-between mb-8 border-b border-slate-200 pb-6">
            <div>
                <h1 class="text-3xl font-black text-slate-800 tracking-tighter uppercase italic">Pharmacy Overview</h1>
                <p class="text-slate-500 font-medium">Live Metrics: <span class="text-amber-600 font-bold">{{ now()->format('d M, Y h:i A') }}</span></p>
            </div>
            <div class="mt-4 md:mt-0">
                <span class="px-4 py-2 bg-white border border-slate-200 text-slate-700 text-xs font-black rounded-xl shadow-sm uppercase tracking-widest flex items-center">
                    <span class="h-2 w-2 bg-emerald-500 rounded-full mr-2 animate-pulse"></span>
                    Live System
                </span>
            </div>
        </div>

        {{-- Stats Grid: All White Cards --}}
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-10">
            
            {{-- Revenue Card --}}
            <div class="p-6 rounded-2xl border border-slate-100 bg-white shadow-sm hover:shadow-md transition-all group">
                <div class="flex items-center justify-between mb-4">
                    <div class="w-12 h-12 flex items-center justify-center rounded-xl bg-amber-50 text-amber-600 group-hover:bg-amber-500 group-hover:text-white transition-colors">
                        <i class="fa-solid fa-cash-register text-xl"></i>
                    </div>
                    <div class="text-right">
                        <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest">Revenue Today</p>
                        <h2 class="text-2xl font-black text-slate-800">PKR {{ number_format($todaySales, 0) }}</h2>
                    </div>
                </div>
                <div class="pt-4 border-t border-slate-50 flex items-center justify-between">
                    <span class="text-xs font-bold {{ $percentageIncrease >= 0 ? 'text-emerald-600' : 'text-red-600' }}">
                        {{ $percentageIncrease >= 0 ? '+' : '' }}{{ number_format($percentageIncrease, 1) }}%
                    </span>
                    <span class="text-[9px] font-black text-slate-400 uppercase">Vs Yesterday</span>
                </div>
            </div>

            {{-- Low Stock Card --}}
            <div class="p-6 rounded-2xl border border-slate-100 bg-white shadow-sm hover:shadow-md transition-all group">
                <div class="flex items-center justify-between mb-4">
                    <div class="w-12 h-12 flex items-center justify-center rounded-xl bg-red-50 text-red-500 group-hover:bg-red-500 group-hover:text-white transition-colors">
                        <i class="fa-solid fa-boxes-stacked text-xl"></i>
                    </div>
                    <div class="text-right">
                        <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest">Low Stock</p>
                        <h2 class="text-2xl font-black text-slate-800">{{ $lowStockCount }}</h2>
                    </div>
                </div>
                <a href="{{ route('medicines.index') }}" class="text-[10px] font-black text-red-500 uppercase hover:underline">Manage Inventory →</a>
            </div>

            {{-- Expiry Card --}}
            <div class="p-6 rounded-2xl border border-slate-100 bg-white shadow-sm hover:shadow-md transition-all group">
                <div class="flex items-center justify-between mb-4">
                    <div class="w-12 h-12 flex items-center justify-center rounded-xl bg-blue-50 text-blue-500 group-hover:bg-blue-500 group-hover:text-white transition-colors">
                        <i class="fa-solid fa-calendar-times text-xl"></i>
                    </div>
                    <div class="text-right">
                        <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest">Expiring Soon</p>
                        <h2 class="text-2xl font-black text-slate-800">{{ $expiringCount }}</h2>
                    </div>
                </div>
                <p class="text-[10px] font-black text-slate-400 uppercase">Next 30 Days Window</p>
            </div>

            {{-- Credit Card --}}
            <div class="p-6 rounded-2xl border border-slate-100 bg-white shadow-sm hover:shadow-md transition-all group">
                <div class="flex items-center justify-between mb-4">
                    <div class="w-12 h-12 flex items-center justify-center rounded-xl bg-emerald-50 text-emerald-600 group-hover:bg-emerald-500 group-hover:text-white transition-colors">
                        <i class="fa-solid fa-hand-holding-dollar text-xl"></i>
                    </div>
                    <div class="text-right">
                        <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest">Total Credit</p>
                        <h2 class="text-2xl font-black text-slate-800">PKR {{ number_format($totalCreditDue, 0) }}</h2>
                    </div>
                </div>
                <a href="{{ route('customers.index') }}" class="text-[10px] font-black text-emerald-600 uppercase hover:underline">Ledger View →</a>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            {{-- Revenue Chart: Clean White Design --}}
            <div class="lg:col-span-2 bg-white rounded-2xl shadow-sm border border-slate-100 p-8">
                <h2 class="text-lg font-black text-slate-800 mb-8 uppercase tracking-tighter flex items-center">
                    <span class="w-1.5 h-6 bg-amber-500 rounded-full mr-3"></span>
                    Revenue Analytics
                </h2>
                <div class="h-[380px] w-full">
                    <canvas id="salesChart"></canvas>
                </div>
            </div>

            {{-- Top Selling: White Theme with Light Accents --}}
            <div class="lg:col-span-1 bg-white rounded-2xl shadow-sm border border-slate-100 p-8">
                <h2 class="text-lg font-black text-slate-800 mb-8 uppercase tracking-tighter italic">
                    <i class="fa-solid fa-star text-amber-500 mr-2"></i> Hot Sellers
                </h2>
                <div class="space-y-5">
                    @foreach($topSelling as $item)
                    <div class="flex items-center justify-between p-3 rounded-xl hover:bg-slate-50 transition-colors border border-transparent hover:border-slate-100">
                        <div class="flex items-center gap-3">
                            <span class="text-xs font-black text-slate-300">0{{ $loop->iteration }}</span>
                            <div>
                                <p class="text-sm font-bold text-slate-700 truncate w-32">{{ $item->name }}</p>
                                <p class="text-[10px] font-black text-slate-400 uppercase">{{ $item->units }} Sold</p>
                            </div>
                        </div>
                        <div class="text-right">
                            <p class="text-sm font-black text-amber-600">PKR {{ number_format($item->revenue, 0) }}</p>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</main>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    const salesTrendData = {!! json_encode($salesTrend) !!};
    new Chart(document.getElementById('salesChart'), {
        type: 'line',
        data: {
            labels: salesTrendData.map(d => d.date),
            datasets: [{
                data: salesTrendData.map(d => d.total),
                borderColor: "#f59e0b",
                borderWidth: 4,
                backgroundColor: (context) => {
                    const ctx = context.chart.ctx;
                    const gradient = ctx.createLinearGradient(0, 0, 0, 350);
                    gradient.addColorStop(0, 'rgba(245, 158, 11, 0.1)');
                    gradient.addColorStop(1, 'rgba(245, 158, 11, 0)');
                    return gradient;
                },
                fill: true,
                tension: 0.4,
                pointRadius: 4,
                pointBackgroundColor: "#ffffff",
                pointBorderColor: "#f59e0b",
                pointBorderWidth: 2,
                pointHoverRadius: 6
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: { legend: { display: false } },
            scales: {
                x: { grid: { display: false }, ticks: { color: "#94a3b8", font: { weight: '700', size: 10 } } },
                y: { 
                    border: { display: false },
                    grid: { color: "#f1f5f9" },
                    ticks: { color: "#94a3b8", font: { weight: '700', size: 10 }, callback: v => v.toLocaleString() }
                }
            }
        }
    });
</script>
@endpush