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

    <aside id="sidebar" x-data="{ openReports: {{ request()->routeIs('reports*') ? 'true' : 'false' }} }"
        :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full md:translate-x-0'"
        class="fixed inset-y-0 left-0 w-72 bg-[#0f172a] py-8 px-4 overflow-y-auto transition-transform duration-500 ease-[cubic-bezier(0.4,0,0.2,1)] z-50 text-slate-300 font-sans md:sticky md:top-0 border-r border-slate-800 shadow-2xl">

        <div class="md:hidden absolute top-6 right-6">
            <button @click="sidebarOpen = false" class="text-slate-400 hover:text-white">
                <i class="fas fa-times-circle text-2xl"></i>
            </button>
        </div>

       <div class="mb-8 flex items-center p-3 mx-2 pr-12 md:pr-3">
            @if(isset($siteSettings) && $siteSettings->logo)
                <img src="{{ asset('storage/' . $siteSettings->logo) }}"
                    class="w-11 h-11 rounded-full mr-3 border-2 border-white shadow-md object-cover">
            @else
                <img src="{{ asset('assets/images/images (3).jpg') }}"
                    class="w-11 h-11 rounded-full mr-3 border-2 border-white shadow-md object-cover">
            @endif
            <div class="overflow-hidden">
                <p class="font-bold text-white text-md leading-tight truncate">{{ $siteSettings->user_name ?? 'User Name' }}</p>
                <p class="text-[10px] text-blue-200 font-bold uppercase tracking-wider mt-1 italic truncate">
                    {{ $siteSettings->pharmacy_name ?? 'Pharmacy Name' }}
                </p>
            </div>
        </div>

        <nav class="space-y-2">
            @php
                $navClass = 'nav-link-base group flex items-center gap-4 px-4 py-3.5 text-sm font-bold uppercase tracking-wider';
                $active = 'active-tab-retail';
            @endphp

            <a href="{{ route('dashboard') }}"
                class="{{ $navClass }} {{ request()->routeIs('dashboard') ? $active : '' }}">
                <i class="fas fa-th-large text-lg w-6 text-center"></i>
                <span class="text-[11px]">Analytics Overview</span>
            </a>

            <a href="{{ route('pos') }}" class="{{ $navClass }} {{ request()->routeIs('pos') ? $active : '' }}">
                <i class="fas fa-cash-register text-lg w-6 text-center"></i>
                <span class="text-[11px]">Billing Terminal</span>
            </a>

            <a href="{{ route('medicines.index') }}"
                class="{{ $navClass }} {{ request()->routeIs('medicines.index') ? $active : '' }}">
                <i class="fas fa-boxes text-lg w-6 text-center"></i>
                <span class="text-[11px]">Stock Inventory</span>
            </a>
{{-- 
            <a href="{{ route('sales') }}" class="{{ $navClass }} {{ request()->routeIs('sales') ? $active : '' }}">
                <i class="fas fa-file-invoice-dollar text-lg w-6 text-center"></i>
                <span class="text-[11px]">Sales History</span>
            </a> --}}

            <a href="{{ route('suppliers.index') }}"
                class="{{ $navClass }} {{ request()->routeIs('suppliers*') ? $active : '' }}">
                <i class="fas fa-truck text-lg w-6 text-center"></i>
                <span class="text-[11px]">Suppliers List</span>
            </a>

            <a href="{{ route('customers.index') }}"
                class="{{ $navClass }} {{ request()->routeIs('customers.index') ? $active : '' }}">
                <i class="fas fa-users text-lg w-6 text-center"></i>
                <span class="text-[11px]">Customer Ledger</span>
            </a>

            <div class="relative" x-data="{ open: {{ request()->routeIs('reports*') ? 'true' : 'false' }} }">
                <button @click="open = !open"
                    class="w-full {{ $navClass }} {{ request()->routeIs('reports*') ? 'bg-slate-800/40' : '' }}">
                    <i class="fas fa-chart-line text-lg w-6 text-center"></i>
                    <span class="text-[11px] flex-1 text-left">Insight Reports</span>
                    <i class="fas fa-chevron-right text-[10px] transition-transform duration-300"
                        :class="open ? 'rotate-90 text-amber-500' : ''"></i>
                </button>

                <div x-show="open" x-cloak x-transition class="submenu-glass overflow-hidden">
                    <a href="{{ route('reports.sales', ['tab' => 'sales']) }}"
                        class="flex items-center gap-3 px-6 py-3 text-[10px] font-black uppercase tracking-widest hover:bg-amber-500/5 {{ request('tab') == 'sales' ? 'active-submenu-retail' : 'text-slate-400' }}">
                        <i class="fas fa-minus text-[8px]"></i> Revenue Analysis
                    </a>
                    <a href="{{ route('reports.medicine') }}"
                        class="flex items-center gap-3 px-6 py-3 text-[10px] font-black uppercase tracking-widest hover:bg-amber-500/5 {{ request()->routeIs('reports.medicine') ? 'active-submenu-retail' : 'text-slate-400' }}">
                        <i class="fas fa-minus text-[8px]"></i> Inventory Valuation
                    </a>
                    <a href="{{ route('reports.profit_loss') }}"
                        class="flex items-center gap-3 px-6 py-3 text-[10px] font-black uppercase tracking-widest hover:bg-amber-500/5 {{ request()->routeIs('reports.profit_loss') ? 'active-submenu-retail' : 'text-slate-400' }}">
                        <i class="fas fa-minus text-[8px]"></i> Net P&L Statements
                    </a>
                </div>
            </div>

            <hr class="my-6 border-slate-800 mx-4">

            <a href="{{ route('settings') }}"
                class="{{ $navClass }} {{ request()->routeIs('settings') ? $active : '' }}">
                <i class="fas fa-cog text-lg w-6 text-center"></i>
                <span class="text-[11px]">System Config</span>
            </a>

            <form method="POST" action="{{ route('logout') }}" class="mt-4">
                @csrf
                <button type="submit" class="w-full {{ $navClass }} hover:text-red-400">
                    <i class="fas fa-power-off text-lg w-6 text-center"></i>
                    <span class="text-[11px]">Sign Out</span>
                </button>
            </form>
        </nav>

    </aside>
</div>