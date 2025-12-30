<script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

<style>
    /* Professional Retail Theme - Active Tab */
    .active-tab-retail {
        background-color: #f59e0b !important;
        /* Amber Accent */
        color: #0f172a !important;
        /* Dark Slate Text */
        font-weight: 800;
        border-radius: 12px;
        box-shadow: 0 10px 15px -3px rgba(245, 158, 11, 0.3);
        transform: translateX(4px);
    }

    .active-tab-retail i {
        color: #0f172a !important;
    }

    .nav-link-base {
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        position: relative;
    }

    .nav-link-base:hover:not(.active-tab-retail) {
        background-color: rgba(255, 255, 255, 0.05);
        transform: translateX(4px);
    }

    /* Modern Submenu Design */
    .submenu-glass {
        background: rgba(15, 23, 42, 0.3);
        border-radius: 12px;
        margin: 4px 8px;
        border-left: 2px solid #f59e0b;
    }

    .active-submenu-retail {
        color: #f59e0b !important;
        font-weight: 900;
        background: rgba(245, 158, 11, 0.1);
    }

    /* Custom Scrollbar */
    #sidebar::-webkit-scrollbar {
        width: 4px;
    }

    #sidebar::-webkit-scrollbar-track {
        background: transparent;
    }

    #sidebar::-webkit-scrollbar-thumb {
        background: rgba(245, 158, 11, 0.2);
        border-radius: 10px;
    }

    [x-cloak] {
        display: none !important;
    }
</style>

<div x-data="{ sidebarOpen: false }" class="relative flex">

    
    <div class="fixed top-5 left-5 z-40 md:hidden">
        <button @click="sidebarOpen = true"
            class="p-3 bg-[#0f172a] text-white rounded-xl shadow-2xl border border-slate-700">
            <i class="fas fa-bars text-xl text-[#f59e0b]"></i>
        </button>
    </div>

    
    <div x-show="sidebarOpen" x-cloak @click="sidebarOpen = false" x-transition.opacity
        class="fixed inset-0 bg-slate-900/80 z-40 md:hidden backdrop-blur-sm">
    </div>

    <aside id="sidebar" x-data="{ openReports: <?php echo e(request()->routeIs('reports*') ? 'true' : 'false'); ?> }"
        :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full md:translate-x-0'"
        class="fixed inset-y-0 left-0 w-72 bg-[#0f172a] py-8 px-4 overflow-y-auto transition-transform duration-500 ease-[cubic-bezier(0.4,0,0.2,1)] z-50 text-slate-300 font-sans md:sticky md:top-0 border-r border-slate-800 shadow-2xl">

        
        <div class="md:hidden absolute top-6 right-6">
            <button @click="sidebarOpen = false" class="text-slate-400 hover:text-white">
                <i class="fas fa-times-circle text-2xl"></i>
            </button>
        </div>

        
        <div class="mx-2 mb-10 mt-2 group">
            <div
                class="relative p-4 rounded-[1.5rem] bg-white/5 border border-white/10 backdrop-blur-md transition-all duration-500 hover:bg-white/10 hover:border-amber-500/30 overflow-hidden shadow-2xl">

                <div
                    class="absolute -right-4 -top-4 w-16 h-16 bg-amber-500/10 blur-2xl rounded-full group-hover:bg-amber-500/20 transition-all duration-500">
                </div>

                <div class="flex items-center gap-3 relative z-10">
                    <div class="relative shrink-0">
                        <div
                            class="absolute inset-0 bg-amber-500 rounded-full blur-md opacity-20 group-hover:opacity-40 animate-pulse">
                        </div>
                        <?php if(isset($siteSettings) && $siteSettings->logo): ?>
                            <img src="<?php echo e(asset('storage/' . $siteSettings->logo)); ?>"
                                class="w-12 h-12 rounded-full border-2 border-amber-500/50 object-cover shadow-lg relative z-10 transition-transform duration-500 group-hover:scale-105">
                        <?php else: ?>
                            <img src="<?php echo e(asset('assets/images/images (3).jpg')); ?>"
                                class="w-12 h-12 rounded-full border-2 border-slate-600 object-cover shadow-lg relative z-10 transition-transform duration-500 group-hover:scale-105">
                        <?php endif; ?>
                        <span
                            class="absolute bottom-0 right-0 w-3 h-3 bg-emerald-500 border-2 border-[#0f172a] rounded-full z-20"></span>
                    </div>

                    <div class="overflow-hidden">
                        <h4
                            class="font-black text-white text-sm leading-tight truncate tracking-tight uppercase italic italic group-hover:text-amber-400 transition-colors">
                            <?php echo e($siteSettings->user_name ?? 'Administrator'); ?>

                        </h4>
                        <div class="flex items-center gap-1.5 mt-1">
                            <i class="fa-solid fa-store text-[10px] text-amber-500 opacity-80"></i>
                            <p class="text-[9px] text-slate-400 font-bold uppercase tracking-widest truncate">
                                <?php echo e($siteSettings->pharmacy_name ?? 'RetailPro Store'); ?>

                            </p>
                        </div>
                    </div>
                </div>

                <div class="mt-4 h-[2px] w-full bg-white/5 rounded-full overflow-hidden">
                    <div
                        class="h-full w-1/3 bg-gradient-to-r from-amber-500 to-amber-300 group-hover:w-full transition-all duration-700">
                    </div>
                </div>
            </div>
        </div>

        <nav class="space-y-2">
            <?php
                $navClass = 'nav-link-base group flex items-center gap-4 px-4 py-3.5 text-sm font-bold uppercase tracking-wider';
                $active = 'active-tab-retail';
            ?>

            
            <a href="<?php echo e(route('dashboard')); ?>"
                class="<?php echo e($navClass); ?> <?php echo e(request()->routeIs('dashboard') ? $active : ''); ?>">
                <i class="fas fa-chart-pie text-lg w-6 text-center"></i>
                <span class="text-[11px]">Store Overview</span>
            </a>

            
            <a href="<?php echo e(route('pos')); ?>" class="<?php echo e($navClass); ?> <?php echo e(request()->routeIs('pos') ? $active : ''); ?>">
                <i class="fas fa-shopping-cart text-lg w-6 text-center"></i>
                <span class="text-[11px]">Checkout Point</span>
            </a>

            
            <a href="<?php echo e(route('medicines.index')); ?>"
                class="<?php echo e($navClass); ?> <?php echo e(request()->routeIs('medicines.index') ? $active : ''); ?>">
                <i class="fas fa-boxes-stacked text-lg w-6 text-center"></i>
                <span class="text-[11px]">Product Catalog</span>
            </a>

            
            <a href="<?php echo e(route('po.index')); ?>"
                class="<?php echo e($navClass); ?> <?php echo e(request()->routeIs('po.index') ? $active : ''); ?>">
                <i class="fas fa-file-invoice-dollar text-lg w-6 text-center"></i>
                <span class="text-[11px]">Purchase Orders</span>
            </a>

            
            <a href="<?php echo e(route('suppliers.index')); ?>"
                class="<?php echo e($navClass); ?> <?php echo e(request()->routeIs('suppliers*') ? $active : ''); ?>">
                <i class="fas fa-truck-loading text-lg w-6 text-center"></i>
                <span class="text-[11px]">Suppliers Network</span>
            </a>

            
            <a href="<?php echo e(route('customers.index')); ?>"
                class="<?php echo e($navClass); ?> <?php echo e(request()->routeIs('customers.index') ? $active : ''); ?>">
                <i class="fas fa-address-book text-lg w-6 text-center"></i>
                <span class="text-[11px]">Customer </span>
            </a>

            
            <div class="relative" x-data="{ open: <?php echo e(request()->routeIs('reports*') ? 'true' : 'false'); ?> }">
                <button @click="open = !open"
                    class="w-full <?php echo e($navClass); ?> <?php echo e(request()->routeIs('reports*') ? 'bg-slate-800/40' : ''); ?>">
                    <i class="fas fa-file-contract text-lg w-6 text-center"></i>
                    <span class="text-[11px] flex-1 text-left">Reports</span>
                    <i class="fas fa-chevron-right text-[10px] transition-transform duration-300"
                        :class="open ? 'rotate-90 text-amber-500' : ''"></i>
                </button>

                <div x-show="open" x-cloak x-transition class="submenu-glass overflow-hidden">
                    <a href="<?php echo e(route('reports.sales', ['tab' => 'sales'])); ?>"
                        class="flex items-center gap-3 px-6 py-3 text-[10px] font-black uppercase tracking-widest hover:bg-amber-500/5 <?php echo e(request('tab') == 'sales' ? 'active-submenu-retail' : 'text-slate-400'); ?>">
                        <i class="fas fa-circle text-[4px]"></i> Sales Performance
                    </a>
                    <a href="<?php echo e(route('reports.medicine')); ?>"
                        class="flex items-center gap-3 px-6 py-3 text-[10px] font-black uppercase tracking-widest hover:bg-amber-500/5 <?php echo e(request()->routeIs('reports.medicine') ? 'active-submenu-retail' : 'text-slate-400'); ?>">
                        <i class="fas fa-circle text-[4px]"></i> Stock Valuation
                    </a>
                    <a href="<?php echo e(route('reports.profit_loss')); ?>"
                        class="flex items-center gap-3 px-6 py-3 text-[10px] font-black uppercase tracking-widest hover:bg-amber-500/5 <?php echo e(request()->routeIs('reports.profit_loss') ? 'active-submenu-retail' : 'text-slate-400'); ?>">
                        <i class="fas fa-circle text-[4px]"></i> Profit & Loss
                    </a>
                </div>
            </div>

            <hr class="my-6 border-slate-800 mx-4">

            
            <a href="<?php echo e(route('settings')); ?>"
                class="<?php echo e($navClass); ?> <?php echo e(request()->routeIs('settings') ? $active : ''); ?>">
                <i class="fas fa-sliders-h text-lg w-6 text-center"></i>
                <span class="text-[11px]">Store Settings</span>
            </a>

            
            <form method="POST" action="<?php echo e(route('logout')); ?>" class="mt-4">
                <?php echo csrf_field(); ?>
                <button type="submit" class="w-full <?php echo e($navClass); ?> hover:text-red-400 transition-colors">
                    <i class="fas fa-door-open text-lg w-6 text-center"></i>
                    <span class="text-[11px]">Logout System</span>
                </button>
            </form>
        </nav>

    </aside>
</div><?php /**PATH E:\code_2\general-store\resources\views/includes/sidebar.blade.php ENDPATH**/ ?>