<div class="md:hidden">
    <div class="h-28"></div>

    <nav class="fixed bottom-4 left-4 right-4 z-[100] bg-[#0f172a]/95 backdrop-blur-xl border border-slate-700 rounded-[2rem] shadow-[0_20px_50px_rgba(0,0,0,0.5)] h-16 px-2 flex items-center justify-around transition-all duration-300">
        
        <?php
            $linkStyle = "flex flex-col items-center justify-center h-full w-full transition-all duration-300 relative group";
            $iconBase = "fas mb-1 transition-all duration-300 group-active:scale-75"; // Changed to 'fas' for Free solid icons
            $labelStyle = "text-[9px] font-black uppercase tracking-tighter opacity-80 group-active:opacity-100";
            $activeClass = "text-amber-500";
            $inactiveClass = "text-slate-400";
        ?>

        <a href="<?php echo e(route('dashboard')); ?>" class="<?php echo e($linkStyle); ?> <?php echo e(request()->routeIs('dashboard') ? $activeClass : $inactiveClass); ?>">
            <?php if(request()->routeIs('dashboard')): ?>
                <div class="absolute inset-0 self-center m-auto w-10 h-10 bg-amber-500/10 blur-xl rounded-full"></div>
            <?php endif; ?>
            <i class="fa-solid fa-house <?php echo e($iconBase); ?>"></i>
            <span class="<?php echo e($labelStyle); ?>">Home</span>
        </a>

        <a href="<?php echo e(route('medicines.index')); ?>" class="<?php echo e($linkStyle); ?> <?php echo e(request()->routeIs('medicines.index') ? $activeClass : $inactiveClass); ?>">
            <?php if(request()->routeIs('medicines.index')): ?>
                <div class="absolute inset-0 self-center m-auto w-10 h-10 bg-amber-500/10 blur-xl rounded-full"></div>
            <?php endif; ?>
            <i class="fa-solid fa-boxes-stacked <?php echo e($iconBase); ?>"></i>
            <span class="<?php echo e($labelStyle); ?>">Stock</span>
        </a>

        <div class="relative flex flex-col items-center justify-center w-full">
            <a href="<?php echo e(route('pos')); ?>" 
               class="flex items-center justify-center w-14 h-14 -mt-12 bg-gradient-to-tr from-amber-600 to-amber-400 text-[#0f172a] rounded-2xl shadow-[0_10px_25px_rgba(245,158,11,0.4)] border-[5px] border-[#0c1322] active:scale-90 transition-all duration-200">
                <i class="fa-solid fa-cash-register text-xl"></i>
            </a>
            <span class="mt-2 text-[10px] font-black uppercase text-amber-500 tracking-widest italic">Bill</span>
        </div>

        <a href="<?php echo e(route('customers.index')); ?>" class="<?php echo e($linkStyle); ?> <?php echo e(request()->routeIs('customers.index') ? $activeClass : $inactiveClass); ?>">
            <?php if(request()->routeIs('customers.index')): ?>
                <div class="absolute inset-0 self-center m-auto w-10 h-10 bg-amber-500/10 blur-xl rounded-full"></div>
            <?php endif; ?>
            <i class="fa-solid fa-users <?php echo e($iconBase); ?>"></i>
            <span class="<?php echo e($labelStyle); ?>">Ledger</span>
        </a>

        <a href="<?php echo e(route('settings')); ?>" class="<?php echo e($linkStyle); ?> <?php echo e(request()->routeIs('settings') ? $activeClass : $inactiveClass); ?>">
            <?php if(request()->routeIs('settings')): ?>
                <div class="absolute inset-0 self-center m-auto w-10 h-10 bg-amber-500/10 blur-xl rounded-full"></div>
            <?php endif; ?>
            <i class="fa-solid fa-gears <?php echo e($iconBase); ?>"></i>
            <span class="<?php echo e($labelStyle); ?>">Setup</span>
        </a>

    </nav>
</div>

<style>
    /* Prevent user selection and long-press highlights on mobile */
    nav a {
        -webkit-tap-highlight-color: transparent;
        user-select: none;
    }
</style><?php /**PATH E:\code_2\general-store\resources\views/includes/mobile-nav.blade.php ENDPATH**/ ?>