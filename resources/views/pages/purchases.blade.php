@extends('layouts.main')
@section('title', 'RetailPro | Purchase Orders')

@section('content')
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

    <main class="h-screen overflow-y-auto p-4 md:p-8 pt-24 bg-[#f1f5f9] flex flex-col" 
          x-data="{ showModal: false, isEditMode: false }"
          @open-po-modal.window="showModal = true; isEditMode = $event.detail.editMode">

        <div class="max-w-[1600px] mx-auto w-full">
            {{-- HEADER SECTION --}}
            <div class="flex flex-col md:flex-row items-center justify-between mb-8 pb-6 border-b border-slate-200 gap-4">
                <div class="text-center md:text-left">
                    <h1 class="text-3xl font-black text-slate-900 tracking-tighter uppercase italic leading-none">Purchases</h1>
                    <p class="text-xs md:text-sm text-slate-500 mt-1 font-medium italic">Procurement & Inventory Acquisition Terminal</p>
                </div>
                
                <div class="flex flex-col sm:flex-row gap-3 w-full md:w-auto">
                    <div class="relative flex-grow sm:w-80">
                        <i class="fa-solid fa-search absolute left-4 top-1/2 -translate-y-1/2 text-slate-400"></i>
                        <input type="text" placeholder="Search POs..." 
                            class="w-full pl-11 pr-4 py-3 bg-white border border-slate-200 rounded-2xl outline-none text-sm text-slate-700 focus:ring-4 focus:ring-amber-500/20 focus:border-[#f59e0b] transition shadow-sm font-medium">
                    </div>
                    <button @click="resetForm(); $dispatch('open-po-modal', { editMode: false })"
                        class="px-6 py-3 bg-[#0f172a] hover:bg-slate-800 text-white rounded-2xl shadow-xl font-black uppercase text-xs tracking-widest transition transform active:scale-95 flex items-center justify-center gap-2 group">
                        <i class="fa-solid fa-cart-plus group-hover:rotate-12 transition-transform"></i> Create New PO
                    </button>
                </div>
            </div>

            {{-- MAIN TABLE --}}
            <div class="bg-white rounded-3xl shadow-xl border border-slate-100 overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="w-full border-collapse text-sm min-w-[1000px]">
                        <thead class="bg-[#0f172a] text-white text-left">
                            <tr>
                                <th class="py-5 px-6 font-black uppercase tracking-widest text-[10px] italic">Purchase ID</th>
                                <th class="py-5 px-6 font-black uppercase tracking-widest text-[10px] italic">Supplier & Manifest</th>
                                <th class="py-5 px-6 text-right font-black uppercase tracking-widest text-[10px] italic">Total Amount</th>
                                <th class="py-5 px-6 text-center font-black uppercase tracking-widest text-[10px] italic">Status</th>
                                <th class="py-5 px-6 text-center font-black uppercase tracking-widest text-[10px] italic">Actions</th>
                            </tr>
                        </thead>
                        <tbody id="mainPOTableBody" class="divide-y divide-slate-100">
                            @forelse($orders as $order)
                                <tr class="hover:bg-slate-50 transition group">
                                    <td class="py-5 px-6 align-top">
                                        <div class="font-black text-slate-900 tracking-tighter italic text-lg leading-none">#{{ $order->po_number }}</div>
                                        <div class="text-[10px] text-slate-400 font-bold uppercase mt-2 tracking-tighter">
                                            {{ \Carbon\Carbon::parse($order->order_date)->format('d M, Y') }}
                                        </div>
                                    </td>
                                    <td class="py-5 px-6 align-top">
                                        <div class="font-black text-slate-800 uppercase mb-3 tracking-tight">{{ $order->supplier_name }}</div>
                                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-2">
                                            @foreach($order->items as $item)
                                                <div class="bg-slate-50 rounded-xl p-3 border border-slate-100">
                                                    <span class="text-[10px] font-black text-[#f59e0b] block uppercase mb-1">{{ $item->product_name }}</span>
                                                    <div class="flex flex-wrap gap-1">
                                                        @foreach($item->variants as $v)
                                                            <span class="text-[9px] font-bold bg-white border border-slate-200 px-2 py-0.5 rounded text-slate-600">
                                                                {{ $v->sku }} | Qty: {{ $v->quantity }}
                                                            </span>
                                                        @endforeach
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>
                                    </td>
                                    <td class="py-5 px-6 text-right align-top">
                                        <div class="text-lg font-black text-slate-900 italic tracking-tighter">
                                            <span class="text-[10px] font-bold text-slate-400 not-italic uppercase mr-1">PKR</span>{{ number_format($order->total_amount, 2) }}
                                        </div>
                                    </td>
                                    <td class="py-5 px-6 text-center align-top">
                                        <span class="inline-block px-4 py-1.5 rounded-full text-[9px] font-black uppercase tracking-widest shadow-sm border
                                            {{ $order->status == 'Completed' ? 'bg-emerald-50 text-emerald-600 border-emerald-100' : 'bg-amber-50 text-amber-600 border-amber-100' }}">
                                            {{ $order->status }}
                                        </span>
                                    </td>
                                    <td class="py-5 px-6 text-center align-top">
                                        <div class="flex items-center justify-center gap-2">
                                            <button onclick="editPO({{ $order->id }})" class="w-9 h-9 rounded-xl bg-slate-50 text-slate-400 flex items-center justify-center hover:bg-[#f59e0b] hover:text-white transition shadow-sm">
                                                <i class="fa-solid fa-pen-to-square text-xs"></i>
                                            </button>
                                            <button onclick="deletePO({{ $order->id }})" class="w-9 h-9 rounded-xl bg-red-50 text-red-300 flex items-center justify-center hover:bg-red-600 hover:text-white transition shadow-sm">
                                                <i class="fa-solid fa-trash text-xs"></i>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="py-20 text-center text-slate-400 italic font-black uppercase tracking-widest text-xs">No PO Records Found</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        {{-- CREATE/EDIT MODAL --}}
        <div x-show="showModal" class="fixed inset-0 z-50 flex items-center justify-center p-2 sm:p-4 bg-[#0f172a]/80 backdrop-blur-sm"
            x-cloak x-transition>
            <div class="bg-white w-full max-w-6xl rounded-3xl shadow-3xl overflow-hidden flex flex-col h-full max-h-[90vh]">
                {{-- Modal Header --}}
                <div class="p-5 border-b bg-[#0f172a] flex justify-between items-center shrink-0">
                    <div>
                        <h3 class="text-xl font-black text-[#f59e0b] italic uppercase tracking-tighter leading-none" 
                            x-text="isEditMode ? 'Update Purchase Order' : 'New Purchase Order'"></h3>
                        <p class="text-[9px] font-bold uppercase tracking-widest mt-1 text-slate-400">Inventory Acquisition Terminal</p>
                    </div>
                    <button @click="showModal = false" 
                        class="text-white hover:text-[#f59e0b] text-3xl font-light transition-colors">&times;</button>
                </div>

                <div class="p-4 md:p-8 overflow-y-auto custom-scrollbar flex-grow bg-[#f8fafc]">
                    {{-- Form Fields --}}
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
                        <div>
                            <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest block mb-2 ml-1">Supplier Selection</label>
                            <select id="po_supplier" class="w-full px-4 py-3 bg-white border border-slate-200 rounded-2xl outline-none focus:ring-4 focus:ring-amber-500/10 focus:border-[#f59e0b] font-bold text-sm shadow-sm">
                                <option value="">Select Supplier</option>
                                @foreach($suppliers as $supplier)
                                    <option value="{{ $supplier->supplier_name }}">{{ $supplier->supplier_name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest block mb-2 ml-1">Order Timestamp</label>
                            <input id="po_date" type="date" value="{{ date('Y-m-d') }}" class="w-full px-4 py-3 bg-white border border-slate-200 rounded-2xl outline-none focus:ring-4 focus:ring-amber-500/10 focus:border-[#f59e0b] font-bold text-sm shadow-sm">
                        </div>
                        <div>
                            <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest block mb-2 ml-1">Workflow Status</label>
                            <select id="po_status" class="w-full px-4 py-3 bg-white border border-slate-200 rounded-2xl outline-none focus:ring-4 focus:ring-amber-500/10 focus:border-[#f59e0b] font-bold text-sm shadow-sm">
                                <option value="Draft">Draft</option>
                                <option value="Pending">Pending</option>
                                <option value="Completed">Completed</option>
                            </select>
                        </div>
                    </div>

                    {{-- Products Table Area --}}
                    <div class="bg-white rounded-3xl p-6 border border-slate-100 shadow-sm">
                        <div class="flex justify-between items-center mb-6">
                            <h4 class="font-black text-slate-900 uppercase text-[10px] tracking-widest border-l-4 border-[#f59e0b] pl-3">Order Manifest</h4>
                            <button type="button" onclick="openProductModal()" class="px-5 py-2.5 bg-[#0f172a] text-white rounded-xl text-[10px] font-black uppercase tracking-widest shadow-lg hover:bg-slate-800 transition active:scale-95">
                                <i class="fa-solid fa-plus-circle mr-1"></i> Add Product
                            </button>
                        </div>

                        <div class="overflow-x-auto">
                            <table class="w-full text-xs min-w-[700px]">
                                <thead class="bg-slate-50 text-slate-400 font-black uppercase text-[9px] border-b border-slate-100">
                                    <tr>
                                        <th class="p-4 text-left">Product & SKUs</th>
                                        <th class="p-4 text-left">Brand Info</th>
                                        <th class="p-4 text-right">Valuation (PKR)</th>
                                        <th class="p-4 text-center">Action</th>
                                    </tr>
                                </thead>
                                <tbody id="poProductsTbody" class="divide-y divide-slate-50 bg-white">
                                    {{-- JS Injected Content --}}
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                {{-- Modal Footer --}}
                <div class="p-6 border-t bg-slate-50 flex flex-col md:flex-row justify-end gap-3 shrink-0">
                    <button @click="showModal = false" class="order-2 md:order-1 px-8 py-3 bg-white border border-slate-200 rounded-xl font-black text-slate-400 uppercase text-xs hover:bg-slate-100 transition shadow-sm">Discard</button>
                    <button onclick="submitFinalPO()" class="order-1 md:order-2 px-10 py-3 bg-[#0f172a] text-[#f59e0b] rounded-xl font-black shadow-xl uppercase text-xs tracking-widest hover:bg-slate-800 transition shadow-amber-500/10">Confirm Purchase</button>
                </div>
            </div>
        </div>

        {{-- PRODUCT SELECTION SUB-MODAL --}}
        <div id="productModal" class="fixed inset-0 z-[60] hidden items-center justify-center p-2 sm:p-4 bg-[#0f172a]/90 backdrop-blur-md">
            <div id="productModalBox" class="bg-white w-full max-w-4xl rounded-3xl shadow-3xl overflow-hidden flex flex-col transform transition-all duration-300 scale-95 opacity-0 h-full max-h-[85vh]">
                <div class="p-5 border-b bg-[#0f172a] flex justify-between items-center shrink-0">
                    <h2 id="productModalTitle" class="text-xl font-black italic uppercase tracking-tighter text-[#f59e0b] leading-none">Catalogue Selection</h2>
                    <button onclick="closeProductModal()" class="text-white hover:text-[#f59e0b] text-3xl font-light transition-colors">&times;</button>
                </div>

                <div class="p-4 md:p-8 overflow-y-auto bg-[#f8fafc] flex-grow">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                        <div class="col-span-2 relative" x-data="{ open: false, search: '' }">
                            <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest block mb-2 ml-1">Database Lookup</label>
                            <input type="text" id="p_name" x-model="search" @click="open = true" @click.away="open = false" @input="open = true; checkExistingProduct(search)"
                                   placeholder="Search by Product Name..." class="w-full px-4 py-3 bg-white border border-slate-200 rounded-2xl outline-none focus:ring-4 focus:ring-amber-500/10 focus:border-[#f59e0b] font-bold text-sm shadow-sm" autocomplete="off" />
                            
                            <div x-show="open && search.length > 0" class="absolute z-[100] w-full mt-2 bg-white border border-slate-100 rounded-2xl shadow-2xl overflow-hidden">
                                <div class="max-h-60 overflow-y-auto">
                                    <template x-for="med in Array.from(document.querySelectorAll('#existing_medicines option'))">
                                        <div x-show="med.value.toLowerCase().includes(search.toLowerCase())"
                                             @click="search = med.value; open = false; checkExistingProduct(med.value)"
                                             class="px-6 py-3 hover:bg-slate-50 cursor-pointer border-b border-slate-50 transition-colors flex justify-between items-center">
                                            <div>
                                                <div class="font-black text-slate-800 text-sm uppercase" x-text="med.value"></div>
                                                <div class="text-[9px] font-bold text-slate-400 uppercase tracking-widest" x-text="med.dataset.manufacturer"></div>
                                            </div>
                                            <i class="fa-solid fa-chevron-right text-[10px] text-amber-500"></i>
                                        </div>
                                    </template>
                                </div>
                            </div>
                        </div>
                        <div>
                            <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest block mb-2 ml-1">Brand / Manufacturer</label>
                            <input id="p_manufacturer" placeholder="e.g. Unilever, Nestle" class="w-full px-4 py-3 bg-white border border-slate-200 rounded-2xl font-bold text-sm outline-none" />
                        </div>
                        <div>
                            <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest block mb-2 ml-1">Category</label>
                            <select id="p_category" class="w-full px-4 py-3 bg-white border border-slate-200 rounded-2xl font-bold text-sm outline-none">
                                <option value="General">General</option>
                                <option value="Grocery">Grocery</option>
                                <option value="Cosmetics">Cosmetics</option>
                                <option value="Electronics">Electronics</option>
                            </select>
                        </div>
                    </div>

                    <div class="bg-white rounded-3xl border border-slate-100 p-6 shadow-sm">
                        <div class="flex justify-between items-center mb-4">
                            <h4 class="font-black text-slate-900 uppercase text-[10px] tracking-widest border-l-4 border-emerald-500 pl-3">Variant Configuration</h4>
                            <button type="button" onclick="addNewEmptyVariant()" class="px-5 py-2.5 bg-emerald-600 hover:bg-emerald-700 text-white rounded-xl shadow-lg text-[10px] font-black uppercase tracking-widest transition active:scale-95">
                                <i class="fa-solid fa-plus-circle mr-1"></i> New SKU
                            </button>
                        </div>
                        <div class="bg-white rounded-2xl border border-slate-50 overflow-hidden shadow-sm overflow-x-auto">
                            <table class="w-full text-xs min-w-[600px]">
                                <thead class="bg-slate-50 text-slate-400 font-black uppercase text-[9px] border-b border-slate-100">
                                    <tr>
                                        <th class="p-3 text-left">SKU Label</th>
                                        <th class="p-3 text-left">Batch ID</th>
                                        <th class="p-3 text-left">Expiry</th>
                                        <th class="p-3 text-right">Unit Cost</th>
                                        <th class="p-3 text-center w-24">Quantity</th>
                                        <th class="p-3 text-center"></th>
                                    </tr>
                                </thead>
                                <tbody id="variantsTbody" class="divide-y divide-slate-50"></tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <div class="p-6 border-t bg-slate-50 flex justify-end gap-3 shrink-0">
                    <button onclick="closeProductModal()" class="px-6 py-2 bg-white border border-slate-200 rounded-xl font-black uppercase text-[9px] tracking-widest">Cancel</button>
                    <button onclick="addProductToPO()" class="px-10 py-3 bg-[#0f172a] text-[#f59e0b] rounded-xl font-black shadow-xl uppercase text-xs tracking-widest hover:bg-slate-800 transition">Apply Selection</button>
                </div>
            </div>
        </div>

        <datalist id="existing_medicines" class="hidden">
            @foreach($medicines as $med)
                <option value="{{ $med->name }}" data-manufacturer="{{ $med->manufacturer }}" data-category="{{ $med->category }}" data-variants="{{ json_encode($med->variants) }}">
            @endforeach
        </datalist>

        <script>
            let currentTempVariants = [];
            let poItemsList = [];
            let editPoId = null;
            let editingProductIndex = null;

            function animateOpen(container, box) {
                container.classList.remove('hidden'); container.classList.add('flex');
                setTimeout(() => { box.classList.remove('scale-95', 'opacity-0'); box.classList.add('scale-100', 'opacity-100'); }, 10);
            }
            function animateClose(container, box) {
                box.classList.remove('scale-100', 'opacity-100'); box.classList.add('scale-95', 'opacity-0');
                setTimeout(() => { container.classList.add('hidden'); container.classList.remove('flex'); }, 200);
            }

            function checkExistingProduct(val) {
                const list = document.getElementById('existing_medicines');
                const option = Array.from(list.options).find(opt => opt.value === val);
                if (option) {
                    document.getElementById('p_manufacturer').value = option.getAttribute('data-manufacturer');
                    document.getElementById('p_category').value = option.getAttribute('data-category');
                    document.getElementById('p_manufacturer').readOnly = true;
                    if (editingProductIndex === null) {
                        const variantsData = JSON.parse(option.getAttribute('data-variants') || '[]');
                        currentTempVariants = variantsData.map(v => ({
                            sku: v.sku, batch: '', expiry: v.expiry_date || '',
                            tp: v.purchase_price || 0, stock: 1, subtotal: v.purchase_price || 0
                        }));
                        updateVariantTable();
                    }
                } else {
                    document.getElementById('p_manufacturer').readOnly = false;
                }
            }

            function updateVariantTable() {
                const tbody = document.getElementById('variantsTbody');
                if (currentTempVariants.length === 0) {
                    tbody.innerHTML = '<tr><td colspan="6" class="p-10 text-center text-slate-300 italic font-black uppercase tracking-widest text-[9px]">Add a variant to begin.</td></tr>';
                    return;
                }
                tbody.innerHTML = currentTempVariants.map((v, i) => `
                        <tr class="bg-white hover:bg-slate-50 transition border-b">
                            <td class="p-2"><input type="text" value="${v.sku}" onchange="updateVariantData(${i}, 'sku', this.value)" class="w-full p-2 border border-slate-100 rounded text-[11px] font-black text-amber-600 uppercase focus:ring-1 outline-none"></td>
                            <td class="p-2"><input type="text" value="${v.batch}" onchange="updateVariantData(${i}, 'batch', this.value)" placeholder="Batch #" class="w-full p-2 border border-slate-100 rounded text-[11px] outline-none"></td>
                            <td class="p-2"><input type="date" value="${v.expiry}" onchange="updateVariantData(${i}, 'expiry', this.value)" class="w-full p-2 border border-slate-100 rounded text-[11px] font-bold text-red-500 outline-none"></td>
                            <td class="p-2 text-right"><input type="number" value="${v.tp}" onchange="updateVariantData(${i}, 'tp', this.value)" class="w-full p-2 border border-slate-100 rounded text-[11px] text-right font-black outline-none italic"></td>
                            <td class="p-2 text-center"><input type="number" value="${v.stock}" onchange="updateVariantData(${i}, 'stock', this.value)" class="w-full p-2 border border-slate-100 rounded text-[11px] text-center font-black outline-none"></td>
                            <td class="p-2 text-center"><button onclick="currentTempVariants.splice(${i},1);updateVariantTable();" class="text-red-200 hover:text-red-500 transition"><i class="fa-solid fa-circle-minus text-base"></i></button></td>
                        </tr>`).join('');
            }

            window.updateVariantData = (index, field, value) => {
                currentTempVariants[index][field] = value;
                if (field === 'tp' || field === 'stock') {
                    currentTempVariants[index].subtotal = (parseFloat(currentTempVariants[index].tp) || 0) * (parseInt(currentTempVariants[index].stock) || 0);
                }
            };

            window.addNewEmptyVariant = () => {
                currentTempVariants.push({ sku: '', batch: '', expiry: '', tp: 0, stock: 1, subtotal: 0 });
                updateVariantTable();
            };

            window.openProductModal = () => {
                editingProductIndex = null;
                document.getElementById('productModalTitle').innerText = "Catalogue Selection";
                currentTempVariants = []; updateVariantTable();
                document.getElementById('p_name').value = '';
                document.getElementById('p_manufacturer').value = '';
                document.getElementById('p_manufacturer').readOnly = false;
                animateOpen(document.getElementById('productModal'), document.getElementById('productModalBox'));
            };

            window.closeProductModal = () => animateClose(document.getElementById('productModal'), document.getElementById('productModalBox'));

            window.addProductToPO = () => {
                const pName = document.getElementById('p_name').value;
                const pManufacturer = document.getElementById('p_manufacturer').value;
                if (!pName || currentTempVariants.length === 0) return alert('Product name and variants are required');
                const productTotal = currentTempVariants.reduce((sum, v) => sum + (v.subtotal || 0), 0);
                const productData = { name: pName, manufacturer: pManufacturer, category: document.getElementById('p_category').value, variants: [...currentTempVariants], total: productTotal };
                if (editingProductIndex !== null) poItemsList[editingProductIndex] = productData;
                else poItemsList.push(productData);
                updatePOTable(); closeProductModal();
            };

            function updatePOTable() {
                const tbody = document.getElementById('poProductsTbody');
                if (poItemsList.length === 0) { tbody.innerHTML = '<tr><td colspan="4" class="p-10 text-center italic text-slate-400 font-black uppercase tracking-widest text-[10px]">No items in manifest.</td></tr>'; return; }
                tbody.innerHTML = poItemsList.map((p, i) => `
                        <tr class="border-b bg-white hover:bg-slate-50 transition">
                            <td class="p-3"><div class="font-black text-slate-800 uppercase tracking-tighter italic text-sm">${p.name}</div><div class="text-[9px] text-slate-400 font-bold mt-0.5 leading-tight uppercase">${p.variants.map(v => v.sku).join(', ')}</div></td>
                            <td class="p-3 text-xs tracking-tighter"><span class="text-slate-500 block uppercase font-bold">${p.manufacturer}</span><span class="font-black text-amber-600 uppercase text-[9px]">${p.variants.length} SKU(S)</span></td>
                            <td class="p-3 text-right font-black text-slate-900 italic text-sm">PKR ${p.total.toLocaleString()}</td>
                            <td class="p-3 text-center"><div class="flex justify-center gap-3"><i class="fa-solid fa-pencil text-slate-300 hover:text-amber-500 cursor-pointer" onclick="editProductInPO(${i})"></i><i class="fa-solid fa-trash-can text-red-200 hover:text-red-500 cursor-pointer" onclick="poItemsList.splice(${i},1);updatePOTable();"></i></div></td>
                        </tr>`).join('');
            }

            window.editProductInPO = (index) => {
                editingProductIndex = index;
                const product = poItemsList[index];
                document.getElementById('productModalTitle').innerText = "Update Selection";
                document.getElementById('p_name').value = product.name;
                document.getElementById('p_manufacturer').value = product.manufacturer;
                document.getElementById('p_category').value = product.category;
                currentTempVariants = [...product.variants];
                updateVariantTable();
                animateOpen(document.getElementById('productModal'), document.getElementById('productModalBox'));
            };

            window.submitFinalPO = async () => {
                if(poItemsList.length === 0) return alert('Order manifest is empty');
                const payload = {
                    _token: "{{ csrf_token() }}",
                    supplier: document.getElementById('po_supplier').value,
                    date: document.getElementById('po_date').value,
                    status: document.getElementById('po_status').value,
                    total_amount: poItemsList.reduce((sum, p) => sum + p.total, 0),
                    products: poItemsList.map(p => ({
                        ...p,
                        variants: p.variants.map(v => ({
                            ...v,
                            expiry: v.expiry ? v.expiry : null
                        }))
                    }))
                };
                const url = isEditMode ? `/purchase-orders/${editPoId}` : "{{ route('po.store') }}";
                try {
                    const response = await fetch(url, { method: isEditMode ? "PUT" : "POST", headers: { "Content-Type": "application/json" }, body: JSON.stringify(payload) });
                    if (response.ok) window.location.reload();
                    else { const res = await response.json(); alert(res.message); }
                } catch (e) { alert('Network Error'); }
            };

            window.editPO = async (id) => {
                const response = await fetch(`/purchase-orders/${id}/edit`);
                const po = await response.json();
                isEditMode = true; editPoId = id;
                document.getElementById('po_supplier').value = po.supplier_name;
                document.getElementById('po_date').value = po.order_date;
                document.getElementById('po_status').value = po.status;
                poItemsList = po.items.map(item => ({
                    name: item.product_name, manufacturer: item.manufacturer, category: 'General',
                    variants: item.variants.map(v => ({ sku: v.sku, batch: v.batch_no, expiry: v.expiry_date || '', tp: v.purchase_price, stock: v.quantity, subtotal: v.purchase_price * v.quantity })),
                    total: item.variants.reduce((sum, v) => sum + (v.purchase_price * v.quantity), 0)
                }));
                updatePOTable();
                window.dispatchEvent(new CustomEvent('open-po-modal', { detail: { editMode: true } }));
            };

            window.deletePO = async (id) => {
                if (confirm('Permanently delete this PO record?')) {
                    await fetch(`/purchase-orders/${id}`, { method: 'DELETE', headers: { 'X-CSRF-TOKEN': "{{ csrf_token() }}" } });
                    window.location.reload();
                }
            };

            window.resetForm = () => { poItemsList = []; isEditMode = false; updatePOTable(); };
        </script>
    </main>
@endsection