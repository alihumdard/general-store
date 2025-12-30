
<?php $__env->startSection('title', 'RetailPro | Customer Accounts'); ?>

<?php $__env->startSection('content'); ?>
<main class="h-screen overflow-y-auto p-2 sm:p-4 md:p-8 pt-24 bg-[#f1f5f9] flex flex-col">
    <div class="max-w-[1600px] mx-auto w-full">
        
        
        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4 mb-8 border-b border-slate-200 pb-6">
            <div>
                <h1 class="text-xl sm:text-2xl md:text-3xl font-black text-slate-900 tracking-tighter italic uppercase leading-none">
                    Customer Registry
                </h1>
                <p class="text-[10px] text-amber-600 font-bold uppercase tracking-widest mt-2 flex items-center gap-2">
                    <span class="w-2 h-2 bg-amber-500 rounded-full animate-pulse"></span>
                    Manage Sales Ledgers & Outstanding Payments
                </p>
            </div>
            
            <button onclick="openModalForAdd()"
                class="w-full md:w-auto px-6 py-4 bg-[#0f172a] text-white rounded-2xl shadow-xl hover:bg-slate-800 font-black uppercase text-xs tracking-widest transition active:scale-95 flex items-center justify-center gap-2 group">
                <i class="fa-solid fa-user-plus group-hover:scale-110 transition-transform"></i> Add New Customer
            </button>
        </div>

        <div class="bg-white rounded-3xl shadow-xl border border-slate-100 p-4 sm:p-8">
            
            <div class="flex flex-col lg:flex-row lg:items-center justify-between gap-4 mb-8">
                <div class="relative w-full lg:w-1/3">
                    <i class="fa-solid fa-search absolute left-4 top-1/2 -translate-y-1/2 text-slate-400"></i>
                    <input type="text" id="searchInput" placeholder="Search by name or phone..."
                        class="w-full pl-11 pr-4 py-3 bg-slate-50 border border-slate-200 rounded-2xl outline-none text-sm font-bold focus:ring-4 focus:ring-amber-500/10 focus:border-[#f59e0b] transition shadow-inner"
                        oninput="debounceFetchData()">
                </div>

                <div class="w-full lg:w-auto">
                    <select id="creditFilter" onchange="fetchData()"
                        class="w-full px-5 py-3 bg-slate-50 border border-slate-200 rounded-2xl text-[10px] font-black uppercase tracking-widest outline-none focus:ring-4 focus:ring-amber-500/10 cursor-pointer">
                        <option value="">Status: All Accounts</option>
                        <option value="due">Unpaid (Balance > 0)</option>
                        <option value="paid">Cleared (Balance = 0)</option>
                    </select>
                </div>
            </div>

            
            <div class="hidden lg:block overflow-hidden rounded-2xl border border-slate-100 shadow-sm">
                <table class="w-full border-collapse text-sm">
                    <thead>
                        <tr class="bg-[#0f172a] text-white uppercase font-black text-[10px] tracking-widest italic">
                            <th class="py-5 px-6 text-left">Customer Name</th>
                            <th class="py-5 px-6 text-left">Contact Info</th>
                            <th class="py-5 px-6 text-right">Total Purchased</th>
                            <th class="py-5 px-6 text-right">Pending Balance</th>
                            <th class="py-5 px-6 text-center w-44">Manage</th>
                        </tr>
                    </thead>
                    <tbody id="customersTableBody" class="divide-y divide-slate-50 text-slate-800 bg-white">
                        
                    </tbody>
                </table>
            </div>

            
            <div id="customersCardContainer" class="lg:hidden grid grid-cols-1 sm:grid-cols-2 gap-4">
                
            </div>
            
            <div id="customersPagination" class="mt-8 flex justify-center gap-2"></div>
        </div>
    </div>
</main>


<div id="customerModal" class="fixed inset-0 z-50 hidden items-center justify-center p-4 bg-[#0f172a]/80 backdrop-blur-sm transition-all">
    <div id="customerModalBox" class="bg-white w-full max-w-2xl rounded-[40px] shadow-3xl overflow-hidden flex flex-col opacity-0 scale-95 transition-all duration-300">
        <div class="bg-[#0f172a] px-8 py-6 flex justify-between items-center text-white shrink-0">
            <div>
                <h3 class="text-2xl font-black uppercase italic tracking-tighter leading-none text-[#f59e0b]" id="modalTitle">Customer Profile</h3>
                <p class="text-[10px] font-bold uppercase tracking-widest mt-1 text-slate-400">Account Setup Terminal</p>
            </div>
            <button onclick="closeCustomerModal()" class="text-white hover:text-amber-500 text-3xl font-light transition-colors">&times;</button>
        </div>

        <form id="customerForm" onsubmit="handleFormSubmit(event)" class="p-8 overflow-y-auto bg-[#f8fafc]">
            <?php echo csrf_field(); ?>
            <div id="formAlerts" class="mb-6"></div>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="space-y-1">
                    <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest ml-1">Full Name *</label>
                    <input type="text" name="customer_name" id="f_name" required class="w-full px-4 py-3 bg-white border border-slate-200 rounded-2xl font-bold text-sm outline-none focus:border-amber-500 transition shadow-sm">
                </div>
                <div class="space-y-1">
                    <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest ml-1">Mobile Number *</label>
                    <input type="text" name="phone_number" id="f_phone" required class="w-full px-4 py-3 bg-white border border-slate-200 rounded-2xl font-bold text-sm outline-none focus:border-amber-500 transition shadow-sm">
                </div>
                <div class="md:col-span-2 p-6 bg-[#f1f5f9] rounded-3xl border border-slate-200 shadow-inner text-center">
                    <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2 block">Opening Debt Balance (PKR)</label>
                    <input type="number" step="0.01" name="credit_balance" id="f_balance" value="0.00" class="w-full px-5 py-4 border-2 border-white rounded-2xl bg-white font-black text-2xl text-slate-900 italic outline-none focus:ring-8 focus:ring-amber-500/10 transition shadow-sm">
                </div>
            </div>
            <div class="flex flex-col sm:flex-row justify-end gap-3 mt-8 border-t border-slate-200 pt-6">
                <button type="button" onclick="closeCustomerModal()" class="order-2 md:order-1 px-8 py-3 bg-white border border-slate-200 rounded-xl font-black text-slate-400 uppercase text-[10px] tracking-widest hover:bg-slate-50 transition">Discard</button>
                <button type="submit" id="saveCustomerBtn" class="order-1 md:order-2 px-10 py-3 bg-[#0f172a] text-[#f59e0b] rounded-xl font-black uppercase text-[10px] tracking-widest shadow-xl hover:bg-slate-800 transition active:scale-95">Save Account</button>
            </div>
        </form>
    </div>
</div>


<div id="historyModal" class="fixed inset-0 z-50 hidden items-center justify-center p-4 bg-[#0f172a]/90 backdrop-blur-sm transition-all">
    <div id="historyModalBox" class="bg-white w-full max-w-6xl rounded-[40px] shadow-3xl overflow-hidden flex flex-col max-h-[90vh] opacity-0 scale-95 transition-all duration-300">
        <div class="bg-[#0f172a] px-8 py-6 flex justify-between items-center text-white shrink-0">
            <div class="flex items-center gap-4">
                <div class="w-12 h-12 bg-slate-800 rounded-2xl flex items-center justify-center shadow-lg border border-slate-700">
                    <i class="fa-solid fa-receipt text-xl text-amber-500"></i>
                </div>
                <div>
                    <h2 id="historyCustomerName" class="text-2xl font-black italic tracking-tighter leading-none uppercase text-[#f59e0b]">Customer Statement</h2>
                    <div class="flex items-center gap-3 mt-1">
                        <span id="historyCustomerPhone" class="text-[10px] font-bold text-slate-400 uppercase tracking-widest"></span>
                        <button onclick="sendWhatsAppReminder()" class="bg-emerald-500/10 text-emerald-400 px-3 py-1 rounded-full text-[8px] font-black uppercase tracking-widest hover:bg-emerald-500 hover:text-white transition">
                            <i class="fa-brands fa-whatsapp mr-1"></i> WhatsApp Reminder
                        </button>
                    </div>
                </div>
            </div>
            <button onclick="closeHistoryModal()" class="text-white hover:text-amber-500 text-3xl font-light transition-colors">&times;</button>
        </div>

        <div class="flex flex-col lg:flex-row flex-grow overflow-hidden bg-slate-50">
            <div class="lg:w-2/3 flex-grow overflow-y-auto p-6 sm:p-8 border-r border-slate-200 bg-white custom-scrollbar">
                <h3 class="text-[10px] font-black uppercase text-slate-400 mb-6 tracking-widest italic border-l-4 border-amber-500 pl-3">Transaction Manifest</h3>
                <div id="historyContent" class="overflow-x-auto rounded-3xl border border-slate-50 shadow-sm"></div>
            </div>

            <div class="lg:w-1/3 p-6 sm:p-8 flex flex-col shrink-0 overflow-y-auto bg-[#f8fafc]">
                <div class="bg-white p-6 rounded-[30px] shadow-sm border border-amber-100 mb-8 text-center ring-8 ring-amber-50/30">
                    <p class="text-[9px] font-black text-amber-600 uppercase tracking-widest mb-1">Unpaid Balance</p>
                    <h4 id="ledgerTotalCredit" class="text-3xl font-black text-slate-900 tracking-tighter italic leading-none">PKR 0.00</h4>
                </div>

                <div class="bg-white p-6 rounded-[30px] border border-slate-200 shadow-inner">
                    <h3 class="text-xs font-black text-slate-800 mb-6 uppercase tracking-widest italic border-b pb-3 leading-none">Update Ledger</h3>
                    <div class="space-y-4">
                        <select id="manualType" class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-2xl font-bold text-sm outline-none focus:ring-4 focus:ring-amber-500/10 transition">
                            <option value="debit">Payment Received (Reduces Debt)</option>
                            <option value="credit">Add Manual Debt (Increases Debt)</option>
                        </select>
                        <input type="number" id="manualAmount" class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-2xl font-black text-lg outline-none focus:ring-4 focus:ring-amber-500/10" placeholder="0.00">
                        <button onclick="submitManualTransaction()" id="manualSubmitBtn" class="w-full py-4 bg-[#0f172a] text-[#f59e0b] rounded-2xl font-black uppercase text-xs tracking-widest shadow-xl hover:bg-slate-800 active:scale-95 transition">Sync Account</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('scripts'); ?>
<script>
    let activeCustomerId = null;
    let activeCustomerName = "";
    let activeCustomerPhone = "";
    let currentBalance = 0;
    let currentPage = 1;
    let debounceTimer;

    function openAnimate(m, b) {
        m.classList.remove("hidden"); m.classList.add("flex");
        setTimeout(() => { b.classList.remove("opacity-0", "scale-95"); b.classList.add("scale-100", "opacity-100"); }, 10);
        document.body.style.overflow = 'hidden';
    }

    function closeAnimate(m, b) {
        b.classList.remove("scale-100", "opacity-100"); b.classList.add("opacity-0", "scale-95");
        setTimeout(() => { m.classList.add("hidden"); m.classList.remove("flex"); document.body.style.overflow = ''; }, 300);
    }

    window.openCustomerModal = () => openAnimate(document.getElementById("customerModal"), document.getElementById("customerModalBox"));
    window.closeCustomerModal = () => closeAnimate(document.getElementById("customerModal"), document.getElementById("customerModalBox"));
    window.openHistoryModal = () => openAnimate(document.getElementById("historyModal"), document.getElementById("historyModalBox"));
    window.closeHistoryModal = () => closeAnimate(document.getElementById("historyModal"), document.getElementById("historyModalBox"));

    window.openModalForAdd = () => {
        activeCustomerId = null;
        document.getElementById("customerForm").reset();
        document.getElementById("formAlerts").innerHTML = '';
        document.getElementById("modalTitle").innerText = 'Register Customer';
        openCustomerModal();
    }

    window.debounceFetchData = () => { clearTimeout(debounceTimer); debounceTimer = setTimeout(() => fetchData(1), 300); }

    window.fetchData = (page = 1) => {
        currentPage = page;
        const search = document.getElementById("searchInput").value;
        const filter = document.getElementById("creditFilter").value;
        const tBody = document.getElementById("customersTableBody");
        const cContainer = document.getElementById("customersCardContainer");

        tBody.innerHTML = '<tr><td colspan="5" class="py-20 text-center"><i class="fa-solid fa-spinner fa-spin text-3xl text-amber-500"></i></td></tr>';

        fetch(`<?php echo e(route('customers.fetch')); ?>?page=${page}&search=${search}&credit_filter=${filter}`)
            .then(res => res.json())
            .then(data => {
                let tHtml = ''; let cHtml = '';
                const customers = data.data || [];

                if (customers.length > 0) {
                    customers.forEach(c => {
                        const bal = parseFloat(c.credit_balance || 0);
                        const balColor = bal > 0 ? 'text-red-600' : 'text-emerald-600';
                        const balBg = bal > 0 ? 'bg-red-50 border-red-100' : 'bg-emerald-50 border-emerald-100';
                        const safeName = c.customer_name ? c.customer_name.replace(/'/g, "\\'") : "User";

                        tHtml += `<tr class="hover:bg-slate-50 transition group">
                            <td class="py-5 px-6 font-black text-slate-900 uppercase italic tracking-tighter text-sm">${c.customer_name}</td>
                            <td class="py-5 px-6 font-bold text-slate-500 italic text-xs">${c.phone_number || '---'}</td>
                            <td class="py-5 px-6 text-right font-bold text-slate-400">PKR ${Number(c.total_purchases || 0).toLocaleString()}</td>
                            <td class="py-5 px-6 text-right font-black italic tracking-tighter ${balColor}">PKR ${bal.toLocaleString(undefined, {minimumFractionDigits: 2})}</td>
                            <td class="py-5 px-6 text-center">
                                <div class="flex justify-center gap-2">
                                    <button onclick="viewCustomerHistory(${c.id})" class="w-9 h-9 rounded-xl bg-slate-50 text-slate-400 flex items-center justify-center hover:bg-[#f59e0b] hover:text-white transition"><i class="fa-solid fa-receipt text-xs"></i></button>
                                    <button onclick="editCustomer(${c.id})" class="w-9 h-9 rounded-xl bg-slate-50 text-slate-400 flex items-center justify-center hover:bg-[#0f172a] hover:text-white transition"><i class="fa-solid fa-pen-to-square text-xs"></i></button>
                                    <button onclick="deleteCustomer(${c.id}, '${safeName}')" class="w-9 h-9 rounded-xl bg-red-50 text-red-300 flex items-center justify-center hover:bg-red-600 hover:text-white transition"><i class="fa-solid fa-trash-can text-xs"></i></button>
                                </div>
                            </td>
                        </tr>`;

                        cHtml += `<div class="bg-white p-5 rounded-3xl border border-slate-100 shadow-sm flex flex-col gap-3">
                            <div class="flex justify-between items-start">
                                <div><h3 class="font-black text-slate-900 uppercase italic tracking-tighter leading-tight">${c.customer_name}</h3><p class="text-[9px] font-bold text-slate-400 mt-1 italic">${c.phone_number || '---'}</p></div>
                                <div class="px-3 py-1 rounded-full ${balBg} border ${balColor} text-[10px] font-black italic">PKR ${bal.toLocaleString()}</div>
                            </div>
                            <div class="flex gap-2 pt-2 border-t border-slate-50">
                                <button onclick="viewCustomerHistory(${c.id})" class="flex-1 py-3 bg-slate-900 text-white rounded-xl text-[10px] font-black uppercase"><i class="fa-solid fa-file-invoice mr-2"></i>Ledger</button>
                                <button onclick="editCustomer(${c.id})" class="w-12 h-12 bg-slate-100 text-slate-600 rounded-xl"><i class="fa-solid fa-pen"></i></button>
                                <button onclick="deleteCustomer(${c.id}, '${safeName}')" class="w-12 h-12 bg-red-50 text-red-500 rounded-xl"><i class="fa-solid fa-trash"></i></button>
                            </div>
                        </div>`;
                    });
                } else {
                    const empty = '<div class="py-20 text-center text-slate-300 italic font-black uppercase tracking-widest text-xs">No records found</div>';
                    tHtml = '<tr><td colspan="5">' + empty + '</td></tr>'; cHtml = empty;
                }
                tBody.innerHTML = tHtml; cContainer.innerHTML = cHtml;
                document.getElementById("customersPagination").innerHTML = generatePagination(data.links);
            });
    }

    window.generatePagination = (links) => {
        if (!links || links.length <= 3) return '';
        let h = '<div class="flex gap-2 flex-wrap justify-center">';
        links.forEach(l => {
            let label = l.label.replace('&laquo; Previous', '←').replace('Next &raquo;', '→');
            const activeClass = l.active ? 'bg-[#0f172a] text-[#f59e0b] shadow-lg' : 'bg-white text-slate-400 border border-slate-200 hover:bg-slate-50';
            if(l.url) {
                const page = new URL(l.url).searchParams.get('page');
                h += `<button onclick="fetchData(${page})" class="w-10 h-10 rounded-xl font-black text-xs transition ${activeClass}">${label}</button>`;
            } else {
                h += `<span class="w-10 h-10 rounded-xl flex items-center justify-center border border-slate-100 text-slate-300 text-xs font-bold">${label}</span>`;
            }
        });
        return h + '</div>';
    }

    window.editCustomer = (id) => {
        activeCustomerId = id;
        fetch(`/customers/${id}/edit`).then(res => res.json()).then(c => {
            document.getElementById("modalTitle").innerText = 'Update Profile';
            document.getElementById("f_name").value = c.customer_name;
            document.getElementById("f_phone").value = c.phone_number;
            document.getElementById("f_balance").value = c.credit_balance;
            openCustomerModal();
        });
    }

    window.deleteCustomer = (id, name) => {
        if (confirm(`Remove customer "${name}"?`)) {
            fetch(`/customers/${id}`, { method: 'POST', headers: { 'X-CSRF-TOKEN': '<?php echo e(csrf_token()); ?>', 'Content-Type': 'application/json' }, body: JSON.stringify({ _method: 'DELETE' }) }).then(() => fetchData(currentPage));
        }
    }

    window.viewCustomerHistory = (id) => {
        activeCustomerId = id;
        const hContent = document.getElementById('historyContent');
        hContent.innerHTML = '<div class="text-center py-20"><i class="fa-solid fa-spinner fa-spin text-4xl text-amber-500"></i></div>';
        openHistoryModal();

        fetch(`/customers/${id}/history`).then(res => res.json()).then(data => {
            activeCustomerName = data.customer.customer_name;
            activeCustomerPhone = data.customer.phone_number;
            currentBalance = parseFloat(data.customer.credit_balance);
            document.getElementById('historyCustomerName').innerText = activeCustomerName;
            document.getElementById('historyCustomerPhone').innerText = `METADATA: ${activeCustomerPhone}`;
            document.getElementById('ledgerTotalCredit').innerText = `PKR ${currentBalance.toLocaleString(undefined, {minimumFractionDigits: 2})}`;

            if (!data.history || data.history.length === 0) {
                hContent.innerHTML = '<div class="text-center py-20 text-slate-300 italic font-black uppercase tracking-widest text-[10px]">No ledger data found</div>';
                return;
            }

            let html = `<table class="w-full text-sm">
                <thead><tr class="text-left border-b bg-slate-50 text-slate-400 text-[10px] uppercase font-black tracking-widest italic"><th class="p-4">Timestamp</th><th class="p-4">Reference</th><th class="p-4 text-center">Nature</th><th class="p-4 text-right">Valuation</th></tr></thead>
                <tbody class="divide-y divide-slate-50 bg-white">`;

            data.history.forEach(entry => {
                const isDebit = entry.type === 'debit';
                const label = entry.category === 'Manual' ? (isDebit ? 'Payment' : 'Debt Manual') : (entry.type === 'credit' ? 'Credit Sale' : 'Cash Sale');
                const color = isDebit ? 'text-emerald-600 bg-emerald-50 border-emerald-100' : 'text-red-600 bg-red-50 border-red-100';
                const date = new Date(entry.date).toLocaleDateString('en-GB', {day:'2-digit', month:'short', year:'numeric'});

                html += `<tr class="hover:bg-slate-50 transition">
                    <td class="p-4 text-[10px] font-black text-slate-400 uppercase tracking-tighter whitespace-nowrap">${date}</td>
                    <td class="p-4 font-black text-slate-700 italic uppercase text-xs tracking-tight">${entry.reference}</td>
                    <td class="p-4 text-center"><span class="px-3 py-1 rounded-full text-[8px] font-black uppercase border ${color}">${label}</span></td>
                    <td class="p-4 text-right font-black text-slate-900 italic tracking-tighter leading-none">PKR ${parseFloat(entry.amount).toLocaleString()}</td>
                </tr>`;
            });
            hContent.innerHTML = html + '</tbody></table>';
        });
    }

    async function submitManualTransaction() {
        const amount = document.getElementById('manualAmount').value;
        if (!amount || amount <= 0) return alert("Enter amount");
        const btn = document.getElementById('manualSubmitBtn');
        btn.disabled = true; btn.innerHTML = '<i class="fa-solid fa-spinner fa-spin"></i>';
        try {
            const res = await fetch(`/customers/${activeCustomerId}/payment`, {
                method: 'POST', headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': '<?php echo e(csrf_token()); ?>' },
                body: JSON.stringify({ type: document.getElementById('manualType').value, amount })
            });
            if (res.ok) { document.getElementById('manualAmount').value = ''; viewCustomerHistory(activeCustomerId); fetchData(currentPage); }
        } finally { btn.disabled = false; btn.innerHTML = 'Sync Account'; }
    }

    async function handleFormSubmit(event) {
        event.preventDefault();
        const btn = document.getElementById("saveCustomerBtn");
        btn.disabled = true; btn.innerHTML = '<i class="fa-solid fa-spinner fa-spin"></i>';
        const formData = new FormData(event.target);
        const data = Object.fromEntries(formData.entries());
        const url = activeCustomerId ? `/customers/${activeCustomerId}` : '<?php echo e(route("customers.store")); ?>';
        if (activeCustomerId) data._method = 'PUT';
        try {
            const res = await fetch(url, {
                method: 'POST', headers: { 'X-CSRF-TOKEN': '<?php echo e(csrf_token()); ?>', 'Accept': 'application/json', 'Content-Type': 'application/json' },
                body: JSON.stringify(data)
            });
            if (res.ok) { closeCustomerModal(); fetchData(currentPage); }
            else { const result = await res.json(); document.getElementById("formAlerts").innerHTML = `<div class="p-4 bg-red-50 text-red-600 rounded-2xl border border-red-100 text-[10px] font-black uppercase tracking-widest">${result.message}</div>`; }
        } finally { btn.disabled = false; btn.innerHTML = 'Save Account'; }
    }

    window.sendWhatsAppReminder = () => {
        if (currentBalance <= 0) return alert("Account is clear!");
        const msg = `Dear ${activeCustomerName}, your store balance is PKR ${currentBalance.toLocaleString()}. Please clear it soon. Thank you!`;
        window.open(`https://wa.me/${activeCustomerPhone}?text=${encodeURIComponent(msg)}`, '_blank');
    }

    document.addEventListener('DOMContentLoaded', () => fetchData(1));
</script>
<style>
    .custom-scrollbar::-webkit-scrollbar { width: 4px; }
    .custom-scrollbar::-webkit-scrollbar-track { background: #f8fafc; }
    .custom-scrollbar::-webkit-scrollbar-thumb { background: #cbd5e1; border-radius: 10px; }
</style>
<?php $__env->stopPush(); ?>
<?php echo $__env->make('layouts.main', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH E:\code_2\general-store\resources\views/pages/customers.blade.php ENDPATH**/ ?>