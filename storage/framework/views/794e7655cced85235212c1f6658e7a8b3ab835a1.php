<header id="mainHeader" class="bg-white hidden sm:flex border-b border-slate-200 px-8 py-2 justify-between items-center z-40 w-full transition-all duration-300 shadow-sm">

    
    <div class="flex items-center">
        <div class="flex flex-col">
            <h2 class="text-xl font-black text-slate-900 tracking-tighter flex items-center uppercase italic">
                <span>Control Panel</span>
            </h2>
        </div>
    </div>

    
    <div class="flex items-center gap-6 text-slate-400">
        
        
        <div class="hidden lg:flex items-center bg-slate-50 border border-slate-200 rounded-xl px-4 py-2 mr-4 group focus-within:border-store-accent transition-all">
            <i class="fa-solid fa-magnifying-glass text-xs mr-3 group-focus-within:text-store-accent"></i>
            <input type="text" placeholder="Search Terminal..." class="bg-transparent border-none outline-none text-[10px] font-bold uppercase tracking-widest w-40 placeholder:text-slate-300">
        </div>

        
        <div class="relative cursor-pointer hover:text-slate-900 transition-colors duration-200 p-2 bg-slate-50 rounded-xl border border-transparent hover:border-slate-200" title="System Alerts">
            <i class="fa-regular fa-bell text-lg"></i>
            
            <span class="absolute top-2 right-2 h-2.5 w-2.5 bg-store-accent rounded-full border-2 border-white"></span>
        </div>

        
        <div class="cursor-pointer hover:text-slate-900 transition-colors duration-200 p-2 bg-slate-50 rounded-xl border border-transparent hover:border-slate-200" title="Live Help Desk">
            <i class="fa-regular fa-circle-question text-lg"></i>
        </div>
        
        
        <div class="h-8 w-px bg-slate-200 mx-1"></div>

        
        <form method="POST" action="<?php echo e(route('logout')); ?>">
            <?php echo csrf_field(); ?>
            <button type="submit" class="flex items-center justify-center p-2.5 bg-red-50 hover:bg-red-500 text-red-500 hover:text-white rounded-xl transition-all duration-300 shadow-sm hover:shadow-red-200 group" title="Terminate Session">
                <i class="fa-solid fa-power-off text-lg"></i>
            </button>
        </form>
        
    </div>

</header><?php /**PATH E:\code_2\general-store\resources\views/includes/header.blade.php ENDPATH**/ ?>