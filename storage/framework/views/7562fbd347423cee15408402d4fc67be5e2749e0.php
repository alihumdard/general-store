
<?php $__env->startSection('title', 'RetailPro | Executive Intelligence'); ?>

<?php $__env->startSection('content'); ?>
<main class="overflow-y-auto p-4 md:p-8 pt-24 bg-[#f1f5f9] min-h-screen">
    <div class="max-w-[1600px] mx-auto w-full space-y-8">
        
        
        <div class="flex flex-col lg:flex-row lg:items-center justify-between gap-4 bg-white p-6 rounded-[2rem] shadow-sm border border-slate-100">
            <div>
                <h1 class="text-2xl md:text-4xl font-black text-slate-900 tracking-tighter uppercase italic leading-none">
                    Store Overview
                </h1>
                <p class="text-slate-400 text-[10px] font-black uppercase tracking-widest mt-2 flex items-center">
                    <span class="w-2 h-2 bg-emerald-500 rounded-full mr-2 animate-pulse"></span>
                    Terminal: <?php echo e(Auth::user()->name ?? 'Main Desk'); ?> • <?php echo e(now()->format('l, d F Y')); ?>

                </p>
            </div>
            
            <div class="flex gap-3">
                <a href="<?php echo e(route('pos')); ?>" class="flex items-center gap-2 px-6 py-3 bg-[#0f172a] text-white rounded-2xl shadow-xl hover:bg-slate-800 transition active:scale-95 text-[10px] font-black uppercase tracking-widest">
                    <i class="fa-solid fa-bolt-lightning text-amber-500"></i> New Transaction
                </a>
                <button onclick="window.location.reload()" class="p-3 bg-white border border-slate-200 text-slate-400 rounded-2xl hover:text-amber-600 transition shadow-sm">
                    <i class="fa-solid fa-sync"></i>
                </button>
            </div>
        </div>

        
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
            <div class="bg-white p-6 rounded-[2.5rem] border border-slate-100 shadow-sm relative overflow-hidden group transition-all hover:shadow-xl hover:-translate-y-1">
                <div class="absolute -right-4 -top-4 w-24 h-24 bg-amber-500/5 rounded-full group-hover:scale-150 transition-transform"></div>
                <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-1">Today's Revenue</p>
                <h2 class="text-3xl font-black text-slate-900 tracking-tight italic leading-none">PKR <?php echo e(number_format($todaySales, 0)); ?></h2>
                <div class="mt-4 flex items-center gap-2">
                    <span class="px-2 py-1 bg-emerald-50 text-emerald-600 text-[10px] font-black rounded-lg uppercase">
                        <?php echo e($percentageIncrease >= 0 ? '+' : ''); ?><?php echo e(number_format($percentageIncrease, 1)); ?>%
                    </span>
                    <span class="text-[9px] font-bold text-slate-300 uppercase italic">Vs. Prev. Day</span>
                </div>
            </div>

            <div class="bg-white p-6 rounded-[2.5rem] border border-slate-100 shadow-sm relative overflow-hidden group transition-all hover:shadow-xl hover:-translate-y-1">
                <div class="absolute -right-4 -top-4 w-24 h-24 bg-red-500/5 rounded-full group-hover:scale-150 transition-transform"></div>
                <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-1">Critical Stock</p>
                <h2 class="text-3xl font-black text-slate-900 tracking-tight italic leading-none"><?php echo e($lowStockCount); ?> <span class="text-sm not-italic font-bold text-slate-300">Units</span></h2>
                <div class="mt-4 flex items-center justify-between">
                    <a href="<?php echo e(route('medicines.index')); ?>" class="text-[10px] font-black text-red-500 uppercase tracking-widest hover:underline">Restock Desk →</a>
                    <i class="fa-solid fa-boxes-stacked text-slate-100 text-2xl"></i>
                </div>
            </div>

            <div class="bg-white p-6 rounded-[2.5rem] border border-slate-100 shadow-sm relative overflow-hidden group transition-all hover:shadow-xl hover:-translate-y-1">
                <div class="absolute -right-4 -top-4 w-24 h-24 bg-emerald-500/5 rounded-full group-hover:scale-150 transition-transform"></div>
                <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-1">Net Receivables</p>
                <h2 class="text-3xl font-black text-slate-900 tracking-tight italic leading-none">PKR <?php echo e(number_format($totalCreditDue, 0)); ?></h2>
                <div class="mt-4">
                    <a href="<?php echo e(route('customers.index')); ?>" class="text-[10px] font-black text-emerald-600 uppercase tracking-widest hover:underline">View Ledgers →</a>
                </div>
            </div>

            <div class="bg-white p-6 rounded-[2.5rem] border border-slate-100 shadow-sm relative overflow-hidden group transition-all hover:shadow-xl hover:-translate-y-1">
                <div class="absolute -right-4 -top-4 w-24 h-24 bg-blue-500/5 rounded-full group-hover:scale-150 transition-transform"></div>
                <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-1">Shelf Lifespan</p>
                <h2 class="text-3xl font-black text-slate-900 tracking-tight italic leading-none"><?php echo e($expiringCount); ?> <span class="text-sm not-italic font-bold text-slate-300">Expiring</span></h2>
                <div class="mt-4 flex items-center gap-2 text-blue-500 font-black text-[9px] uppercase italic">
                    <i class="fa-solid fa-check-double"></i> Verified Assets
                </div>
            </div>
        </div>

        
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <div class="lg:col-span-2 bg-white rounded-[3rem] shadow-sm border border-slate-100 p-8">
                <div class="flex items-center justify-between mb-8">
                    <h2 class="text-xl font-black text-slate-900 uppercase italic tracking-tighter flex items-center">
                        <span class="w-1.5 h-6 bg-[#0f172a] rounded-full mr-3"></span>
                        Revenue Trajectory
                    </h2>
                    <span class="px-3 py-1 bg-slate-50 text-slate-400 text-[9px] font-black rounded-full uppercase italic">30-Day Flow</span>
                </div>
                <div class="h-[350px] w-full">
                    <canvas id="salesChart"></canvas>
                </div>
            </div>

            <div class="lg:col-span-1 bg-[#0f172a] rounded-[3rem] shadow-2xl p-8 text-white">
                <h2 class="text-lg font-black text-amber-50 mb-6 uppercase italic border-b border-slate-800 pb-4">
                    <i class="fa-solid fa-fire text-amber-500 mr-2"></i> Fast Moving Items
                </h2>
                <div class="space-y-6">
                    <?php $__currentLoopData = $topSelling; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <div class="flex items-center justify-between group cursor-pointer">
                        <div class="flex items-center gap-4">
                            <div class="w-10 h-10 bg-slate-800 rounded-xl flex items-center justify-center font-black text-slate-500 group-hover:bg-amber-500 group-hover:text-[#0f172a] transition-all">
                                <?php echo e($loop->iteration); ?>

                            </div>
                            <div>
                                <p class="text-sm font-black uppercase tracking-tight group-hover:text-amber-400 transition-colors"><?php echo e($item->name); ?></p>
                                <p class="text-[9px] font-bold text-slate-500 uppercase tracking-widest"><?php echo e($item->units); ?> Units Transacted</p>
                            </div>
                        </div>
                        <p class="text-xs font-black italic text-amber-500">PKR <?php echo e(number_format($item->revenue, 0)); ?></p>
                    </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>
            </div>
        </div>

        
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            <div class="bg-white rounded-[2.5rem] shadow-sm border border-slate-100 p-8">
                <h2 class="text-lg font-black text-slate-900 mb-6 uppercase tracking-tighter italic">P&L Comparison</h2>
                <div class="h-[250px]">
                    <canvas id="pnlComparisonChart"></canvas>
                </div>
            </div>

            <div class="bg-white rounded-[2.5rem] shadow-sm border border-slate-100 p-8">
                <h2 class="text-lg font-black text-slate-900 mb-6 uppercase tracking-tighter italic">Stock Valuation</h2>
                <div class="h-[250px]">
                    <canvas id="categoryValueChart"></canvas>
                </div>
            </div>

            <div class="bg-white rounded-[2.5rem] shadow-sm border border-slate-100 p-8">
                <h2 class="text-lg font-black text-slate-900 mb-6 uppercase tracking-tighter italic text-center">Asset Distribution</h2>
                <div class="h-[250px]">
                    <canvas id="distributionChart"></canvas>
                </div>
            </div>
        </div>
    </div>
</main>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('scripts'); ?>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    Chart.defaults.font.family = 'Inter, sans-serif';
    Chart.defaults.font.weight = '900';

    // 1. UPDATED REVENUE TRAJECTORY (Professional SaaS Style)
    const salesTrendData = <?php echo json_encode($salesTrend); ?>;
    const salesCtx = document.getElementById('salesChart').getContext('2d');

    const fillGradient = salesCtx.createLinearGradient(0, 0, 0, 400);
    fillGradient.addColorStop(0, 'rgba(245, 158, 11, 0.2)'); 
    fillGradient.addColorStop(0.5, 'rgba(245, 158, 11, 0.05)');
    fillGradient.addColorStop(1, 'rgba(245, 158, 11, 0)');

    new Chart(salesCtx, {
        type: 'line',
        data: {
            labels: salesTrendData.map(d => d.date),
            datasets: [{
                label: 'Revenue',
                data: salesTrendData.map(d => d.total),
                borderColor: "#f59e0b", 
                borderWidth: 4,
                pointBackgroundColor: "#ffffff",
                pointBorderColor: "#f59e0b",
                pointBorderWidth: 2,
                pointRadius: 3,
                pointHoverRadius: 6,
                pointHoverBackgroundColor: "#0f172a", 
                fill: true,
                backgroundColor: fillGradient,
                tension: 0.45, 
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: { display: false },
                tooltip: {
                    backgroundColor: '#0f172a',
                    titleFont: { size: 13, weight: '900' },
                    bodyFont: { size: 12 },
                    padding: 12,
                    cornerRadius: 10,
                    callbacks: {
                        label: function(context) { return ' PKR ' + context.parsed.y.toLocaleString(); }
                    }
                }
            },
            scales: {
                x: { grid: { display: false }, ticks: { color: "#94a3b8", font: { size: 10 } } },
                y: { 
                    border: { display: false },
                    grid: { color: "rgba(226, 232, 240, 0.6)" },
                    ticks: { 
                        color: "#94a3b8", 
                        font: { size: 10 },
                        callback: v => 'PKR ' + v.toLocaleString()
                    }
                }
            }
        }
    });

    // 2. P&L Comparison Chart
    new Chart(document.getElementById('pnlComparisonChart'), {
        type: 'bar',
        data: {
            labels: ['Week 1', 'Week 2', 'Week 3', 'Week 4'],
            datasets: [
                { label: 'Sales', data: [65000, 59000, 80000, 81000], backgroundColor: '#0f172a', borderRadius: 8 },
                { label: 'Purchases', data: [40000, 48000, 40000, 19000], backgroundColor: '#f59e0b', borderRadius: 8 }
            ]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: { legend: { position: 'bottom', labels: { boxWidth: 8, font: { size: 10 } } } },
            scales: { x: { grid: { display: false } }, y: { display: false } }
        }
    });

    // 3. Category Valuation
    new Chart(document.getElementById('categoryValueChart'), {
        type: 'bar',
        data: {
            labels: ['Groc', 'Cosm', 'Elec', 'Food', 'Baby'],
            datasets: [{
                data: [120000, 190000, 30000, 50000, 20000],
                backgroundColor: '#f59e0b',
                borderRadius: 50,
                barThickness: 15
            }]
        },
        options: {
            indexAxis: 'y',
            responsive: true,
            maintainAspectRatio: false,
            plugins: { legend: { display: false } },
            scales: { x: { grid: { display: false } }, y: { grid: { display: false } } }
        }
    });

    // 4. Asset Distribution
    new Chart(document.getElementById('distributionChart'), {
        type: 'doughnut',
        data: {
            labels: ['In-Stock', 'On-Credit', 'Reserved'],
            datasets: [{
                data: [70, 20, 10],
                backgroundColor: ['#0f172a', '#f59e0b', '#cbd5e1'],
                borderWidth: 0,
                cutout: '80%'
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: { legend: { position: 'bottom', labels: { boxWidth: 8, usePointStyle: true } } }
        }
    });
</script>
<?php $__env->stopPush(); ?>
<?php echo $__env->make('layouts.main', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH E:\code_2\general-store\resources\views/pages/dashboard.blade.php ENDPATH**/ ?>