
<?php $__env->startSection('title', 'RetailPro | Purchase Orders'); ?>

<?php $__env->startSection('content'); ?>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

    <main class="h-screen overflow-x-hidden overflow-y-auto p-2 sm:p-4 md:p-8 pt-24 bg-[#f1f5f9] flex flex-col"
        x-data="{ showModal: false, isEditMode: false }"
        @open-po-modal.window="showModal = true; isEditMode = $event.detail.editMode">

        <div class="max-w-[1600px] mx-auto w-full">
            
            <div class="flex flex-col lg:flex-row items-center justify-between mb-8 pb-6 border-b border-slate-200 gap-4">
                <div class="text-center lg:text-left">
                    <h1 class="text-2xl md:text-3xl font-black text-slate-900 tracking-tighter uppercase italic leading-none">Purchases</h1>
                    <p class="text-[10px] md:text-sm text-slate-500 mt-1 font-medium italic">Stock Procurement & Acquisition Terminal</p>
                </div>

                <div class="flex flex-col sm:flex-row gap-3 w-full lg:w-auto">
                    <div class="relative flex-grow sm:w-80">
                        <i class="fa-solid fa-search absolute left-4 top-1/2 -translate-y-1/2 text-slate-400"></i>
                        <input type="text" placeholder="Search POs..."
                            class="w-full pl-11 pr-4 py-3 bg-white border border-slate-200 rounded-2xl outline-none text-sm text-slate-700 focus:ring-4 focus:ring-amber-500/20 focus:border-[#f59e0b] transition shadow-sm font-medium">
                    </div>
                    <button @click="resetForm(); $dispatch('open-po-modal', { editMode: false })"
                        class="px-6 py-3 bg-[#0f172a] text-white rounded-2xl shadow-xl font-black uppercase text-xs tracking-widest transition transform active:scale-95 flex items-center justify-center gap-2 group whitespace-nowrap">
                        <i class="fa-solid fa-cart-plus group-hover:rotate-12 transition-transform"></i> Create New PO
                    </button>
                </div>
            </div>

            
            <div class="hidden lg:block bg-white rounded-3xl shadow-xl border border-slate-100 overflow-hidden mb-10">
                <table class="w-full border-collapse text-sm">
                    <thead class="bg-[#0f172a] text-white">
                        <tr>
                            <th class="py-5 px-6 text-left font-black uppercase tracking-widest text-[10px] italic">Purchase ID</th>
                            <th class="py-5 px-6 text-left font-black uppercase tracking-widest text-[10px] italic">Supplier & Items</th>
                            <th class="py-5 px-6 text-right font-black uppercase tracking-widest text-[10px] italic">Total Amount</th>
                            <th class="py-5 px-6 text-center font-black uppercase tracking-widest text-[10px] italic">Status</th>
                            <th class="py-5 px-6 text-center font-black uppercase tracking-widest text-[10px] italic w-32">Actions</th>
                        </tr>
                    </thead>
                    <tbody id="mainPOTableBody" class="divide-y divide-slate-100">
                        <?php $__empty_1 = true; $__currentLoopData = $orders; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $order): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                            <tr class="hover:bg-slate-50 transition group">
                                <td class="py-5 px-6 align-top font-black text-slate-900 tracking-tighter italic text-lg">#<?php echo e($order->po_number); ?></td>
                                <td class="py-5 px-6 align-top">
                                    <div class="font-black text-slate-800 uppercase mb-3 tracking-tight"><?php echo e($order->supplier_name); ?></div>
                                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-2">
                                        <?php $__currentLoopData = $order->items; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <div class="bg-slate-50 rounded-xl p-3 border border-slate-100">
                                                <span class="text-[10px] font-black text-[#f59e0b] block uppercase mb-1"><?php echo e($item->product_name); ?></span>
                                                <div class="flex flex-wrap gap-1">
                                                    <?php $__currentLoopData = $item->variants; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $v): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                        <span class="text-[9px] font-bold bg-white border border-slate-200 px-2 py-0.5 rounded text-slate-600">
                                                            <?php echo e($v->sku); ?> | Qty: <?php echo e($v->quantity); ?>

                                                        </span>
                                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                </div>
                                            </div>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </div>
                                </td>
                                <td class="py-5 px-6 text-right align-top font-black text-slate-900 italic tracking-tighter">
                                    <span class="text-[10px] font-bold text-slate-400 not-italic uppercase mr-1">PKR</span><?php echo e(number_format($order->total_amount, 2)); ?>

                                </td>
                                <td class="py-5 px-6 text-center align-top">
                                    <span class="inline-block px-4 py-1.5 rounded-full text-[9px] font-black uppercase tracking-widest border 
                                        <?php echo e($order->status == 'Completed' ? 'bg-emerald-50 text-emerald-600 border-emerald-100' : 'bg-amber-50 text-amber-600 border-amber-100'); ?>">
                                        <?php echo e($order->status); ?>

                                    </span>
                                </td>
                                <td class="py-5 px-6 text-center align-top">
                                    <div class="flex items-center justify-center gap-2">
                                        <button onclick="editPO(<?php echo e($order->id); ?>)" class="w-9 h-9 rounded-xl bg-slate-50 text-slate-400 flex items-center justify-center hover:bg-[#f59e0b] hover:text-white transition shadow-sm"><i class="fa-solid fa-pen-to-square text-xs"></i></button>
                                        <button onclick="deletePO(<?php echo e($order->id); ?>)" class="w-9 h-9 rounded-xl bg-red-50 text-red-300 flex items-center justify-center hover:bg-red-600 hover:text-white transition shadow-sm"><i class="fa-solid fa-trash text-xs"></i></button>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                            <tr><td colspan="5" class="py-20 text-center text-slate-400 italic font-black uppercase tracking-widest text-xs">No PO Records Found</td></tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>

            
            <div class="lg:hidden space-y-4 mb-24">
                <?php $__empty_1 = true; $__currentLoopData = $orders; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $order): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                <div class="bg-white p-5 rounded-3xl border border-slate-200 shadow-sm relative overflow-hidden">
                    <div class="flex justify-between items-center mb-3">
                        <span class="text-sm font-black text-slate-900 italic tracking-tighter">#<?php echo e($order->po_number); ?></span>
                        <span class="text-[8px] font-black uppercase px-3 py-1 rounded-full border <?php echo e($order->status == 'Completed' ? 'bg-emerald-50 text-emerald-600 border-emerald-100' : 'bg-amber-50 text-amber-600 border-amber-100'); ?>">
                            <?php echo e($order->status); ?>

                        </span>
                    </div>
                    <div class="mb-4">
                        <h4 class="font-black text-slate-800 uppercase text-xs mb-2"><?php echo e($order->supplier_name); ?></h4>
                        <div class="flex flex-wrap gap-1">
                            <?php $__currentLoopData = $order->items; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <span class="text-[8px] font-bold bg-slate-50 px-2 py-0.5 rounded text-slate-500 border border-slate-100 uppercase"><?php echo e($item->product_name); ?></span>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </div>
                    </div>
                    <div class="flex justify-between items-end border-t border-slate-100 pt-3">
                        <div>
                            <span class="text-[8px] font-black text-slate-400 uppercase tracking-widest block">Valuation</span>
                            <span class="text-lg font-black text-slate-900 italic tracking-tighter">PKR <?php echo e(number_format($order->total_amount, 0)); ?></span>
                        </div>
                        <div class="flex gap-2">
                            <button onclick="editPO(<?php echo e($order->id); ?>)" class="w-10 h-10 rounded-2xl bg-slate-900 text-amber-500 flex items-center justify-center shadow-lg"><i class="fa-solid fa-pen-to-square"></i></button>
                            <button onclick="deletePO(<?php echo e($order->id); ?>)" class="w-10 h-10 rounded-2xl bg-red-50 text-red-500 flex items-center justify-center border border-red-100"><i class="fa-solid fa-trash"></i></button>
                        </div>
                    </div>
                </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                <div class="py-20 text-center text-slate-300 font-black uppercase italic tracking-widest text-xs">No PO Data Found</div>
                <?php endif; ?>
            </div>
        </div>

        
        <div x-show="showModal" class="fixed inset-0 z-[110] flex items-center justify-center p-2 sm:p-4 bg-[#0f172a]/90 backdrop-blur-md" x-cloak x-transition>
            <div class="bg-white w-full max-w-6xl rounded-[2.5rem] shadow-3xl overflow-hidden flex flex-col h-full max-h-[95vh] md:max-h-[90vh]">
                
                <div class="p-5 border-b bg-[#0f172a] flex justify-between items-center shrink-0">
                    <div>
                        <h3 class="text-xl font-black text-[#f59e0b] italic uppercase tracking-tighter leading-none" x-text="isEditMode ? 'Update Purchase Order' : 'New Purchase Order'"></h3>
                        <p class="text-[9px] font-bold uppercase tracking-widest mt-1 text-slate-400">Inventory Acquisition Registry</p>
                    </div>
                    <button @click="showModal = false" class="text-white hover:text-[#f59e0b] text-3xl font-light transition-colors">&times;</button>
                </div>

                
                <div class="p-4 md:p-8 overflow-y-auto custom-scrollbar flex-grow bg-[#f8fafc]">
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-8">
                        <div>
                            <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest block mb-2 ml-1">Vendor Selection</label>
                            <select id="po_supplier" class="w-full px-4 py-3 bg-white border border-slate-200 rounded-2xl outline-none focus:ring-4 focus:ring-amber-500/10 font-bold text-sm shadow-sm">
                                <option value="">Select Supplier</option>
                                <?php $__currentLoopData = $suppliers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $supplier): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($supplier->supplier_name); ?>"><?php echo e($supplier->supplier_name); ?></option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                        </div>
                        <div>
                            <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest block mb-2 ml-1">Order Date</label>
                            <input id="po_date" type="date" value="<?php echo e(date('Y-m-d')); ?>" class="w-full px-4 py-3 bg-white border border-slate-200 rounded-2xl outline-none focus:ring-4 focus:ring-amber-500/10 font-bold text-sm shadow-sm">
                        </div>
                        <div>
                            <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest block mb-2 ml-1">Workflow Status</label>
                            <select id="po_status" class="w-full px-4 py-3 bg-white border border-slate-200 rounded-2xl outline-none focus:ring-4 focus:ring-amber-500/10 font-bold text-sm shadow-sm">
                                <option value="Draft">Draft</option>
                                <option value="Pending">Pending</option>
                                <option value="Completed">Completed</option>
                            </select>
                        </div>
                    </div>

                    
                    <div class="bg-white rounded-3xl p-4 md:p-6 border border-slate-100 shadow-sm">
                        <div class="flex flex-col sm:flex-row justify-between items-center mb-6 gap-3">
                            <h4 class="font-black text-slate-900 uppercase text-[10px] tracking-widest border-l-4 border-[#f59e0b] pl-3">Order Manifest</h4>
                            <button type="button" onclick="openProductModal()" class="w-full sm:w-auto px-5 py-2.5 bg-[#0f172a] text-white rounded-xl text-[10px] font-black uppercase tracking-widest shadow-lg hover:bg-slate-800 transition active:scale-95">
                                <i class="fa-solid fa-plus-circle mr-1"></i> Add Product
                            </button>
                        </div>

                        
                        <div class="overflow-x-auto rounded-xl border border-slate-50 shadow-inner">
                            <table class="w-full text-xs min-w-[750px]">
                                <thead class="bg-slate-50 text-slate-400 font-black uppercase text-[9px] border-b border-slate-100">
                                    <tr>
                                        <th class="p-4 text-left">Product & Manifest</th>
                                        <th class="p-4 text-left">Brand Info</th>
                                        <th class="p-4 text-right">Valuation (PKR)</th>
                                        <th class="p-4 text-center w-24">Protocol</th>
                                    </tr>
                                </thead>
                                <tbody id="poProductsTbody" class="divide-y divide-slate-50">
                                    
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                
                <div class="p-5 border-t bg-slate-50 flex flex-col sm:flex-row justify-end gap-3 shrink-0">
                    <button @click="showModal = false" class="order-2 sm:order-1 px-8 py-3 bg-white border border-slate-200 rounded-xl font-black text-slate-400 uppercase text-xs hover:bg-slate-100 shadow-sm transition">Discard</button>
                    <button onclick="submitFinalPO()" class="order-1 sm:order-2 px-10 py-3 bg-[#0f172a] text-[#f59e0b] rounded-xl font-black shadow-xl uppercase text-xs tracking-widest hover:bg-slate-800 transition shadow-amber-500/10">Confirm Purchase</button>
                </div>
            </div>
        </div>

        
        <div id="productModal" class="fixed inset-0 z-[120] hidden items-center justify-center p-2 sm:p-4 bg-black/90 backdrop-blur-md">
            <div id="productModalBox" class="bg-white w-full max-w-4xl rounded-[2.5rem] shadow-3xl overflow-hidden flex flex-col h-full max-h-[90vh]">
                <div class="p-5 border-b bg-[#0f172a] flex justify-between items-center shrink-0 text-white">
                    <h2 class="text-lg font-black uppercase italic tracking-tighter text-amber-500">Catalogue Selector</h2>
                    <button onclick="closeProductModal()" class="text-3xl font-light">&times;</button>
                </div>

                <div class="p-4 md:p-8 overflow-y-auto bg-[#f8fafc] flex-grow">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6">
                        <div class="md:col-span-2 relative">
                            <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest block mb-2 ml-1">Database Lookup</label>
                            <input type="text" id="p_name" oninput="filterMedicines(this.value)" placeholder="Search store products..." class="w-full px-4 py-3 bg-white border border-slate-200 rounded-2xl outline-none focus:ring-4 focus:ring-amber-500/10 font-bold text-sm shadow-sm">
                            <div id="medicine_dropdown" class="absolute left-0 right-0 mt-2 bg-white rounded-2xl shadow-2xl border border-slate-100 hidden z-[130] max-h-48 overflow-y-auto">
                                <?php $__currentLoopData = $medicines; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $med): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <div class="p-4 hover:bg-slate-50 cursor-pointer border-b last:border-0 flex justify-between items-center transition" data-name="<?php echo e($med->name); ?>" data-manufacturer="<?php echo e($med->manufacturer); ?>" data-variants="<?php echo e(json_encode($med->variants)); ?>" onclick="selectMedicine(this)">
                                        <div>
                                            <span class="font-black text-slate-800 text-sm block uppercase"><?php echo e($med->name); ?></span>
                                            <span class="text-[9px] text-slate-400 uppercase font-black"><?php echo e($med->manufacturer); ?></span>
                                        </div>
                                        <i class="fa-solid fa-chevron-right text-[10px] text-amber-500"></i>
                                    </div>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </div>
                        </div>
                    </div>

                    <div class="bg-white rounded-3xl border border-slate-100 p-4 md:p-6 shadow-sm overflow-hidden">
                        <h4 class="font-black text-slate-900 uppercase text-[10px] tracking-widest border-l-4 border-emerald-500 pl-3 mb-4">Variant Configuration</h4>
                        
                        <div class="overflow-x-auto rounded-xl border border-slate-50 shadow-inner">
                            <table class="w-full text-xs min-w-[750px]">
                                <thead class="bg-slate-50 text-slate-400 font-black uppercase text-[9px] border-b">
                                    <tr>
                                        <th class="p-3 text-left">Label (SKU)</th>
                                        <th class="p-3 text-left">Batch No.</th>
                                        <th class="p-3 text-left">Expiry</th>
                                        <th class="p-3 text-right">Unit Cost</th>
                                        <th class="p-3 text-center w-24">Quantity</th>
                                        <th class="p-3 w-10"></th>
                                    </tr>
                                </thead>
                                <tbody id="variantsTbody" class="divide-y divide-slate-50"></tbody>
                            </table>
                        </div>
                        <button type="button" onclick="addNewEmptyVariant()" class="mt-4 w-full py-3 bg-slate-50 text-slate-400 rounded-xl text-[9px] font-black uppercase border border-dashed border-slate-300 hover:bg-slate-100 transition tracking-widest">+ Define New Stock Variant</button>
                    </div>
                </div>

                <div class="p-5 border-t bg-slate-50 flex justify-end gap-3 shrink-0">
                    <button onclick="closeProductModal()" class="px-8 py-2.5 bg-white border border-slate-200 rounded-xl font-black text-slate-400 uppercase text-[10px]">Cancel</button>
                    <button onclick="addProductToPO()" class="px-10 py-2.5 bg-[#0f172a] text-[#f59e0b] rounded-xl font-black shadow-xl uppercase text-[10px] tracking-widest active:scale-95 transition">Apply Selection</button>
                </div>
            </div>
        </div>

    </main>

    
    <datalist id="existing_medicines" class="hidden">
        <?php $__currentLoopData = $medicines; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $med): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <option value="<?php echo e($med->name); ?>" data-manufacturer="<?php echo e($med->manufacturer); ?>" data-category="<?php echo e($med->category); ?>" data-variants="<?php echo e(json_encode($med->variants)); ?>">
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </datalist>

    <style>
        /* Block horizontal page scroll */
        html, body { overflow-x: hidden !important; width: 100%; position: relative; }
        
        /* Modern scrollbar for table-only scrolling */
        .overflow-x-auto::-webkit-scrollbar { height: 5px; }
        .overflow-x-auto::-webkit-scrollbar-track { background: #f8fafc; }
        .overflow-x-auto::-webkit-scrollbar-thumb { background: #e2e8f0; border-radius: 10px; }
        
        .custom-scrollbar::-webkit-scrollbar { width: 4px; }
        .custom-scrollbar::-webkit-scrollbar-track { background: transparent; }
        .custom-scrollbar::-webkit-scrollbar-thumb { background: #cbd5e1; border-radius: 10px; }
    </style>

    
    <script>
        let currentTempVariants = [];
        let poItemsList = [];
        let editPoId = null;
        let editingProductIndex = null;

        function filterMedicines(val) {
            const dropdown = document.getElementById('medicine_dropdown');
            const items = dropdown.querySelectorAll('div[data-name]');
            let hasResults = false;
            if (val.length < 1) { dropdown.classList.add('hidden'); return; }
            items.forEach(item => {
                const name = item.getAttribute('data-name').toLowerCase();
                if (name.includes(val.toLowerCase())) { item.classList.remove('hidden'); hasResults = true; }
                else { item.classList.add('hidden'); }
            });
            dropdown.classList.toggle('hidden', !hasResults);
        }

        function selectMedicine(el) {
            const name = el.getAttribute('data-name');
            document.getElementById('p_name').value = name;
            const variantsData = JSON.parse(el.getAttribute('data-variants') || '[]');
            currentTempVariants = variantsData.map(v => ({
                sku: v.sku, batch: '', expiry: v.expiry_date || '',
                tp: v.purchase_price || 0, stock: 1, subtotal: v.purchase_price || 0
            }));
            updateVariantTable();
            document.getElementById('medicine_dropdown').classList.add('hidden');
        }

        function updateVariantTable() {
            const tbody = document.getElementById('variantsTbody');
            if (currentTempVariants.length === 0) {
                tbody.innerHTML = '<tr><td colspan="6" class="p-10 text-center text-slate-300 italic font-black uppercase tracking-widest text-[9px]">Add a variant to begin.</td></tr>';
                return;
            }
            tbody.innerHTML = currentTempVariants.map((v, i) => `
                <tr class="bg-white hover:bg-slate-50 transition border-b">
                    <td class="p-2 min-w-[140px]"><input type="text" value="${v.sku}" onchange="updateVariantData(${i}, 'sku', this.value)" class="w-full p-2 border border-slate-100 rounded text-[11px] font-black text-amber-600 uppercase outline-none"></td>
                    <td class="p-2 min-w-[100px]"><input type="text" value="${v.batch}" onchange="updateVariantData(${i}, 'batch', this.value)" placeholder="Batch #" class="w-full p-2 border border-slate-100 rounded text-[11px] outline-none"></td>
                    <td class="p-2 min-w-[130px]"><input type="date" value="${v.expiry}" onchange="updateVariantData(${i}, 'expiry', this.value)" class="w-full p-2 border border-slate-100 rounded text-[11px] font-bold text-red-500 outline-none"></td>
                    <td class="p-2 text-right min-w-[100px]"><input type="number" value="${v.tp}" onchange="updateVariantData(${i}, 'tp', this.value)" class="w-full p-2 border border-slate-100 rounded text-[11px] text-right font-black outline-none italic"></td>
                    <td class="p-2 text-center min-w-[80px]"><input type="number" value="${v.stock}" onchange="updateVariantData(${i}, 'stock', this.value)" class="w-full p-2 border border-slate-100 rounded text-[11px] text-center font-black outline-none"></td>
                    <td class="p-2 text-center"><button onclick="currentTempVariants.splice(${i},1);updateVariantTable();" class="text-red-200 hover:text-red-500 transition"><i class="fa-solid fa-circle-minus text-base"></i></button></td>
                </tr>`).join('');
        }

        function updateVariantData(index, field, value) {
            currentTempVariants[index][field] = value;
            if (field === 'tp' || field === 'stock') {
                currentTempVariants[index].subtotal = (parseFloat(currentTempVariants[index].tp) || 0) * (parseInt(currentTempVariants[index].stock) || 0);
            }
        }

        function addNewEmptyVariant() {
            currentTempVariants.push({ sku: '', batch: '', expiry: '', tp: 0, stock: 1, subtotal: 0 });
            updateVariantTable();
        }

        function openProductModal() {
            editingProductIndex = null;
            document.getElementById('productModalTitle').innerText = "Catalogue Selector";
            currentTempVariants = []; updateVariantTable();
            document.getElementById('p_name').value = '';
            document.getElementById('medicine_dropdown').classList.add('hidden');
            document.getElementById('productModal').classList.remove('hidden');
            document.getElementById('productModal').classList.add('flex');
            setTimeout(() => {
                document.getElementById('productModalBox').classList.remove('scale-95', 'opacity-0');
                document.getElementById('productModalBox').classList.add('scale-100', 'opacity-100');
            }, 10);
        }

        function closeProductModal() {
            document.getElementById('productModalBox').classList.remove('scale-100', 'opacity-100');
            document.getElementById('productModalBox').classList.add('scale-95', 'opacity-0');
            setTimeout(() => { document.getElementById('productModal').classList.add('hidden'); document.getElementById('productModal').classList.remove('flex'); }, 200);
        }

        function addProductToPO() {
            const pName = document.getElementById('p_name').value;
            if (!pName || currentTempVariants.length === 0) return alert('Product name and variants are required');
            const productTotal = currentTempVariants.reduce((sum, v) => sum + (v.subtotal || 0), 0);
            const productData = { name: pName, variants: [...currentTempVariants], total: productTotal };
            if (editingProductIndex !== null) poItemsList[editingProductIndex] = productData;
            else poItemsList.push(productData);
            updatePOTable(); closeProductModal();
        }

        function updatePOTable() {
            const tbody = document.getElementById('poProductsTbody');
            if (poItemsList.length === 0) { 
                tbody.innerHTML = '<tr><td colspan="4" class="p-10 text-center italic text-slate-400 font-black uppercase tracking-widest text-[10px]">No items in manifest.</td></tr>'; 
                return; 
            }
            tbody.innerHTML = poItemsList.map((p, i) => `
                <tr class="border-b bg-white hover:bg-slate-50 transition">
                    <td class="p-4"><div class="font-black text-slate-800 uppercase tracking-tighter italic text-sm">${p.name}</div></td>
                    <td class="p-4"><div class="text-[9px] text-slate-400 font-bold leading-tight uppercase">${p.variants.map(v => v.sku).join(', ')}</div></td>
                    <td class="p-4 text-right font-black text-slate-900 italic text-sm">PKR ${p.total.toLocaleString()}</td>
                    <td class="p-4 text-center">
                        <div class="flex justify-center gap-3">
                            <i class="fa-solid fa-pencil text-slate-300 hover:text-amber-500 cursor-pointer" onclick="editProductInPO(${i})"></i>
                            <i class="fa-solid fa-trash-can text-red-200 hover:text-red-500 cursor-pointer" onclick="poItemsList.splice(${i},1);updatePOTable();"></i>
                        </div>
                    </td>
                </tr>`).join('');
        }

        function editProductInPO(index) {
            editingProductIndex = index;
            const product = poItemsList[index];
            document.getElementById('productModalTitle').innerText = "Update Selection";
            document.getElementById('p_name').value = product.name;
            currentTempVariants = [...product.variants];
            updateVariantTable();
            document.getElementById('productModal').classList.remove('hidden');
            document.getElementById('productModal').classList.add('flex');
            setTimeout(() => {
                document.getElementById('productModalBox').classList.remove('scale-95', 'opacity-0');
                document.getElementById('productModalBox').classList.add('scale-100', 'opacity-100');
            }, 10);
        }

        async function submitFinalPO() {
            if(poItemsList.length === 0) return alert('Order manifest is empty');
            const payload = {
                _token: "<?php echo e(csrf_token()); ?>",
                supplier: document.getElementById('po_supplier').value,
                date: document.getElementById('po_date').value,
                status: document.getElementById('po_status').value,
                total_amount: poItemsList.reduce((sum, p) => sum + p.total, 0),
                products: poItemsList
            };
            const url = editPoId ? `/purchase-orders/${editPoId}` : "<?php echo e(route('po.store')); ?>";
            const response = await fetch(url, { 
                method: editPoId ? "PUT" : "POST", 
                headers: { "Content-Type": "application/json" }, 
                body: JSON.stringify(payload) 
            });
            if (response.ok) window.location.reload();
            else alert("Error saving Purchase Order");
        }

        async function editPO(id) {
            const response = await fetch(`/purchase-orders/${id}/edit`);
            const po = await response.json();
            editPoId = id;
            document.getElementById('po_supplier').value = po.supplier_name;
            document.getElementById('po_date').value = po.order_date;
            document.getElementById('po_status').value = po.status;
            poItemsList = po.items.map(item => ({
                name: item.product_name,
                variants: item.variants.map(v => ({ 
                    sku: v.sku, batch: v.batch_no, expiry: v.expiry_date || '', 
                    tp: v.purchase_price, stock: v.quantity, subtotal: v.purchase_price * v.quantity 
                })),
                total: item.variants.reduce((sum, v) => sum + (v.purchase_price * v.quantity), 0)
            }));
            updatePOTable();
            window.dispatchEvent(new CustomEvent('open-po-modal', { detail: { editMode: true } }));
        }

        async function deletePO(id) {
            if (confirm('Permanently delete this PO record?')) {
                await fetch(`/purchase-orders/${id}`, { method: 'DELETE', headers: { 'X-CSRF-TOKEN': "<?php echo e(csrf_token()); ?>" } });
                window.location.reload();
            }
        }

        function resetForm() { poItemsList = []; editPoId = null; updatePOTable(); }
    </script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.main', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH E:\code_2\general-store\resources\views/pages/purchases.blade.php ENDPATH**/ ?>