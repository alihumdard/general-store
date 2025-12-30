
<?php $__env->startSection('title', 'RetailPro | Stock Analytics'); ?>

<?php $__env->startSection('content'); ?>
<main class="overflow-y-auto p-2 sm:p-4 md:p-8 pt-24 bg-[#f1f5f9] min-h-screen">
    <div class="max-w-[1600px] mx-auto w-full">
        
        
        <div class="flex flex-col md:flex-row md:items-center justify-between mb-8 gap-4 px-2">
            <div>
                <h1 class="text-3xl font-black text-slate-900 uppercase tracking-tighter italic">Stock Analytics</h1>
                <p class="text-[10px] md:text-sm text-amber-600 font-bold uppercase tracking-widest flex items-center gap-2">
                    <span class="w-2 h-2 bg-amber-500 rounded-full animate-pulse"></span> Inventory Value & Health Reports
                </p>
            </div>
            
            
            <form action="<?php echo e(route('reports.medicine')); ?>" method="GET" class="flex flex-col sm:flex-row items-stretch sm:items-end gap-3 bg-white p-4 md:p-5 rounded-[2rem] md:rounded-3xl shadow-xl border border-slate-100 w-full md:w-auto">
                <div class="group flex-grow">
                    <label class="block text-[9px] font-black text-slate-400 uppercase mb-1 ml-1">Inventory Status</label>
                    <select name="stock_status" class="w-full px-4 py-2.5 bg-slate-50 border-none rounded-xl text-xs font-bold outline-none ring-1 ring-slate-200 focus:ring-2 focus:ring-amber-500 transition-all">
                        <option value="">All Products</option>
                        <option value="low" <?php echo e(request('stock_status') == 'low' ? 'selected' : ''); ?>>Low Stock Items</option>
                        <option value="out" <?php echo e(request('stock_status') == 'out' ? 'selected' : ''); ?>>Out of Stock</option>
                        <option value="expired" <?php echo e(request('stock_status') == 'expired' ? 'selected' : ''); ?>>Expired Stock</option>
                    </select>
                </div>
                <button type="submit" class="bg-[#0f172a] text-[#f59e0b] px-6 py-2.5 rounded-xl font-black text-xs hover:bg-slate-800 transition-all active:scale-95 flex items-center justify-center gap-2 shadow-lg">
                    <i class="fa-solid fa-arrows-rotate text-[10px]"></i> Sync Report
                </button>
            </form>
        </div>

        
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 md:gap-6 mb-10 px-2">
            <?php
                $summary = [
                    ['Total Stock Value', 'PKR '.number_format($totalStockValue, 0), 'fa-boxes-stacked', 'slate'],
                    ['Est. Sale Revenue', 'PKR '.number_format($potentialRevenue, 0), 'fa-cash-register', 'amber'],
                    ['Needs Restocking', $lowStockCount, 'fa-cart-arrow-down', 'orange'],
                    ['Dead Stock (Expired)', $expiredCount, 'fa-calendar-xmark', 'red'],
                ];
            ?>
            <?php $__currentLoopData = $summary; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $card): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <div class="bg-white p-6 rounded-[2rem] shadow-lg border border-slate-50 relative overflow-hidden group">
                <div class="absolute -right-4 -top-4 w-20 h-20 bg-<?php echo e($card[3] == 'slate' ? 'slate-900' : ($card[3] == 'amber' ? 'amber-500' : $card[3].'-500')); ?> rounded-full opacity-5"></div>
                <p class="text-[9px] font-black text-slate-400 uppercase tracking-widest relative z-10"><?php echo e($card[0]); ?></p>
                <h2 class="text-xl md:text-2xl font-black text-slate-900 mt-1 relative z-10 tracking-tighter italic leading-none"><?php echo e($card[1]); ?></h2>
                <div class="mt-4 flex items-center justify-between relative z-10">
                    <span class="text-[8px] font-black text-<?php echo e($card[3] == 'slate' ? 'slate-900' : ($card[3] == 'amber' ? 'amber-600' : $card[3].'-600')); ?> bg-<?php echo e($card[3] == 'slate' ? 'slate-100' : ($card[3] == 'amber' ? 'amber-50' : $card[3].'-50')); ?> px-2 py-1 rounded-lg uppercase">System Count</span>
                    <i class="fa-solid <?php echo e($card[2]); ?> text-<?php echo e($card[3] == 'amber' ? 'amber-500' : ($card[3] == 'slate' ? 'slate-900' : $card[3].'-500')); ?> opacity-20 text-xl"></i>
                </div>
            </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>

        
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-10 px-2">
            <div class="lg:col-span-2 bg-white p-6 md:p-8 rounded-[2.5rem] shadow-xl border border-slate-50 h-[400px]">
                <div class="flex items-center justify-between mb-6">
                    <h3 class="font-black text-slate-800 uppercase italic tracking-tighter text-sm md:text-base border-l-4 border-amber-500 pl-3">Top Valued Products</h3>
                    <span class="text-[9px] font-black text-slate-400 bg-slate-100 px-3 py-1 rounded-full uppercase">Stock Worth</span>
                </div>
                <div class="h-[280px]">
                    <canvas id="valuationChart"></canvas>
                </div>
            </div>

            <div class="bg-white p-6 md:p-8 rounded-[2.5rem] shadow-xl border border-slate-50 h-[400px]">
                <h3 class="font-black text-slate-800 uppercase italic tracking-tighter mb-6 text-sm md:text-base border-l-4 border-[#0f172a] pl-3">Stock Health Status</h3>
                <div class="h-[250px] flex items-center justify-center">
                    <canvas id="healthChart"></canvas>
                </div>
            </div>
        </div>

        
        <div class="bg-white rounded-[2.5rem] shadow-2xl border border-slate-100 overflow-hidden mb-10 mx-2">
            <div class="p-6 md:p-8 border-b border-slate-50">
                <h3 class="font-black text-slate-900 uppercase italic text-lg md:text-xl tracking-tighter leading-none">Stock Audit Sheet</h3>
                <p class="text-[10px] text-slate-400 font-bold uppercase mt-1 tracking-widest leading-none">Complete Inventory Manifest Tracking</p>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-[#0f172a] text-white font-black uppercase text-[10px] tracking-widest italic border-b border-slate-800">
                            <th class="p-6">Product & SKU</th>
                            <th class="p-6">Batch / Expiry</th>
                            <th class="p-6 text-center">Available Stock</th>
                            <th class="p-6 text-right">Cost Price</th>
                            <th class="p-6 text-right">Total Worth</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-50">
                        <?php $__empty_1 = true; $__currentLoopData = $variants; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $variant): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                        <tr class="hover:bg-slate-50/80 transition duration-300">
                            <td class="p-6">
                                <div class="flex flex-col">
                                    <span class="text-sm font-black text-slate-800 uppercase italic"><?php echo e($variant->medicine->name); ?></span>
                                    <span class="text-[10px] text-amber-600 font-bold uppercase tracking-widest">#<?php echo e($variant->sku); ?></span>
                                </div>
                            </td>
                            <td class="p-6">
                                <div class="flex flex-col">
                                    <span class="text-[10px] font-bold text-slate-500 uppercase">Batch: <?php echo e($variant->batch_no ?? 'N/A'); ?></span>
                                    <span class="text-[10px] <?php echo e(optional($variant->expiry_date)->isPast() ? 'text-red-500 font-black' : 'text-slate-400'); ?> uppercase">
                                        Exp: <?php echo e(optional($variant->expiry_date)->format('d M, Y') ?? 'N/A'); ?>

                                    </span>
                                </div>
                            </td>
                            <td class="p-6 text-center">
                                <span class="px-4 py-1.5 rounded-xl text-xs font-black ring-1 <?php echo e($variant->stock_level <= $variant->reorder_level ? 'bg-red-50 text-red-600 ring-red-100' : 'bg-emerald-50 text-emerald-600 ring-emerald-100'); ?> italic">
                                    <?php echo e($variant->stock_level); ?> Items
                                </span>
                            </td>
                            <td class="p-6 text-right text-xs font-black text-slate-500 italic">PKR <?php echo e(number_format($variant->purchase_price, 2)); ?></td>
                            <td class="p-6 text-right font-black text-slate-900 italic tracking-tighter">PKR <?php echo e(number_format($variant->stock_level * $variant->purchase_price, 2)); ?></td>
                        </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                        <tr><td colspan="5" class="p-20 text-center text-slate-300 font-black uppercase tracking-widest text-xs italic">No Stock Data Found</td></tr>
                        <?php endif; ?>
                    </tbody>
                </table>
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

    // 1. Top Valued Products (Bar Chart)
    const ctxBar = document.getElementById('valuationChart').getContext('2d');
    new Chart(ctxBar, {
        type: 'bar',
        data: {
            labels: <?php echo json_encode($variants->sortByDesc(fn($v) => $v->stock_level * $v->purchase_price)->take(10)->map(fn($v) => $v->medicine->name)->values()); ?>,
            datasets: [{
                data: <?php echo json_encode($variants->sortByDesc(fn($v) => $v->stock_level * $v->purchase_price)->take(10)->map(fn($v) => $v->stock_level * $v->purchase_price)->values()); ?>,
                backgroundColor: '#f59e0b',
                hoverBackgroundColor: '#0f172a',
                borderRadius: 12,
                barThickness: 20
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: { legend: { display: false } },
            scales: {
                y: { beginAtZero: true, grid: { color: '#f1f5f9' }, ticks: { color: '#64748b', font: { size: 9 } } },
                x: { grid: { display: false }, ticks: { color: '#64748b', font: { size: 8 } } }
            }
        }
    });

    // 2. Stock Health Protocol (Doughnut Chart)
    const ctxDoughnut = document.getElementById('healthChart').getContext('2d');
    new Chart(ctxDoughnut, {
        type: 'doughnut',
        data: {
            labels: ['Healthy Stock', 'Low Stock', 'Expired'],
            datasets: [{
                data: [
                    <?php echo e($variants->where('stock_level', '>', 5)->where('expiry_date', '>', now())->count()); ?>, 
                    <?php echo e($lowStockCount); ?>, 
                    <?php echo e($expiredCount); ?>

                ],
                backgroundColor: ['#0f172a', '#f59e0b', '#ef4444'],
                borderWidth: 5,
                borderColor: '#fff',
                hoverOffset: 15
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            cutout: '70%',
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
<?php echo $__env->make('layouts.main', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH E:\code_2\general-store\resources\views/pages/reports/medicine.blade.php ENDPATH**/ ?>