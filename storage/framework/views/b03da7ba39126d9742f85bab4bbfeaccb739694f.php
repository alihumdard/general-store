
<?php $__env->startSection('title', 'RetailPro | Store Settings'); ?>

<?php $__env->startSection('content'); ?>
<main class="overflow-y-auto p-4 md:p-8 min-h-[calc(100vh-70px)] pt-24 bg-[#f1f5f9]">

    <div class="max-w-[1600px] mx-auto w-full">
        
        <h1 class="text-3xl font-black text-slate-900 mb-6 border-b border-slate-200 pb-10 pt-3 uppercase tracking-tighter italic">Store Configuration & Control</h1>

        <div class="bg-white rounded-3xl shadow-xl border border-slate-100 p-4 md:p-8">

            <div class="border-b border-slate-100 flex flex-wrap items-center gap-6 text-slate-400 text-sm font-black mb-8 uppercase tracking-widest">
                
                <button data-tab="general" class="tab-button active-tab pb-4 border-b-2 border-amber-500 text-slate-900 transition duration-200 flex items-center gap-2">
                    <i class="fa-solid fa-store text-amber-500"></i> Store Terminal
                </button>
                <button data-tab="currency_tax" class="tab-button pb-4 border-b-2 border-transparent hover:text-slate-600 transition duration-200 flex items-center gap-2">
                    <i class="fa-solid fa-file-invoice-dollar"></i> Finance Rules
                </button>
                <button data-tab="user_roles" class="tab-button pb-4 border-b-2 border-transparent hover:text-slate-600 transition duration-200 flex items-center gap-2">
                    <i class="fa-solid fa-user-shield"></i> Access Control
                </button>
                <button data-tab="backup" class="tab-button pb-4 border-b-2 border-transparent hover:text-slate-600 transition duration-200 flex items-center gap-2">
                    <i class="fa-solid fa-server"></i> Cloud Sync
                </button>
            </div>

            <div id="settingsContent" class="py-4">
                
                
                <form action="<?php echo e(route('settings.update.general')); ?>" method="POST" enctype="multipart/form-data">
                    <?php echo csrf_field(); ?>
                    <div data-content="general" class="tab-content active-content">
                        <h3 class="text-lg font-black text-slate-800 mb-8 uppercase tracking-tighter italic flex items-center gap-3">
                            <span class="w-1.5 h-6 bg-amber-500 rounded-full"></span>
                            Store Identity & Metadata
                        </h3>
                        
                        <div class="flex flex-col lg:flex-row gap-12">
                            
                            <div class="w-full lg:w-1/3 flex flex-col items-center text-center">
                                <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-6">Store Logo / Branding</label>
                                <div class="relative group">
                                    <div class="absolute inset-0 bg-amber-500 rounded-[2.5rem] rotate-3 group-hover:rotate-0 transition-transform duration-300 opacity-20"></div>
                                    <img id="logoPreview" 
                                         src="<?php echo e(($settings && $settings->logo) ? asset('storage/'.$settings->logo) : asset('assets/images/images (3).jpg')); ?>" 
                                         class="w-52 h-52 rounded-[2.5rem] object-cover border-4 border-white shadow-2xl relative z-10 transition group-hover:opacity-90">
                                    <input type="file" name="logo" onchange="previewImage(this)" class="absolute inset-0 opacity-0 cursor-pointer z-20">
                                </div>
                                <p class="text-[9px] font-bold text-amber-600 mt-6 uppercase tracking-widest animate-bounce">Select File to Update</p>
                            </div>

                            <div class="flex-1 grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div class="space-y-1">
                                    <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest ml-1">Business Name *</label>
                                    <input type="text" name="pharmacy_name" value="<?php echo e($settings->pharmacy_name ?? ''); ?>" required
                                        class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-2xl font-bold text-sm outline-none focus:ring-4 focus:ring-amber-500/10 focus:border-amber-500 transition">
                                </div>
                                <div class="space-y-1">
                                    <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest ml-1">Admin Username *</label>
                                    <input type="text" name="user_name" value="<?php echo e($settings->user_name ?? ''); ?>" required
                                        class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-2xl font-bold text-sm outline-none focus:ring-4 focus:ring-amber-500/10 focus:border-amber-500 transition">
                                </div>
                                <div class="space-y-1">
                                    <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest ml-1">Store Helpline</label>
                                    <input type="text" name="phone_number" value="<?php echo e($settings->phone_number ?? ''); ?>" placeholder="+92 XXX XXXXXXX"
                                        class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-2xl font-bold text-sm outline-none focus:ring-4 focus:ring-amber-500/10 focus:border-amber-500 transition">
                                </div>
                                <div class="space-y-1">
                                    <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest ml-1">Business Email</label>
                                    <input type="email" name="email" value="<?php echo e($settings->email ?? ''); ?>" placeholder="info@store.com"
                                        class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-2xl font-bold text-sm outline-none focus:ring-4 focus:ring-amber-500/10 focus:border-amber-500 transition">
                                </div>
                                <div class="space-y-1">
                                    <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest ml-1">Registration / Tax ID</label>
                                    <input type="text" name="tax_id" value="<?php echo e($settings->tax_id ?? ''); ?>" placeholder="GST-XXXXXX"
                                        class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-2xl font-bold text-sm outline-none focus:ring-4 focus:ring-amber-500/10 focus:border-amber-500 transition">
                                </div>
                                <div class="md:col-span-2 space-y-1">
                                    <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest ml-1">Store Address</label>
                                    <textarea name="address" rows="3" placeholder="Locality, City..."
                                        class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-2xl font-bold text-sm outline-none focus:ring-4 focus:ring-amber-500/10 focus:border-amber-500 transition resize-none shadow-inner"><?php echo e($settings->address ?? ''); ?></textarea>
                                </div>
                            </div>
                        </div>
                        
                        <div class="pt-10 border-t border-slate-100 mt-10 flex justify-end">
                            <button type="submit" class="px-10 py-4 bg-[#0f172a] text-[#f59e0b] rounded-2xl shadow-xl font-black uppercase text-xs tracking-widest hover:bg-slate-800 transition active:scale-95">
                                <i class="fa-solid fa-check-double mr-2"></i> Save Changes
                            </button>
                        </div>
                    </div>
                </form>

                
                <div data-content="currency_tax" class="tab-content hidden">
                    <h3 class="text-lg font-black text-slate-800 mb-8 uppercase tracking-tighter italic border-l-4 border-amber-500 pl-3">Financial Protocols</h3>
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                        <div class="space-y-1">
                            <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest ml-1">Store Currency</label>
                            <input type="text" value="<?php echo e($settings->currency ?? 'PKR'); ?>" class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-2xl font-black text-amber-600 outline-none shadow-sm">
                        </div>
                        <div class="space-y-1">
                            <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest ml-1">Flat Tax Rate (GST)</label>
                            <div class="relative">
                                <input type="number" value="<?php echo e($settings->tax_rate ?? '17'); ?>" class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-2xl font-black text-slate-800 outline-none shadow-sm">
                                <span class="absolute right-5 top-1/2 -translate-y-1/2 text-slate-400 font-black text-xs">%</span>
                            </div>
                        </div>
                    </div>
                </div>
                
                
                <div data-content="user_roles" class="tab-content hidden">
                    <div class="flex flex-col lg:flex-row gap-8">
                        <div class="w-full lg:w-72 space-y-3">
                            <h4 class="font-black text-slate-400 mb-4 uppercase tracking-widest text-[10px] ml-1">Staff Hierarchy</h4>
                            <button data-role="admin" class="role-selector w-full text-left px-5 py-4 rounded-2xl hover:bg-slate-50 transition duration-200 text-slate-700 font-black text-[11px] uppercase tracking-widest border border-slate-100">Super Admin</button>
                            <button data-role="manager" class="role-selector active-role w-full text-left px-5 py-4 rounded-2xl bg-amber-50 text-amber-600 border border-amber-200 transition duration-200 font-black text-[11px] uppercase tracking-widest">Floor Manager</button>
                            <button data-role="cashier" class="role-selector w-full text-left px-5 py-4 rounded-2xl hover:bg-slate-50 transition duration-200 text-slate-700 font-black text-[11px] uppercase tracking-widest border border-slate-100">Point of Sale User</button>
                        </div>
                        <div class="flex-1 bg-[#f8fafc] rounded-[2rem] p-8 border border-slate-200 shadow-inner">
                            <h4 class="text-lg font-black text-slate-900 mb-6 uppercase tracking-tighter italic">Privileges: <span id="activeRoleName" class="text-amber-500">Manager</span></h4>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <label class="flex items-center gap-3 p-4 bg-white rounded-2xl shadow-sm border border-slate-100 hover:border-amber-200 transition cursor-pointer">
                                    <input type="checkbox" class="w-5 h-5 rounded border-slate-300 text-amber-500 focus:ring-amber-500" checked>
                                    <span class="text-xs font-black text-slate-700 uppercase tracking-widest">Inventory Control</span>
                                </label>
                                <label class="flex items-center gap-3 p-4 bg-white rounded-2xl shadow-sm border border-slate-100 hover:border-amber-200 transition cursor-pointer">
                                    <input type="checkbox" class="w-5 h-5 rounded border-slate-300 text-amber-500 focus:ring-amber-500" checked>
                                    <span class="text-xs font-black text-slate-700 uppercase tracking-widest">Sales Ledger View</span>
                                </label>
                            </div>
                        </div>
                    </div>
                </div>

                
                <div data-content="backup" class="tab-content hidden">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-8 items-center bg-[#0f172a] p-12 rounded-[2.5rem] shadow-2xl">
                        <div>
                            <p class="text-[10px] font-black text-amber-500 uppercase tracking-widest mb-2 italic flex items-center gap-2">
                                <span class="w-2 h-2 bg-emerald-500 rounded-full animate-pulse"></span>
                                Cloud Encryption Active
                            </p>
                            <h4 class="text-white text-2xl font-black uppercase tracking-tighter leading-tight italic">Inventory Data Vault is Secure.</h4>
                            <p class="text-slate-500 text-xs mt-4 font-bold uppercase tracking-widest">Status Update: <span class="text-slate-200"><?php echo e(now()->format('d M Y | h:i A')); ?></span></p>
                        </div>
                        <div class="flex md:justify-end">
                            <button class="px-8 py-4 bg-amber-500 hover:bg-amber-600 text-[#0f172a] rounded-2xl shadow-xl font-black uppercase text-xs tracking-widest transition active:scale-95 flex items-center gap-3">
                                <i class="fa-solid fa-sync fa-spin-hover"></i> Force Manual Sync
                            </button>
                        </div>
                    </div>
                </div>
                
            </div>

        </div>
    </div>
</main>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('scripts'); ?>
<script>
    // Image Preview Logic 
    function previewImage(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            reader.onload = function(e) {
                document.getElementById('logoPreview').src = e.target.result;
            }
            reader.readAsDataURL(input.files[0]);
        }
    }

    document.addEventListener('DOMContentLoaded', () => {
        const tabButtons = document.querySelectorAll('.tab-button');
        const tabContents = document.querySelectorAll('.tab-content');
        const roleSelectors = document.querySelectorAll('.role-selector');
        const activeRoleName = document.getElementById('activeRoleName');

        function switchTab(tabName) {
            tabButtons.forEach(btn => {
                const isActive = btn.dataset.tab === tabName;
                btn.classList.toggle('text-slate-900', isActive);
                btn.classList.toggle('border-amber-500', isActive);
                btn.classList.toggle('border-transparent', !isActive);
                btn.classList.toggle('text-slate-400', !isActive);
            });

            tabContents.forEach(content => {
                content.classList.toggle('hidden', content.dataset.content !== tabName);
            });
        }

        tabButtons.forEach(button => {
            button.addEventListener('click', () => switchTab(button.dataset.tab));
        });

        function switchRole(roleName) {
            roleSelectors.forEach(btn => {
                const isActive = btn.dataset.role === roleName;
                btn.classList.toggle('bg-amber-50', isActive);
                btn.classList.toggle('text-amber-600', isActive);
                btn.classList.toggle('border-amber-200', isActive);
                btn.classList.toggle('bg-white', !isActive);
                btn.classList.toggle('text-slate-700', !isActive);
                btn.classList.toggle('border-slate-100', !isActive);
            });
            if (activeRoleName) {
                const names = {
                    'admin': 'Super Admin',
                    'manager': 'Floor Manager',
                    'cashier': 'Terminal Cashier'
                };
                activeRoleName.textContent = names[roleName] || roleName;
            }
        }

        roleSelectors.forEach(button => {
            button.addEventListener('click', () => switchRole(button.dataset.role));
        });
    });
</script>
<style>
    .fa-spin-hover:hover { animation: spin 2s infinite linear; }
    @keyframes spin { from { transform: rotate(0deg); } to { transform: rotate(360deg); } }
</style>
<?php $__env->stopPush(); ?>
<?php echo $__env->make('layouts.main', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH E:\code_2\general-store\resources\views/pages/settings.blade.php ENDPATH**/ ?>