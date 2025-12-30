
<?php $__env->startSection('title', 'RetailPro | Checkout Terminal'); ?>

<?php $__env->startSection('content'); ?>
<main class="h-screen overflow-y-auto p-4 md:p-8 pt-20 bg-slate-50 flex flex-col">
    <div class="max-w-[1600px] mx-auto w-full">
        <div class="grid grid-cols-1 lg:grid-cols-[2.5fr_1.5fr] gap-6 items-stretch">

            
            <div class="bg-white rounded-3xl shadow-xl border border-slate-100 p-6 h-[85vh] flex flex-col">
                <div class="flex flex-col md:flex-row items-center justify-between mb-6 gap-4 border-b border-slate-50 pb-4">
                    <div>
                        <h2 class="text-2xl font-black text-slate-900 tracking-tighter uppercase leading-none italic">Product Catalogue</h2>
                        <p class="text-[10px] text-amber-600 font-bold uppercase tracking-widest mt-1">Inventory Management Terminal</p>
                    </div>
                    
                    
                    <div class="relative w-full max-w-md">
                        <i class="fa-solid fa-magnifying-glass absolute left-4 top-1/2 -translate-y-1/2 text-slate-400"></i>
                        <input id="productSearch" oninput="fetchProducts(1)"
                            class="w-full pl-11 pr-4 py-3 bg-slate-50 rounded-2xl border border-slate-200 focus:ring-4 focus:ring-amber-500/10 focus:border-amber-500 outline-none transition shadow-inner font-bold text-sm"
                            placeholder="Search by product name, SKU or barcode...">
                    </div>
                </div>

                
                <div id="productGrid" class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 xl:grid-cols-4 gap-4 flex-grow overflow-y-auto pr-2 py-2 content-start min-h-0 custom-scrollbar">
                    
                </div>

                
                <div id="paginationLinks" class="mt-4 pt-4 border-t border-slate-100 flex justify-center gap-2"></div>
            </div>

            
            <div class="bg-white rounded-3xl shadow-xl border border-slate-100 p-6 h-[85vh] flex flex-col overflow-hidden">
                <div class="border-b border-slate-100 pb-4 mb-4">
                    <div class="flex justify-between items-center">
                        <h3 class="text-xl font-black text-slate-900 tracking-tighter uppercase leading-none italic">Sale Receipt</h3>
                        <span class="text-[10px] bg-slate-100 px-2 py-1 rounded-lg font-black text-slate-500 uppercase tracking-widest">Order #<?php echo e(date('ymd')); ?>-<?php echo e(rand(10,99)); ?></span>
                    </div>
                    
                    <div class="mt-4 flex items-center gap-3">
                        <select id="customerSelect" class="flex-1 px-4 py-2.5 border border-slate-200 rounded-xl bg-slate-50 text-sm font-bold focus:ring-4 focus:ring-amber-500/10 outline-none">
                            <option value="walkin">Walk-in Customer</option>
                            <?php $__currentLoopData = $customers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $customer): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($customer->id); ?>">
                                    <?php echo e($customer->customer_name); ?> (Ledger: <?php echo e(number_format($customer->credit_balance, 0)); ?>)
                                </option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>
                    </div>
                </div>

                
                <div id="cartList" class="flex-grow space-y-3 overflow-y-auto pr-2 mb-4 custom-scrollbar">
                    
                </div>

                
                <div class="mt-auto space-y-3 bg-slate-900 p-5 rounded-3xl shadow-2xl">
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="text-[9px] font-black text-slate-400 uppercase ml-1">Discount (PKR)</label>
                            <input type="number" id="discountInput" oninput="calculateTotals()" value="0" 
                                class="w-full px-3 py-2 bg-slate-800 border border-slate-700 rounded-xl text-sm font-black text-[#f59e0b] outline-none focus:ring-2 focus:ring-amber-500/50">
                        </div>
                        <div>
                            <label class="text-[9px] font-black text-slate-400 uppercase ml-1">Other Charges</label>
                            <input type="number" id="serviceInput" oninput="calculateTotals()" value="0" 
                                class="w-full px-3 py-2 bg-slate-800 border border-slate-700 rounded-xl text-sm font-black text-slate-300 outline-none focus:ring-2 focus:ring-slate-500/50">
                        </div>
                    </div>

                    <div class="flex justify-between items-center pt-2 border-t border-slate-800 text-xs font-bold text-slate-400 uppercase tracking-widest">
                        <span>Subtotal</span>
                        <span id="subtotal" class="text-white">0.00</span>
                    </div>

                    <div class="flex justify-between items-end text-[#f59e0b]">
                        <span class="text-xs font-black uppercase tracking-tighter">Net Total</span>
                        <span id="grandTotal" class="text-2xl font-black italic tracking-tighter leading-none">PKR 0.00</span>
                    </div>

                    
                    <div class="pt-3 border-t border-slate-800">
                        <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest ml-1 block mb-1">Cash Received</label>
                        <input type="number" id="cashReceived" oninput="calculateTotals()" placeholder="0.00" 
                               class="w-full px-3 py-2 bg-slate-800 border-2 border-[#f59e0b] rounded-2xl text-xl font-black text-white outline-none focus:ring-4 focus:ring-amber-500/20 transition-all shadow-lg">
                    </div>

                    <div id="balanceBox" class="flex justify-between items-center px-2 mt-1">
                        <span id="balanceLabel" class="text-[10px] font-bold uppercase text-slate-500">Change Return</span>
                        <span id="balanceAmount" class="text-lg font-black text-white">0.00</span>
                    </div>
                </div>

                
                <div class="grid grid-cols-2 gap-3 mt-6">
                    <button onclick="processCheckout('cash')" class="bg-slate-900 text-white py-4 rounded-2xl shadow-lg hover:bg-black font-black uppercase text-xs tracking-widest transition active:scale-95 border border-slate-700">
                        <i class="fa-solid fa-receipt mr-2 text-amber-500"></i> Cash Sale
                    </button>
                    <button onclick="processCheckout('credit')" class="bg-[#f59e0b] text-slate-900 py-4 rounded-2xl shadow-lg hover:bg-amber-600 font-black uppercase text-xs tracking-widest transition active:scale-95">
                        <i class="fa-solid fa-book mr-2"></i> Post Ledger
                    </button>
                </div>
            </div>
        </div>
    </div>
</main>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('scripts'); ?>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    let cart = [];

    // 1. FETCH PRODUCTS via AJAX
    async function fetchProducts(page = 1) {
        const search = document.getElementById('productSearch').value;
        const grid = document.getElementById('productGrid');
        const pagination = document.getElementById('paginationLinks');

        grid.innerHTML = '<div class="col-span-full py-20 text-center"><i class="fa-solid fa-spinner fa-spin text-3xl text-amber-500"></i></div>';

        try {
            const response = await fetch(`<?php echo e(route('pos.search')); ?>?page=${page}&search=${encodeURIComponent(search)}`);
            const data = await response.json();
            
            renderGrid(data.data);
            renderPagination(data);
        } catch (error) {
            grid.innerHTML = '<div class="col-span-full py-20 text-center text-red-500 font-black uppercase text-xs">Sync Failed. Check Internet Connection.</div>';
        }
    }

    // 2. RENDER PRODUCT GRID
    function renderGrid(products) {
        const grid = document.getElementById('productGrid');
        grid.innerHTML = products.length === 0 ? '<div class="col-span-full py-20 text-center text-slate-400 italic font-black uppercase text-xs tracking-widest">No matching products in store</div>' : '';
        
        products.forEach(p => {
            const lowStock = p.stock_level < 10;
            const stockBadge = lowStock ? 'bg-red-50 text-red-600 border-red-100' : 'bg-slate-50 text-slate-600 border-slate-100';
            
            grid.innerHTML += `
                <div class="product-card group relative p-4 border border-slate-100 rounded-2xl bg-white shadow-sm hover:shadow-xl hover:border-amber-400 transition-all duration-300 cursor-pointer flex flex-col justify-between h-[200px]"
                     onclick="addToCart(${p.id}, '${p.medicine.name.replace(/'/g, "\\'")}', ${p.sale_price || 0}, '${p.sku}', ${p.stock_level})">
                    <div class="flex justify-between items-start">
                        <span class="px-2 py-1 border rounded-lg text-[9px] font-black uppercase ${stockBadge}">${lowStock ? 'Low Stock: ' : 'Stock: '}${p.stock_level}</span>
                        <i class="fa-solid fa-tag text-slate-200 group-hover:text-amber-500 transition-colors"></i>
                    </div>
                    <div class="mt-2">
                        <h4 class="font-black text-sm text-slate-800 leading-tight line-clamp-2 uppercase italic">${p.medicine.name}</h4>
                        <p class="text-[9px] font-bold text-slate-400 mt-1 uppercase tracking-widest">SKU: ${p.sku}</p>
                    </div>
                    <div class="mt-4 pt-3 border-t border-slate-50 flex items-center justify-between">
                        <div>
                            <span class="text-lg font-black text-slate-900 italic tracking-tighter">
                                <span class="text-[10px] font-bold text-slate-400 not-italic uppercase">PKR</span> ${Number(p.sale_price).toLocaleString()}
                            </span>
                        </div>
                        <div class="w-8 h-8 rounded-xl bg-slate-900 text-[#f59e0b] flex items-center justify-center shadow-lg transform group-hover:rotate-12 transition-transform">
                            <i class="fa-solid fa-plus text-xs"></i>
                        </div>
                    </div>
                </div>`;
        });
    }

    // 3. RENDER PAGINATION
    function renderPagination(data) {
        const container = document.getElementById('paginationLinks');
        container.innerHTML = '';
        if (data.last_page > 1) {
            for (let i = 1; i <= data.last_page; i++) {
                const active = i === data.current_page ? 'bg-slate-900 text-amber-500 shadow-lg' : 'bg-white text-slate-500 border border-slate-200 hover:bg-slate-50';
                container.innerHTML += `<button onclick="fetchProducts(${i})" class="px-3 py-1.5 rounded-xl font-black text-[10px] transition ${active}">${i}</button>`;
            }
        }
    }

    // 4. CART LOGIC
    window.addToCart = function (id, name, price, sku, stock) {
        const item = cart.find(i => i.id === id);
        if (item) {
            if (item.quantity < stock) {
                item.quantity++;
                item.total = item.quantity * item.unitPrice;
            } else { Swal.fire({ title: 'Limit Reached', text: 'Insufficient stock in inventory', icon: 'warning', confirmButtonColor: '#0f172a' }); }
        } else {
            if (stock > 0) {
                cart.push({ id, name, unitPrice: price, quantity: 1, total: price, sku, stock });
            } else {
                Swal.fire({ title: 'Out of Stock', text: 'Item unavailable', icon: 'error', confirmButtonColor: '#0f172a' });
            }
        }
        renderCart();
    };

    function renderCart() {
        const list = document.getElementById('cartList');
        list.innerHTML = cart.length === 0 ? '<div class="text-center py-24 text-slate-300 italic font-black uppercase text-[10px] tracking-widest">Ready for Sale</div>' : '';
        
        cart.forEach(item => {
            list.innerHTML += `
                <div class="cart-item flex justify-between items-center bg-white p-4 rounded-2xl border border-slate-100 shadow-sm animate-in fade-in slide-in-from-right-2">
                    <div class="flex flex-col">
                        <p class="font-black text-xs text-slate-800 uppercase italic tracking-tight">${item.name}</p>
                        <p class="text-[9px] font-bold text-amber-600 uppercase tracking-widest">${item.sku} | Unit: ${item.unitPrice}</p>
                    </div>
                    <div class="flex items-center gap-3">
                        <div class="flex items-center bg-slate-50 border border-slate-200 rounded-xl overflow-hidden">
                            <button onclick="updateQty(${item.id}, -1)" class="px-2.5 py-1 hover:bg-slate-200"><i class="fa-solid fa-minus text-[10px]"></i></button>
                            <span class="px-2 font-black text-xs text-slate-800">${item.quantity}</span>
                            <button onclick="updateQty(${item.id}, 1)" class="px-2.5 py-1 hover:bg-slate-200"><i class="fa-solid fa-plus text-[10px]"></i></button>
                        </div>
                        <p class="font-black text-xs w-16 text-right text-slate-900 italic">${item.total.toLocaleString()}</p>
                        <button onclick="removeItem(${item.id})" class="text-slate-300 hover:text-red-500 transition ml-1"><i class="fa-solid fa-trash-can text-sm"></i></button>
                    </div>
                </div>`;
        });
        calculateTotals();
    }

    // 5. CALCULATION LOGIC
    function calculateTotals() {
        let subtotal = cart.reduce((sum, i) => sum + i.total, 0);
        let discount = parseFloat(document.getElementById('discountInput').value) || 0;
        let otherCharges = parseFloat(document.getElementById('serviceInput').value) || 0;
        let cashReceived = parseFloat(document.getElementById('cashReceived').value) || 0;

        let grandTotal = (subtotal + otherCharges) - discount;
        if (grandTotal < 0) grandTotal = 0;
        let balance = cashReceived - grandTotal;

        document.getElementById('subtotal').innerText = subtotal.toLocaleString();
        document.getElementById('grandTotal').innerText = `PKR ${grandTotal.toLocaleString()}`;
        
        const balanceElem = document.getElementById('balanceAmount');
        const labelElem = document.getElementById('balanceLabel');
        
        if (balance >= 0) {
            labelElem.innerText = "Change Return";
            balanceElem.innerText = balance.toLocaleString();
            balanceElem.className = "text-lg font-black text-white";
        } else {
            labelElem.innerText = "Balance Due";
            balanceElem.innerText = Math.abs(balance).toLocaleString();
            balanceElem.className = "text-lg font-black text-red-500";
        }
    }

    window.updateQty = (id, change) => {
        const item = cart.find(i => i.id === id);
        if (item) {
            if (change > 0 && item.quantity >= item.stock) return Swal.fire('Limit', 'Max stock reached', 'info');
            item.quantity += change;
            if (item.quantity <= 0) return removeItem(id);
            item.total = item.quantity * item.unitPrice;
            renderCart();
        }
    };

    window.removeItem = (id) => { cart = cart.filter(i => i.id !== id); renderCart(); };

    // 6. PROCESS CHECKOUT
    async function processCheckout(method) {
        if (cart.length === 0) return Swal.fire('Basket Empty', 'Add products before processing', 'info');

        let subtotal = cart.reduce((sum, i) => sum + i.total, 0);
        let discount = parseFloat(document.getElementById('discountInput').value) || 0;
        let charges = parseFloat(document.getElementById('serviceInput').value) || 0;
        let cashReceived = parseFloat(document.getElementById('cashReceived').value) || 0;
        let finalTotal = (subtotal + charges) - discount;

        const payload = {
            customer_id: document.getElementById('customerSelect').value,
            payment_method: method,
            items: cart.map(i => ({ variant_id: i.id, quantity: i.quantity })),
            subtotal: subtotal,
            discount: discount,
            service_charges: charges,
            cash_received: cashReceived,
            total_amount: finalTotal
        };

        // Basic Guard
        if (payload.customer_id === 'walkin' && method === 'credit') {
            return Swal.fire('Access Denied', 'Walk-in customers must pay full cash.', 'error');
        }

        Swal.fire({
            title: 'Processing Transaction...',
            didOpen: () => Swal.showLoading(),
            allowOutsideClick: false
        });

        try {
            const response = await fetch("<?php echo e(route('pos.checkout')); ?>", {
                method: "POST",
                headers: { "Content-Type": "application/json", "X-CSRF-TOKEN": "<?php echo e(csrf_token()); ?>" },
                body: JSON.stringify(payload)
            });
            const res = await response.json();
            if (res.success) {
                Swal.fire({
                    title: 'Sale Successful',
                    text: 'Invoice generated and stock updated.',
                    icon: 'success',
                    confirmButtonColor: '#0f172a'
                }).then(() => location.reload());
            } else {
                Swal.fire('Error', res.message || 'Transaction Failed', 'error');
            }
        } catch (e) {
            Swal.fire('Connection Error', 'System could not reach the server.', 'error');
        }
    }

    // Init
    document.addEventListener('DOMContentLoaded', () => { fetchProducts(1); renderCart(); });
</script>

<style>
    .custom-scrollbar::-webkit-scrollbar { width: 5px; }
    .custom-scrollbar::-webkit-scrollbar-track { background: transparent; }
    .custom-scrollbar::-webkit-scrollbar-thumb { background: #cbd5e1; border-radius: 10px; }
    .animate-in { animation: fadeIn 0.3s ease-out; }
    @keyframes fadeIn { from { opacity: 0; transform: translateY(10px); } to { opacity: 1; transform: translateY(0); } }
</style>
<?php $__env->stopPush(); ?>
<?php echo $__env->make('layouts.main', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH E:\code_2\general-store\resources\views/pages/pos.blade.php ENDPATH**/ ?>