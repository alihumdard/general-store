@extends('layouts.main')
@section('title', 'RetailPro | Inventory Catalogue')

@section('content')
<main class="h-screen overflow-y-auto p-2 sm:p-4 md:p-8 pt-24 bg-[#f1f5f9] flex flex-col">

    <div class="max-w-7xl mx-auto w-full">
        {{-- Page Header --}}
        <div class="flex flex-col md:flex-row md:items-end md:justify-between mb-6 pb-6 border-b border-slate-200 gap-4">
            <div class="text-center md:text-left">
                <h1 class="text-2xl md:text-3xl font-black text-slate-900 uppercase tracking-tighter italic">Inventory Catalogue</h1>
                <p class="text-xs md:text-sm text-slate-500 mt-1 font-medium">Manage pharmacy products and stock variants efficiently.</p>
            </div>
            
            <div class="grid grid-cols-2 md:flex items-center gap-2 sm:gap-3">
                <button onclick="window.location.href='{{ route('medicines.index') }}'" class="px-4 py-2.5 bg-white border border-slate-300 rounded-xl hover:bg-slate-50 flex items-center justify-center gap-2 shadow-sm transition text-xs font-bold text-slate-600">
                    <i class="fa-solid fa-rotate-right"></i> Reset
                </button>
                <button onclick="openProductModal()" class="px-4 py-2.5 bg-[#0f172a] hover:bg-slate-800 text-white rounded-xl shadow-xl font-black flex items-center justify-center gap-2 transition text-xs uppercase tracking-widest group">
                    <i class="fa-solid fa-plus group-hover:rotate-90 transition-transform"></i> Add Product
                </button>
            </div>
        </div>

        {{-- Search Bar --}}
        <div class="mb-6">
            <form action="{{ route('medicines.index') }}" method="GET" class="relative max-w-md w-full">
                <i class="fa-solid fa-search absolute left-4 top-1/2 -translate-y-1/2 text-slate-400"></i>
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Search name, batch, or SKU..."
                    class="w-full pl-11 pr-4 py-3 bg-white border border-slate-200 rounded-2xl outline-none text-sm text-slate-700 focus:ring-4 focus:ring-amber-500/20 focus:border-[#f59e0b] transition shadow-sm font-medium">
            </form>
        </div>

        {{-- DESKTOP VIEW: Table --}}
        <div class="hidden lg:block bg-white rounded-3xl shadow-xl border border-slate-100 overflow-hidden mb-10">
            <table class="w-full border-collapse text-sm">
                <thead class="bg-[#0f172a] text-white text-left">
                    <tr>
                        <th class="py-4 px-6 font-black uppercase tracking-widest text-[10px] italic">Medicine / SKU</th>
                        <th class="py-4 px-4 font-black uppercase tracking-widest text-[10px] italic">Batch #</th>
                        <th class="py-4 px-4 font-black uppercase tracking-widest text-[10px] italic">Expiry</th>
                        <th class="py-4 px-4 font-black uppercase tracking-widest text-[10px] italic">Stock</th>
                        <th class="py-4 px-4 font-black uppercase tracking-widest text-[10px] italic text-right">TP</th>
                        <th class="py-4 px-4 font-black uppercase tracking-widest text-[10px] italic text-right">MRP</th>
                        <th class="py-4 px-6 font-black uppercase tracking-widest text-[10px] italic text-center w-32">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($variants as $variant)
                    <tr class="hover:bg-slate-50 transition {{ $variant->stock_level <= $variant->reorder_level ? 'bg-red-50/50' : '' }}">
                        <td class="py-4 px-6 font-black text-slate-800">
                            {{ $variant->medicine->name }} <br> 
                            <span class="text-[9px] text-[#f59e0b] uppercase font-black tracking-wider">{{ $variant->sku }}</span>
                        </td>
                        <td class="py-4 px-4 text-slate-600 font-bold uppercase">{{ $variant->batch_no ?? '---' }}</td>
                        <td class="py-4 px-4">
                            <span class="font-bold {{ $variant->expiry_date && \Carbon\Carbon::parse($variant->expiry_date)->isPast() ? 'text-red-600' : 'text-slate-500' }}">
                                {{ $variant->expiry_date ? \Carbon\Carbon::parse($variant->expiry_date)->format('d M, Y') : 'N/A' }}
                            </span>
                        </td>
                        <td class="py-4 px-4">
                            <span class="font-black {{ $variant->stock_level <= $variant->reorder_level ? 'text-red-600' : 'text-emerald-600' }}">
                                {{ $variant->stock_level }}
                            </span>
                        </td>
                        <td class="py-4 px-4 text-right font-medium text-slate-500">PKR {{ number_format($variant->purchase_price, 2) }}</td>
                        <td class="py-4 px-4 text-right font-black text-slate-900">PKR {{ number_format($variant->sale_price, 2) }}</td>
                        <td class="py-4 px-6 text-center">
                            <div class="flex justify-center gap-3">
                                <button onclick='openEditModal({!! json_encode($variant) !!}, {!! json_encode($variant->medicine) !!})' class="text-slate-400 hover:text-[#f59e0b] transition">
                                    <i class="fa-solid fa-pen-to-square"></i>
                                </button>
                                <button onclick="deleteProduct({{ $variant->id }})" class="text-red-300 hover:text-red-600 transition">
                                    <i class="fa-solid fa-trash-can"></i>
                                </button>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr><td colspan="7" class="py-20 text-center text-slate-400 italic font-medium uppercase tracking-widest text-xs">No inventory matches found.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- MOBILE VIEW: Card Layout --}}
        <div class="lg:hidden grid grid-cols-1 sm:grid-cols-2 gap-4 mb-10">
            @forelse($variants as $variant)
            <div class="bg-white rounded-2xl p-4 shadow-md border border-slate-100 {{ $variant->stock_level <= $variant->reorder_level ? 'border-l-4 border-l-red-500' : 'border-l-4 border-l-[#f59e0b]' }}">
                <div class="flex justify-between items-start mb-3">
                    <div>
                        <h3 class="font-black text-slate-900 text-sm uppercase italic leading-tight">{{ $variant->medicine->name }}</h3>
                        <span class="text-[10px] text-[#f59e0b] font-black uppercase tracking-wider">{{ $variant->sku }}</span>
                    </div>
                    <div class="flex gap-2">
                        <button onclick='openEditModal({!! json_encode($variant) !!}, {!! json_encode($variant->medicine) !!})' class="w-8 h-8 rounded-lg bg-slate-50 text-slate-600 flex items-center justify-center hover:bg-[#f59e0b] hover:text-white transition-colors">
                            <i class="fa-solid fa-pen text-xs"></i>
                        </button>
                    </div>
                </div>
                <div class="grid grid-cols-2 gap-2 text-[11px] mb-3">
                    <div class="text-slate-500 font-bold uppercase">Batch: <span class="text-slate-800">{{ $variant->batch_no ?? '---' }}</span></div>
                    <div class="text-slate-500 text-right font-bold uppercase">Stock: <span class="font-black {{ $variant->stock_level <= $variant->reorder_level ? 'text-red-600' : 'text-emerald-600' }}">{{ $variant->stock_level }}</span></div>
                    <div class="text-slate-500 font-bold uppercase">Expiry: <span class="text-slate-800">{{ $variant->expiry_date ? \Carbon\Carbon::parse($variant->expiry_date)->format('d M, y') : 'N/A' }}</span></div>
                    <div class="text-[#f59e0b] text-right italic font-black text-sm">PKR {{ number_format($variant->sale_price, 0) }}</div>
                </div>
            </div>
            @empty
            <div class="py-10 text-center text-slate-400 italic font-black uppercase tracking-widest text-xs">No inventory matches found.</div>
            @endforelse
        </div>

        <div class="mt-8 flex justify-center">{{ $variants->appends(request()->input())->links() }}</div>
    </div>
</main>

{{-- MODAL: Product Entry --}}
<div id="productModal" class="fixed inset-0 bg-[#0f172a]/80 hidden flex justify-center items-center z-[100] p-2 sm:p-4 backdrop-blur-sm">
    <div id="productModalBox" class="bg-white w-full max-w-5xl rounded-3xl shadow-3xl flex flex-col overflow-hidden transform transition-all duration-300 scale-95 opacity-0 h-full max-h-[90vh]">
        <div class="p-5 border-b bg-[#0f172a] flex justify-between items-center">
            <h2 class="text-xl font-black text-[#f59e0b] italic uppercase tracking-tighter">Inventory Hub</h2>
            <button onclick="closeProductModal()" class="text-white hover:text-[#f59e0b] text-3xl font-light transition-colors">&times;</button>
        </div>
        
        <div class="flex-1 overflow-y-auto p-4 md:p-8 space-y-8 bg-[#f8fafc]">
            {{-- Form Inputs --}}
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <div class="relative">
                    <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest block mb-2">Medicine Name *</label>
                    <input id="p_name" oninput="filterMedicines(this.value)" autocomplete="off" class="w-full px-4 py-3 bg-white border border-slate-200 rounded-2xl outline-none focus:ring-4 focus:ring-amber-500/10 focus:border-[#f59e0b] font-bold text-sm shadow-sm" placeholder="Search product catalogue..." />
                    <div id="medicine_dropdown" class="absolute left-0 right-0 mt-2 bg-white rounded-2xl shadow-2xl border border-slate-100 hidden z-[110] max-h-48 overflow-y-auto overflow-hidden">
                        @foreach($allMedicines as $med)
                            <div class="dropdown-item p-3 hover:bg-slate-50 cursor-pointer border-b border-slate-50 last:border-0 flex flex-col transition" 
                                 data-name="{{ $med->name }}" data-generic="{{ $med->generic_name }}" data-manufacturer="{{ $med->manufacturer }}" data-variants="{{ json_encode($med->variants) }}" onclick="selectMedicine(this)">
                                <span class="font-black text-slate-800 text-xs">{{ $med->name }}</span>
                                <span class="text-[9px] text-slate-400 uppercase font-black">{{ $med->manufacturer }}</span>
                            </div>
                        @endforeach
                    </div>
                </div>
                <div>
                    <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest block mb-2">Generic Composition</label>
                    <input id="p_generic" class="w-full px-4 py-3 border border-slate-200 rounded-2xl bg-slate-50 text-sm outline-none font-bold text-slate-600 uppercase"  />
                </div>
                <div>
                    <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest block mb-2">Manufacturer</label>
                    <input id="p_man" class="w-full px-4 py-3 border border-slate-200 rounded-2xl bg-slate-50 text-sm outline-none font-bold text-slate-600 uppercase"  />
                </div>
            </div>

            {{-- Variants Table --}}
            <div class="bg-white rounded-3xl p-6 border border-slate-100 shadow-sm">
                <div class="flex items-center justify-between mb-6">
                    <h4 class="font-black text-slate-900 uppercase text-[10px] tracking-widest border-l-4 border-[#f59e0b] pl-3">Stock Variants & SKUs</h4>
                    <button onclick="addNewEmptyVariant()" class="px-5 py-2.5 bg-emerald-600 hover:bg-emerald-700 text-white rounded-xl shadow-lg text-[10px] font-black uppercase tracking-widest transition-transform active:scale-95">Add New SKU</button>
                </div>
                <div class="overflow-x-auto">
                    <table class="w-full text-xs min-w-[700px]">
                        <thead class="bg-slate-50 text-slate-400 font-black uppercase text-[9px]">
                            <tr class="text-left">
                                <th class="p-4">SKU Name</th>
                                <th class="p-4">Batch ID</th>
                                <th class="p-4">Expiry Date</th>
                                <th class="p-4 text-center">Current Stock</th>
                                <th class="p-4 text-right">Selling Price (MRP)</th>
                                <th class="p-4 w-12"></th>
                            </tr>
                        </thead>
                        <tbody id="variantsTbody" class="divide-y divide-slate-50 bg-white"></tbody>
                    </table>
                </div>
            </div>
        </div>

        <div class="p-6 border-t bg-slate-50 flex flex-col md:flex-row justify-end gap-3">
            <button onclick="closeProductModal()" class="w-full md:w-auto px-8 py-3 bg-white border border-slate-200 rounded-xl font-black text-slate-400 uppercase text-xs hover:bg-slate-100 transition shadow-sm">Discard Changes</button>
            <button id="saveProductBtn" class="w-full md:w-auto px-10 py-3 bg-[#0f172a] text-[#f59e0b] rounded-xl font-black shadow-xl uppercase text-xs tracking-widest hover:bg-slate-800 transition shadow-amber-500/10">Commit Inventory</button>
        </div>
    </div>
</div>

{{-- MODAL: Edit Variant --}}
<div id="editModal" class="fixed inset-0 bg-[#0f172a]/80 hidden flex justify-center items-center z-[100] p-2 sm:p-4 backdrop-blur-sm">
    <div id="editModalBox" class="bg-white w-full max-w-lg rounded-3xl shadow-2xl overflow-hidden transform transition-all duration-200 scale-95 opacity-0">
        <div class="p-5 border-b bg-[#0f172a] font-black uppercase italic text-[#f59e0b] text-lg">Update Variant</div>
        <form id="editForm" class="p-5 md:p-8 space-y-6 bg-[#f8fafc]">
            <input type="hidden" id="edit_variant_id">
            <input type="hidden" id="hidden_tp">
            
            <div class="space-y-4">
                <div>
                    <label class="text-[9px] font-black text-slate-400 uppercase tracking-widest block mb-1">Medicine Name</label>
                    <input type="text" id="edit_name" class="w-full border border-slate-200 rounded-2xl p-4 bg-white font-bold text-sm outline-none text-slate-400" readonly>
                </div>
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="text-[9px] font-black text-slate-400 uppercase tracking-widest block mb-1">SKU</label>
                        <input type="text" id="edit_sku" class="w-full border border-slate-200 rounded-2xl p-4 text-sm font-black text-slate-700 uppercase focus:border-[#f59e0b] outline-none" required>
                    </div>
                    <div>
                        <label class="text-[9px] font-black text-slate-400 uppercase tracking-widest block mb-1">Batch #</label>
                        <input type="text" id="edit_batch" class="w-full border border-slate-200 rounded-2xl p-4 text-sm font-bold text-slate-700 outline-none">
                    </div>
                </div>
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="text-[9px] font-black text-slate-400 uppercase tracking-widest block mb-1">Expiry Date</label>
                        <input type="date" id="edit_expiry" class="w-full border border-slate-200 rounded-2xl p-4 text-sm font-bold text-red-500 outline-none">
                    </div>
                    <div>
                        <label class="text-[9px] font-black text-slate-400 uppercase tracking-widest block mb-1">MRP Price</label>
                        <input type="number" step="0.01" id="edit_mrp" class="w-full border border-slate-200 rounded-2xl p-4 text-sm font-black text-emerald-600 outline-none">
                    </div>
                </div>
                <div>
                    <label class="text-[9px] font-black text-slate-400 uppercase tracking-widest block mb-1">Current Stock Level</label>
                    <input type="number" id="edit_stock" class="w-full border border-slate-200 rounded-2xl p-4 text-sm font-black text-slate-900 outline-none">
                </div>
            </div>
            
            <div class="mt-8 flex flex-col md:flex-row justify-end gap-3">
                <button type="button" onclick="closeEditModal()" class="order-2 md:order-1 px-6 py-3 bg-white border border-slate-200 rounded-xl font-black text-slate-400 uppercase text-[10px]">Cancel</button>
                <button type="submit" class="order-1 md:order-2 px-8 py-3 bg-[#0f172a] text-[#f59e0b] rounded-xl font-black shadow-lg uppercase text-[10px] tracking-widest">Apply Changes</button>
            </div>
        </form>
    </div>
</div>

@push('scripts')
<script>
    let currentVariants = [];

    // Table Update Logic with Theme
    function updateVariantTable() {
        const tbody = document.getElementById('variantsTbody');
        if (currentVariants.length === 0) {
            tbody.innerHTML = '<tr><td colspan="6" class="p-16 text-center text-slate-300 italic font-black uppercase tracking-widest text-[10px]">Select product or click Add SKU to begin.</td></tr>';
            return;
        }
        tbody.innerHTML = currentVariants.map((v, i) => `
            <tr class="hover:bg-slate-50 transition border-b border-slate-50">
                <td class="p-3">
                    <input type="text" value="${v.sku}" onchange="syncVariantData(${i}, 'sku', this.value)" 
                    class="w-full px-4 py-3 border border-slate-100 rounded-xl text-[11px] font-black text-[#f59e0b] uppercase focus:border-[#f59e0b] outline-none bg-white">
                </td>
                <td class="p-3">
                    <input type="text" value="${v.batch_no}" onchange="syncVariantData(${i}, 'batch_no', this.value)" 
                    placeholder="---" class="w-full px-4 py-3 border border-slate-100 rounded-xl text-[11px] font-bold text-slate-600 outline-none bg-white">
                </td>
                <td class="p-3">
                    <input type="date" value="${v.expiry_date}" onchange="syncVariantData(${i}, 'expiry_date', this.value)" 
                    class="w-full px-4 py-3 border border-slate-100 rounded-xl text-[11px] font-bold text-red-500 outline-none bg-white">
                </td>
                <td class="p-3 w-28">
                    <input type="number" value="${v.stock_level}" onchange="syncVariantData(${i}, 'stock_level', this.value)" 
                    class="w-full px-4 py-3 border border-slate-100 rounded-xl text-[11px] text-center font-black text-emerald-600 outline-none bg-white">
                </td>
                <td class="p-3 w-32">
                    <input type="number" value="${v.sale_price}" onchange="syncVariantData(${i}, 'sale_price', this.value)" 
                    class="w-full px-4 py-3 border border-slate-100 rounded-xl text-[11px] text-right font-black text-slate-900 outline-none italic bg-white">
                </td>
                <td class="p-3 text-center w-12">
                    <button onclick="currentVariants.splice(${i},1);updateVariantTable()" class="text-red-200 hover:text-red-500 p-2 transition-colors">
                        <i class="fa-solid fa-circle-minus text-xl"></i>
                    </button>
                </td>
            </tr>
        `).join('');
    }

    // Modal & Crud Helpers
    function animateOpen(m, b) { m.classList.remove('hidden'); m.classList.add('flex'); setTimeout(() => { b.classList.remove('scale-95', 'opacity-0'); b.classList.add('scale-100', 'opacity-100'); }, 10); }
    function closeEditModal() { const b = document.getElementById('editModalBox'); b.classList.add('scale-95', 'opacity-0'); setTimeout(() => { document.getElementById('editModal').classList.add('hidden'); }, 200); }
    function closeProductModal() { const b = document.getElementById('productModalBox'); b.classList.add('scale-95', 'opacity-0'); setTimeout(() => { document.getElementById('productModal').classList.add('hidden'); }, 200); }
    function openProductModal() { currentVariants = []; updateVariantTable(); ['p_name', 'p_generic', 'p_man'].forEach(i => document.getElementById(i).value = ''); animateOpen(document.getElementById('productModal'), document.getElementById('productModalBox')); }

    function syncVariantData(index, field, value) { currentVariants[index][field] = value; }
    function addNewEmptyVariant() { currentVariants.push({ sku: '', batch_no: '', expiry_date: '', stock_level: 1, sale_price: 0, purchase_price: 0 }); updateVariantTable(); }

    window.openEditModal = (variant, medicine) => {
        document.getElementById('edit_variant_id').value = variant.id;
        document.getElementById('edit_name').value = medicine.name;
        document.getElementById('edit_sku').value = variant.sku;
        document.getElementById('edit_batch').value = variant.batch_no || '';
        document.getElementById('edit_expiry').value = variant.expiry_date ? variant.expiry_date.split(' ')[0] : '';
        document.getElementById('edit_mrp').value = variant.sale_price;
        document.getElementById('edit_stock').value = variant.stock_level;
        document.getElementById('hidden_tp').value = variant.purchase_price;
        animateOpen(document.getElementById('editModal'), document.getElementById('editModalBox'));
    };

    // Form Submissions
    document.getElementById('editForm').addEventListener('submit', async (e) => {
        e.preventDefault();
        const payload = {
            _token: "{{ csrf_token() }}",
            name: document.getElementById('edit_name').value,
            sku: document.getElementById('edit_sku').value,
            batch_no: document.getElementById('edit_batch').value,
            expiry_date: document.getElementById('edit_expiry').value,
            sale_price: document.getElementById('edit_mrp').value,
            stock_level: document.getElementById('edit_stock').value,
            purchase_price: document.getElementById('hidden_tp').value || 0
        };
        const res = await fetch(`/medicines/${document.getElementById('edit_variant_id').value}`, { method: 'PUT', headers: { 'Content-Type': 'application/json', 'Accept': 'application/json' }, body: JSON.stringify(payload) });
        if((await res.json()).success) window.location.reload();
    });

    document.getElementById('saveProductBtn').addEventListener('click', async () => {
        if(!document.getElementById('p_name').value) { alert('Please enter medicine name'); return; }
        const payload = { _token: "{{ csrf_token() }}", name: document.getElementById('p_name').value, generic_name: document.getElementById('p_generic').value, manufacturer: document.getElementById('p_man').value, variants: currentVariants };
        const res = await fetch("{{ route('medicines.store') }}", { method: 'POST', headers: { 'Content-Type': 'application/json' }, body: JSON.stringify(payload) });
        if((await res.json()).success) window.location.reload();
    });

    window.deleteProduct = async (id) => {
        if(confirm('Delete SKU permanently?')) {
            const res = await fetch(`/medicines/${id}`, { method: 'DELETE', headers: { 'X-CSRF-TOKEN': "{{ csrf_token() }}", 'Accept': 'application/json' } });
            if((await res.json()).success) window.location.reload();
        }
    };
</script>
@endpush
@endsection