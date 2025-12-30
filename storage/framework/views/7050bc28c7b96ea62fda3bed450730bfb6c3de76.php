
<?php $__env->startSection('title', 'RetailPro | Sales Insights'); ?>

<?php $__env->startSection('content'); ?>
<main class="overflow-y-auto p-2 sm:p-4 md:p-8 pt-24 bg-[#f1f5f9] min-h-screen">
    <div class="max-w-7xl mx-auto">
        
        
        <div class="flex flex-col md:flex-row md:items-center justify-between mb-8 gap-4 px-2">
            <div>
                <h1 class="text-3xl md:text-4xl font-black text-slate-900 uppercase tracking-tighter italic">Sales Performance</h1>
                <p class="text-[10px] md:text-sm text-amber-600 font-bold uppercase tracking-widest flex items-center gap-2">
                    <span class="w-2 h-2 bg-amber-500 rounded-full animate-pulse"></span> 
                    Viewing: <?php echo e(\Carbon\Carbon::parse($startDate)->format('d M')); ?> — <?php echo e(\Carbon\Carbon::parse($endDate)->format('d M, Y')); ?>

                </p>
            </div>
            
            
            <form action="<?php echo e(route('reports.sales')); ?>" method="GET" class="flex flex-col sm:flex-row items-stretch sm:items-end gap-3 bg-white p-4 md:p-5 rounded-[2rem] md:rounded-3xl shadow-xl border border-slate-100 w-full md:w-auto">
                <div class="grid grid-cols-2 sm:flex gap-3">
                    <div class="group">
                        <label class="block text-[9px] font-black text-slate-400 uppercase mb-1 ml-1">From Date</label>
                        <input type="date" name="start_date" value="<?php echo e($startDate); ?>" class="w-full px-3 py-2 bg-slate-50 border-none rounded-xl text-xs outline-none ring-1 ring-slate-200 focus:ring-2 focus:ring-amber-500 font-bold text-slate-700">
                    </div>
                    <div class="group">
                        <label class="block text-[9px] font-black text-slate-400 uppercase mb-1 ml-1">To Date (Inclusive)</label>
                        <input type="date" name="end_date" value="<?php echo e($endDate); ?>" class="w-full px-3 py-2 bg-slate-50 border-none rounded-xl text-xs outline-none ring-1 ring-slate-200 focus:ring-2 focus:ring-amber-500 font-bold text-slate-700">
                    </div>
                </div>
                <div class="flex gap-2">
                    <select name="status" class="flex-1 px-3 py-2 bg-slate-50 border-none rounded-xl text-xs outline-none ring-1 ring-slate-200 focus:ring-2 focus:ring-amber-500 font-bold text-slate-700">
                        <option value="">All Payments</option>
                        <option value="Completed" <?php echo e(request('status') == 'Completed' ? 'selected' : ''); ?>>Cleared</option>
                        <option value="Partial" <?php echo e(request('status') == 'Partial' ? 'selected' : ''); ?>>Outstanding</option>
                    </select>
                    <button type="submit" class="bg-[#0f172a] text-[#f59e0b] px-5 py-2 rounded-xl font-black text-xs hover:bg-slate-800 transition-all active:scale-95 flex items-center gap-2 shadow-lg">
                        <i class="fa-solid fa-filter text-[10px]"></i> <span>Filter</span>
                    </button>
                </div>
            </form>
        </div>

        
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 md:gap-6 mb-10 px-2">
            <?php
                $cards = [
                    ['Total Revenue', 'PKR '.number_format($totalRevenue, 0), 'fa-coins', 'amber'],
                    ['Low Stock', 'PKR '.number_format($lowStockCount, 0), 'fa-wallet', 'slate'],
                    ['Credit Sales', 'PKR '.number_format($remainingDebt, 0), 'fa-file-invoice-dollar', 'red'],
                    ['Orders Count', $totalSalesCount, 'fa-shopping-bag', 'emerald'],
                ];
            ?>

            <?php $__currentLoopData = $cards; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $card): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <div class="bg-white p-6 rounded-[2rem] shadow-lg border border-slate-50 relative overflow-hidden group">
                <div class="absolute -right-4 -top-4 w-20 h-20 bg-<?php echo e($card[3] == 'slate' ? 'slate-900' : ($card[3] == 'amber' ? 'amber-500' : $card[3].'-500')); ?> rounded-full opacity-5"></div>
                <p class="text-[9px] font-black text-slate-400 uppercase tracking-widest relative z-10"><?php echo e($card[0]); ?></p>
                <h2 class="text-xl md:text-2xl font-black text-slate-900 mt-1 relative z-10 tracking-tighter italic leading-none"><?php echo e($card[1]); ?></h2>
                <div class="mt-4 flex items-center justify-between relative z-10">
                    <span class="text-[8px] font-black text-<?php echo e($card[3] == 'slate' ? 'slate-900' : ($card[3] == 'amber' ? 'amber-600' : $card[3].'-600')); ?> bg-<?php echo e($card[3] == 'slate' ? 'slate-100' : ($card[3] == 'amber' ? 'amber-50' : $card[3].'-50')); ?> px-2 py-1 rounded-lg uppercase">Selected Period</span>
                    <i class="fa-solid <?php echo e($card[2]); ?> text-<?php echo e($card[3] == 'amber' ? 'amber-500' : ($card[3] == 'slate' ? 'slate-900' : $card[3].'-500')); ?> opacity-20 text-xl"></i>
                </div>
            </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>

        
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-10 px-2">
            
            <div class="lg:col-span-2 bg-white p-6 md:p-8 rounded-[2.5rem] shadow-xl border border-slate-50 h-[400px]">
                <div class="flex items-center justify-between mb-6">
                    <h3 class="font-black text-slate-800 uppercase italic tracking-tighter text-sm md:text-base border-l-4 border-amber-500 pl-3">Daily Sales Trend</h3>
                    <span class="text-[9px] font-black text-slate-400 bg-slate-100 px-3 py-1 rounded-full uppercase italic">Period Analytics</span>
                </div>
                <div class="h-[280px]">
                    <canvas id="revenueChart"></canvas>
                </div>
            </div>

            
            <div class="bg-white p-6 md:p-8 rounded-[2.5rem] shadow-xl border border-slate-50 h-[400px]">
                <h3 class="font-black text-slate-800 uppercase italic tracking-tighter mb-6 text-sm md:text-base border-l-4 border-[#0f172a] pl-3">Payment Split</h3>
                <div class="h-[250px] flex items-center justify-center">
                    <canvas id="statusChart"></canvas>
                </div>
            </div>
        </div>

        
        <div class="bg-white rounded-[2.5rem] shadow-2xl border border-slate-100 overflow-hidden mb-10 mx-2">
            <div class="p-6 md:p-8 border-b border-slate-50 flex justify-between items-center bg-white">
                <div>
                    <h3 class="font-black text-slate-900 uppercase italic text-lg md:text-xl tracking-tighter leading-none">Detailed Transaction Journal</h3>
                    <p class="text-[10px] text-slate-400 font-bold uppercase mt-1 tracking-widest leading-none">Inclusive of <?php echo e($startDate); ?> to <?php echo e($endDate); ?></p>
                </div>
            </div>

            
            <div class="hidden lg:block overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-[#0f172a] text-white font-black uppercase text-[10px] tracking-widest italic">
                            <th class="p-6">Date</th>
                            <th class="p-6">Invoice #</th>
                            <th class="p-6">Customer</th>
                            <th class="p-6 text-right">Bill Amount</th>
                            <th class="p-6 text-center">Payment Status</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-50">
                        <?php $__empty_1 = true; $__currentLoopData = $sales; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $sale): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                        <tr class="hover:bg-slate-50/80 transition duration-300">
                            <td class="p-6 font-black text-slate-800 text-sm italic"><?php echo e(\Carbon\Carbon::parse($sale->sale_date)->format('d M, Y')); ?></td>
                            <td class="p-6"><span class="bg-slate-100 text-slate-800 px-3 py-1.5 rounded-xl text-[10px] font-black border border-slate-200 uppercase">#<?php echo e($sale->invoice_number); ?></span></td>
                            <td class="p-6 font-bold text-slate-600 text-sm uppercase tracking-tight"><?php echo e($sale->customer->customer_name ?? 'Cash Customer'); ?></td>
                            <td class="p-6 text-right font-black text-slate-900 italic tracking-tight">PKR <?php echo e(number_format($sale->total_amount, 2)); ?></td>
                            <td class="p-6 text-center">
                                <span class="text-[9px] font-black uppercase <?php echo e($sale->status == 'Completed' ? 'text-emerald-600 bg-emerald-50 border-emerald-100' : 'text-amber-600 bg-amber-50 border-amber-100'); ?> px-4 py-1.5 rounded-full border italic">
                                    <?php echo e($sale->status == 'Completed' ? 'Cleared' : 'Due'); ?>

                                </span>
                            </td>
                        </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                        <tr><td colspan="5" class="p-20 text-center text-slate-300 font-black uppercase italic tracking-widest text-xs">No Recent Sales Found for selected dates</td></tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>

            
            <div class="lg:hidden p-4 space-y-4">
                <?php $__currentLoopData = $sales; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $sale): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <div class="bg-slate-50/50 p-5 rounded-3xl border border-slate-100">
                    <div class="flex justify-between items-start mb-3">
                        <div>
                            <span class="text-[9px] font-black text-slate-400 uppercase block leading-none mb-1"><?php echo e(\Carbon\Carbon::parse($sale->sale_date)->format('d M, Y')); ?></span>
                            <h4 class="text-sm font-black text-slate-900 uppercase italic">#<?php echo e($sale->invoice_number); ?></h4>
                        </div>
                        <span class="text-[8px] font-black uppercase <?php echo e($sale->status == 'Completed' ? 'text-emerald-600 bg-emerald-50' : 'text-amber-600 bg-amber-50'); ?> px-3 py-1 rounded-full border border-current italic">
                            <?php echo e($sale->status == 'Completed' ? 'Cleared' : 'Due'); ?>

                        </span>
                    </div>
                    <div class="flex justify-between items-end border-t border-slate-200 pt-3 mt-1">
                        <div class="text-[10px] font-bold text-slate-500 uppercase"><?php echo e($sale->customer->customer_name ?? 'Cash Customer'); ?></div>
                        <div class="text-base font-black text-slate-900 italic tracking-tighter">PKR <?php echo e(number_format($sale->total_amount, 0)); ?></div>
                    </div>
                </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
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

    // 1. Revenue Flow Chart
    const ctxLine = document.getElementById('revenueChart').getContext('2d');
    new Chart(ctxLine, {
        type: 'line',
        data: {
            labels: <?php echo json_encode($chartData->keys()); ?>,
            datasets: [{
                data: <?php echo json_encode($chartData->values()); ?>,
                borderColor: '#f59e0b',
                backgroundColor: (context) => {
                    const ctx = context.chart.ctx;
                    const gradient = ctx.createLinearGradient(0, 0, 0, 300);
                    gradient.addColorStop(0, 'rgba(245, 158, 11, 0.2)');
                    gradient.addColorStop(1, 'rgba(245, 158, 11, 0)');
                    return gradient;
                },
                borderWidth: 4,
                fill: true,
                tension: 0.4,
                pointRadius: 4,
                pointBackgroundColor: '#fff',
                pointBorderColor: '#f59e0b',
                pointBorderWidth: 2
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: { 
                legend: { display: false },
                tooltip: {
                    backgroundColor: '#0f172a',
                    padding: 12,
                    titleFont: { size: 12, weight: 'bold' },
                    bodyFont: { size: 14, weight: 'black' },
                    callbacks: {
                        label: (item) => ` PKR ${item.formattedValue}`
                    }
                }
            },
            scales: {
                y: { beginAtZero: true, grid: { color: '#f1f5f9' }, ticks: { color: '#64748b', font: { size: 9 } } },
                x: { grid: { display: false }, ticks: { color: '#64748b', font: { size: 9 } } }
            }
        }
    });

    // 2. Payment Distribution Chart
    const ctxPie = document.getElementById('statusChart').getContext('2d');
    new Chart(ctxPie, {
        type: 'doughnut',
        data: {
            labels: ['Cleared Payments', 'Outstanding Bills'],
            datasets: [{
                data: [
                    <?php echo e($sales->where('status', 'Completed')->count()); ?>, 
                    <?php echo e($sales->where('status', 'Partial')->count()); ?>

                ],
                backgroundColor: ['#0f172a', '#f59e0b'],
                borderWidth: 5,
                borderColor: '#fff',
                hoverOffset: 15
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            cutout: '75%',
            plugins: {
                legend: { 
                    position: 'bottom', 
                    labels: { usePointStyle: true, padding: 20, font: { size: 10, weight: '900' }, color: '#0f172a' } 
                }
            }
        }
    });
</script>
<?php $__env->stopPush(); ?>
<?php echo $__env->make('layouts.main', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH E:\code_2\general-store\resources\views/pages/reports/sales.blade.php ENDPATH**/ ?>