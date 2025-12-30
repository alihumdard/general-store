
<?php $__env->startSection('title', 'RetailPro | Supplier Network'); ?>

<?php $__env->startSection('content'); ?>
    <main class="overflow-y-auto p-2 sm:p-4 md:p-8 min-h-[calc(100vh-70px)] mt-20 sm:mt-0">
        <div class="max-w-[1600px] mx-auto w-full">
            
            
            <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4 mb-8 border-b border-slate-200 pb-6">
                <div>
                    <h1 class="text-xl sm:text-2xl md:text-3xl font-black text-slate-900 tracking-tighter uppercase italic leading-none">
                       Supplier Network
                    </h1>
                    <p class="text-[10px] text-amber-600 font-bold uppercase tracking-widest mt-2 flex items-center gap-2">
                        <span class="w-2 h-2 bg-amber-500 rounded-full animate-pulse"></span>
                        Wholesale Partners & Procurement Ledgers
                    </p>
                </div>
                
                <button onclick="openModalForAdd()"
                    class="w-full md:w-auto px-6 py-3 bg-[#0f172a] text-white rounded-2xl shadow-xl hover:bg-slate-800 font-black uppercase text-xs tracking-widest transition active:scale-95 flex items-center justify-center gap-2 group">
                    <i class="fa-solid fa-plus group-hover:rotate-90 transition-transform"></i> Register New Supplier
                </button>
            </div>

            <div class="bg-white rounded-3xl shadow-xl border border-slate-100 p-4 sm:p-8">
                
                <div class="flex flex-col lg:flex-row lg:items-center justify-between gap-4 mb-8">
                    <div class="relative w-full lg:w-1/3">
                        <i class="fa-solid fa-search absolute left-4 top-1/2 -translate-y-1/2 text-slate-400"></i>
                        <input type="text" id="searchInput" placeholder="Search by Supplier name..."
                            class="w-full pl-11 pr-4 py-3 bg-slate-50 border border-slate-200 rounded-2xl outline-none text-sm font-bold focus:ring-4 focus:ring-amber-500/10 focus:border-[#f59e0b] transition shadow-inner"
                            oninput="debounceFetchData()">
                    </div>

                    <div class="w-full lg:w-auto">
                        <select id="balanceFilter" onchange="fetchData()"
                            class="w-full px-5 py-3 bg-slate-50 border border-slate-200 rounded-2xl text-[10px] font-black uppercase tracking-widest outline-none focus:ring-4 focus:ring-amber-500/10 transition cursor-pointer">
                            <option value="">Status: All Accounts</option>
                            <option value="due">Payables (Balance > 0)</option>
                            <option value="paid">Cleared (Balance = 0)</option>
                        </select>
                    </div>
                </div>

                
                <div class="hidden md:block overflow-hidden rounded-2xl border border-slate-100 shadow-sm">
                    <table class="w-full border-collapse text-sm">
                        <thead>
                            <tr class="bg-[#0f172a] text-white uppercase font-black text-[10px] tracking-widest italic">
                                <th class="py-5 px-6 text-left">Supplier</th>
                                <th class="py-5 px-6 text-left">Contact Person</th>
                                <th class="py-5 px-6 text-left">Contact Metadata</th>
                                <th class="py-5 px-6 text-right">Account Balance</th>
                                <th class="py-5 px-6 text-center w-40">Protocol</th>
                            </tr>
                        </thead>
                        <tbody id="suppliersTableBody" class="divide-y divide-slate-50 text-slate-800 bg-white">
                            
                        </tbody>
                    </table>
                </div>

                
                <div id="suppliersCardContainer" class="md:hidden grid grid-cols-1 gap-4">
                    
                </div>
                
                <div id="suppliersPagination" class="mt-8 flex justify-center gap-2">
                    
                </div>
            </div>
        </div>
    </main>

    
    <div id="historyModal" class="fixed inset-0 bg-[#0f172a]/80 hidden justify-center items-center z-[60] p-2 sm:p-4 backdrop-blur-sm transition-all">
        <div id="historyModalBox" class="bg-white w-full max-w-6xl max-h-[90vh] rounded-[40px] shadow-3xl flex flex-col overflow-hidden transform scale-95 opacity-0 transition-all duration-300">
            <div class="p-6 border-b flex justify-between items-center bg-[#0f172a] shrink-0 text-white">
                <div class="flex items-center gap-4">
                    <div class="w-12 h-12 bg-slate-800 rounded-2xl flex items-center justify-center shadow-lg border border-slate-700">
                        <i class="fa-solid fa-file-invoice-dollar text-xl text-amber-500"></i>
                    </div>
                    <div>
                        <h2 id="historySupplierName" class="text-lg sm:text-2xl font-black tracking-tighter uppercase italic leading-none text-[#f59e0b]">Supplier Statement</h2>
                        <span id="historySupplierPhone" class="text-[10px] font-bold text-slate-400 uppercase tracking-widest mt-1 block"></span>
                    </div>
                </div>
                <button onclick="closeHistoryModal()" class="w-10 h-10 rounded-2xl bg-white/10 flex items-center justify-center hover:bg-white/20 transition text-3xl font-light">&times;</button>
            </div>

            <div class="flex flex-col lg:flex-row flex-grow overflow-hidden bg-slate-50">
                
                <div class="lg:w-2/3 flex-grow overflow-y-auto p-6 border-r border-slate-200 custom-scrollbar bg-white">
                    <h3 class="text-[10px] font-black uppercase text-slate-400 mb-6 tracking-widest italic border-l-4 border-[#f59e0b] pl-3">Transaction Manifest</h3>
                    <div id="historyContent" class="overflow-x-auto rounded-3xl border border-slate-50 shadow-sm"></div>
                </div>

                
                <div class="lg:w-1/3 p-6 flex flex-col shrink-0 overflow-y-auto bg-[#f8fafc]">
                    <div class="bg-white p-6 rounded-[30px] shadow-sm border border-amber-100 mb-8 text-center ring-8 ring-amber-50/30">
                        <p class="text-[9px] font-black text-amber-600 uppercase tracking-widest mb-1">Total Payable Balance</p>
                        <h4 id="ledgerTotalDue" class="text-3xl font-black text-slate-900 tracking-tighter italic leading-none">PKR 0.00</h4>
                    </div>

                    <div class="bg-white p-6 rounded-[30px] border border-slate-200 shadow-inner">
                        <h3 class="text-xs font-black text-slate-800 mb-6 uppercase tracking-widest italic border-b pb-3 leading-none">Post Transaction</h3>
                        <div class="space-y-4">
                            <select id="manualType" class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-2xl font-bold text-sm outline-none focus:ring-4 focus:ring-amber-500/10">
                                <option value="debit">Cash Paid (Reduces Balance)</option>
                                <option value="credit">Stock Credit (Increases Balance)</option>
                            </select>
                            <input type="number" id="manualAmount" class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-2xl font-black text-lg outline-none focus:ring-4 focus:ring-amber-500/10" placeholder="Enter Amount 0.00">
                            <button onclick="submitManualTransaction()" id="manualSubmitBtn"
                                class="w-full py-4 bg-[#0f172a] text-[#f59e0b] rounded-2xl font-black uppercase text-xs tracking-widest shadow-xl hover:bg-slate-800 transition active:scale-95 mt-4">
                                Sync Account
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    
    <div id="supplierModal" class="fixed inset-0 bg-[#0f172a]/80 hidden justify-center items-center z-[60] p-2 sm:p-4 backdrop-blur-sm transition-all">
        <div id="supplierModalBox" class="bg-white w-full max-w-2xl max-h-[95vh] overflow-y-auto rounded-[40px] shadow-3xl p-8 transform scale-95 opacity-0 transition-all duration-300 flex flex-col">
            <div class="flex justify-between items-center mb-8 border-b border-slate-100 pb-5">
                <div>
                    <h2 class="text-xl sm:text-3xl font-black text-slate-900 tracking-tighter italic uppercase leading-none">Supplier Profile</h2>
                    <p class="text-[10px] font-bold text-amber-600 uppercase tracking-widest mt-1">Acquisition Metadata</p>
                </div>
                <button onclick="closeModal()" class="w-10 h-10 rounded-2xl bg-slate-100 flex items-center justify-center hover:bg-slate-200 transition text-3xl font-light">&times;</button>
            </div>

            <form id="supplierForm" onsubmit="handleFormSubmit(event)" class="space-y-6">
                <?php echo csrf_field(); ?>
                <div id="formAlerts"></div>
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                    <div class="space-y-1">
                        <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest ml-1">Supplier Name *</label>
                        <input type="text" name="supplier_name" required class="w-full px-4 py-3 border border-slate-200 rounded-2xl bg-slate-50 text-sm font-bold outline-none focus:ring-4 focus:ring-amber-500/10 transition">
                    </div>
                    <div class="space-y-1">
                        <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest ml-1">Contact Person</label>
                        <input type="text" name="contact_person" class="w-full px-4 py-3 border border-slate-200 rounded-2xl bg-slate-50 text-sm font-bold outline-none focus:ring-4 focus:ring-amber-500/10 transition">
                    </div>
                    <div class="space-y-1">
                        <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest ml-1">Mobile Contact</label>
                        <input type="text" name="phone_number" class="w-full px-4 py-3 border border-slate-200 rounded-2xl bg-slate-50 text-sm font-bold outline-none focus:ring-4 focus:ring-amber-500/10 transition">
                    </div>
                    <div class="space-y-1">
                        <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest ml-1">E-Commerce Address</label>
                        <input type="email" name="email" class="w-full px-4 py-3 border border-slate-200 rounded-2xl bg-slate-50 text-sm font-bold outline-none focus:ring-4 focus:ring-amber-500/10 transition">
                    </div>
                    <div class="sm:col-span-2 p-6 bg-[#f8fafc] rounded-[30px] border border-slate-200 shadow-inner">
                        <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2 block">Opening Liability Balance (PKR)</label>
                        <input type="number" step="0.01" name="balance_due" value="0.00" class="w-full px-5 py-4 border-2 border-white rounded-2xl bg-white font-black text-2xl text-slate-900 italic outline-none focus:ring-8 focus:ring-amber-50/50 shadow-sm">
                    </div>
                </div>
                <div class="flex flex-col sm:flex-row justify-end gap-3 mt-10 shrink-0">
                    <button type="button" onclick="closeModal()" class="order-2 md:order-1 px-8 py-4 bg-white border border-slate-200 rounded-xl font-black text-slate-400 uppercase text-[10px] tracking-widest">Discard</button>
                    <button type="submit" id="saveSupplierBtn" class="order-1 md:order-2 px-10 py-4 bg-[#0f172a] text-[#f59e0b] rounded-xl font-black uppercase text-[10px] tracking-widest shadow-xl hover:bg-slate-800 transition active:scale-95">Commit Registry</button>
                </div>
            </form>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('scripts'); ?>
<script>
    let activeSupplierId = null;
    let currentPage = 1;
    let debounceTimer;

    const modal = document.getElementById("supplierModal");
    const modalBox = document.getElementById("supplierModalBox");
    const form = document.getElementById("supplierForm");
    const saveButton = document.getElementById("saveSupplierBtn");
    const tableBody = document.getElementById("suppliersTableBody");
    const cardContainer = document.getElementById("suppliersCardContainer");

    function openModal() {
        modal.classList.replace("hidden", "flex");
        setTimeout(() => { 
            modalBox.classList.replace("opacity-0", "opacity-100"); 
            modalBox.classList.replace("scale-95", "scale-100"); 
        }, 10);
        document.body.style.overflow = 'hidden';
    }

    function closeModal() {
        modalBox.classList.replace("opacity-100", "opacity-0");
        modalBox.classList.replace("scale-100", "scale-95");
        setTimeout(() => { modal.classList.replace("flex", "hidden"); document.body.style.overflow = ''; }, 300);
    }

    function openModalForAdd() {
        form.reset(); activeSupplierId = null;
        document.getElementById("formAlerts").innerHTML = '';
        document.querySelector('#supplierModal h2').innerText = 'Register Supplier';
        if (form.querySelector('input[name="_method"]')) form.querySelector('input[name="_method"]').remove();
        openModal();
    }

    function closeHistoryModal() {
        const hModal = document.getElementById('historyModal');
        const hBox = document.getElementById('historyModalBox');
        hBox.classList.replace("opacity-100", "opacity-0");
        hBox.classList.replace("scale-100", "scale-95");
        setTimeout(() => { hModal.classList.replace("flex", "hidden"); }, 300);
    }

    function debounceFetchData() { clearTimeout(debounceTimer); debounceTimer = setTimeout(() => fetchData(1), 300); }

    function fetchData(page = 1) {
        currentPage = page;
        const search = document.getElementById("searchInput").value;
        const balance = document.getElementById("balanceFilter").value;
        
        const loader = '<tr><td colspan="5" class="py-20 text-center"><i class="fa-solid fa-spinner fa-spin text-3xl text-amber-500"></i></td></tr>';
        tableBody.innerHTML = loader;

        fetch(`<?php echo e(route('suppliers.fetch')); ?>?page=${page}&search=${search}&balance_filter=${balance}`)
            .then(res => res.json())
            .then(data => {
                let tableHtml = '';
                let cardHtml = '';

                if (data.data.length > 0) {
                    data.data.forEach(s => {
                        const bal = parseFloat(s.balance_due);
                        const balColor = bal > 0 ? 'text-red-600' : 'text-emerald-600';
                        const balBg = bal > 0 ? 'bg-red-50 border-red-100' : 'bg-emerald-50 border-emerald-100';

                        tableHtml += `
                            <tr class="hover:bg-slate-50 transition group">
                                <td class="py-5 px-6 font-black text-slate-900 uppercase tracking-tighter italic text-sm">${s.supplier_name}</td>
                                <td class="py-5 px-6 font-bold text-slate-600 uppercase text-xs">${s.contact_person || 'N/A'}</td>
                                <td class="py-5 px-6">
                                    <div class="text-xs font-black text-slate-800 italic">${s.phone_number || '---'}</div>
                                    <div class="text-[10px] text-slate-400 font-bold lowercase mt-1">${s.email || ''}</div>
                                </td>
                                <td class="py-5 px-6 text-right font-black italic tracking-tighter ${balColor}">
                                    <span class="text-[10px] font-bold text-slate-400 not-italic uppercase mr-1">PKR</span>${bal.toLocaleString(undefined, { minimumFractionDigits: 2 })}
                                </td>
                                <td class="py-5 px-6 text-center">
                                    <div class="flex justify-center gap-2">
                                        <button onclick="viewSupplierHistory(${s.id})" class="w-9 h-9 rounded-xl bg-slate-50 text-slate-400 flex items-center justify-center hover:bg-[#f59e0b] hover:text-white transition"><i class="fa-solid fa-file-invoice-dollar"></i></button>
                                        <button onclick="editSupplier(${s.id})" class="w-9 h-9 rounded-xl bg-slate-50 text-slate-400 flex items-center justify-center hover:bg-[#0f172a] hover:text-white transition"><i class="fa-solid fa-pen-to-square"></i></button>
                                        <button onclick="deleteSupplier(${s.id}, '${s.supplier_name}')" class="w-9 h-9 rounded-xl bg-red-50 text-red-300 flex items-center justify-center hover:bg-red-600 hover:text-white transition"><i class="fa-solid fa-trash-can"></i></button>
                                    </div>
                                </td>
                            </tr>`;

                        cardHtml += `
                            <div class="bg-white p-5 rounded-3xl border border-slate-100 shadow-sm flex flex-col gap-3">
                                <div class="flex justify-between items-start">
                                    <div>
                                        <h3 class="font-black text-slate-900 uppercase italic tracking-tighter leading-tight">${s.supplier_name}</h3>
                                        <p class="text-[10px] font-bold text-amber-600 uppercase tracking-widest mt-1">Contact Person: ${s.contact_person || 'N/A'}</p>
                                    </div>
                                    <div class="px-3 py-1 rounded-full ${balBg} border ${balColor} text-[10px] font-black italic">PKR ${bal.toLocaleString()}</div>
                                </div>
                                <div class="flex gap-2 pt-2 border-t border-slate-50">
                                    <button onclick="viewSupplierHistory(${s.id})" class="flex-1 py-3 bg-slate-900 text-white rounded-xl text-[10px] font-black uppercase"><i class="fa-solid fa-file-invoice mr-2"></i>Ledger</button>
                                    <button onclick="editSupplier(${s.id})" class="w-12 h-12 bg-slate-100 text-slate-600 rounded-xl"><i class="fa-solid fa-pen"></i></button>
                                    <button onclick="deleteSupplier(${s.id}, '${s.supplier_name}')" class="w-12 h-12 bg-red-50 text-red-500 rounded-xl"><i class="fa-solid fa-trash"></i></button>
                                </div>
                            </div>`;
                    });
                } else {
                    const empty = '<div class="py-20 text-center text-slate-300 italic font-black uppercase tracking-widest">No Suppliers Registered</div>';
                    tableHtml = '<tr><td colspan="5">' + empty + '</td></tr>';
                    cardHtml = empty;
                }
                tableBody.innerHTML = tableHtml;
                cardContainer.innerHTML = cardHtml;
                document.getElementById("suppliersPagination").innerHTML = generatePagination(data);
                attachPaginationListeners();
            });
    }

    function generatePagination(data) {
        if (data.last_page <= 1) return '';
        let h = '';
        for (let i = 1; i <= data.last_page; i++) {
            const active = i === data.current_page ? 'bg-[#0f172a] text-[#f59e0b] shadow-lg' : 'bg-white text-slate-400 border border-slate-200';
            h += `<button data-page="${i}" class="pagination-btn w-10 h-10 rounded-xl font-black text-xs transition ${active}">${i}</button>`;
        }
        return h;
    }

    function attachPaginationListeners() {
        document.querySelectorAll('.pagination-btn').forEach(btn => {
            btn.onclick = () => fetchData(btn.dataset.page);
        });
    }

    function viewSupplierHistory(id) {
        activeSupplierId = id;
        const hModal = document.getElementById('historyModal');
        const hBox = document.getElementById('historyModalBox');
        const hContent = document.getElementById('historyContent');
        
        hModal.classList.replace("hidden", "flex");
        hContent.innerHTML = '<div class="text-center py-20"><i class="fa-solid fa-spinner fa-spin text-4xl text-amber-500"></i></div>';
        
        setTimeout(() => { hBox.classList.replace("opacity-0", "opacity-100"); hBox.classList.replace("scale-95", "scale-100"); }, 10);

        fetch(`/suppliers/${id}/history`)
            .then(res => res.json())
            .then(data => {
                document.getElementById('historySupplierName').innerText = data.supplier.supplier_name;
                document.getElementById('historySupplierPhone').innerText = `METADATA: ${data.supplier.phone_number || 'N/A'}`;
                document.getElementById('ledgerTotalDue').innerText = `PKR ${parseFloat(data.supplier.balance_due).toLocaleString(undefined, { minimumFractionDigits: 2 })}`;

                if (!data.history || data.history.length === 0) {
                    hContent.innerHTML = '<div class="text-center py-20 text-slate-300 italic font-black uppercase tracking-widest text-[10px]">Vault Records Empty</div>';
                    return;
                }

                let html = `<table class="w-full text-sm">
                    <thead>
                        <tr class="text-left border-b bg-slate-50 text-slate-400 text-[10px] uppercase font-black tracking-widest italic">
                            <th class="p-4 uppercase">Timestamp</th><th class="p-4 uppercase">Ref #</th><th class="p-4 text-center uppercase">Nature</th><th class="p-4 text-right uppercase">Valuation</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-50 bg-white">`;

                data.history.forEach(entry => {
                    const color = entry.type === 'debit' ? 'text-emerald-600 bg-emerald-50 border-emerald-100' : 'text-red-600 bg-red-50 border-red-100';
                    const nature = entry.type === 'debit' ? 'Outward Payment' : 'Account Credit';
                    const date = new Date(entry.date).toLocaleDateString('en-GB', {day:'2-digit', month:'short', year:'numeric'});
                    
                    html += `<tr class="hover:bg-slate-50 transition">
                        <td class="p-4 text-[10px] font-black text-slate-400 uppercase tracking-tighter whitespace-nowrap">${date}</td>
                        <td class="p-4 font-black text-slate-700 italic uppercase text-xs tracking-tight">${entry.reference}</td>
                        <td class="p-4 text-center"><span class="px-3 py-1 rounded-full text-[8px] font-black uppercase border ${color}">${nature}</span></td>
                        <td class="p-4 text-right font-black text-slate-900 italic tracking-tighter whitespace-nowrap">PKR ${parseFloat(entry.amount).toLocaleString()}</td>
                    </tr>`;
                });
                hContent.innerHTML = html + '</tbody></table>';
            });
    }

    async function submitManualTransaction() {
        const amount = document.getElementById('manualAmount').value;
        if (!amount || amount <= 0) return;
        const btn = document.getElementById('manualSubmitBtn');
        btn.disabled = true; btn.innerHTML = '<i class="fa-solid fa-spinner fa-spin"></i>';

        try {
            const res = await fetch(`/suppliers/${activeSupplierId}/payment`, {
                method: 'POST',
                headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': '<?php echo e(csrf_token()); ?>' },
                body: JSON.stringify({ type: document.getElementById('manualType').value, amount })
            });
            if (res.ok) {
                document.getElementById('manualAmount').value = '';
                viewSupplierHistory(activeSupplierId); fetchData(currentPage);
            }
        } finally { btn.disabled = false; btn.innerHTML = 'Sync Account'; }
    }

    async function handleFormSubmit(event) {
        event.preventDefault();
        saveButton.disabled = true;
        saveButton.innerHTML = '<i class="fa-solid fa-spinner fa-spin"></i> Processing...';
        const formData = new FormData(event.target);
        const data = Object.fromEntries(formData.entries());
        const url = activeSupplierId ? `/suppliers/${activeSupplierId}` : '<?php echo e(route("suppliers.store")); ?>';
        if (activeSupplierId) data._method = 'PUT';

        try {
            const res = await fetch(url, {
                method: 'POST',
                headers: { 'X-CSRF-TOKEN': '<?php echo e(csrf_token()); ?>', 'Accept': 'application/json', 'Content-Type': 'application/json' },
                body: JSON.stringify(data)
            });
            if (res.ok) { closeModal(); fetchData(activeSupplierId ? currentPage : 1); }
            else {
                const err = await res.json();
                document.getElementById("formAlerts").innerHTML = `<div class="p-4 bg-red-50 text-red-600 rounded-2xl border border-red-100 text-[10px] font-black uppercase tracking-widest mb-4">${err.message}</div>`;
            }
        } finally { saveButton.disabled = false; saveButton.innerHTML = 'Commit Registry'; }
    }

    function editSupplier(id) {
        activeSupplierId = id;
        fetch(`/suppliers/${id}/edit`).then(res => res.json()).then(s => {
            form.elements['supplier_name'].value = s.supplier_name;
            form.elements['contact_person'].value = s.contact_person || '';
            form.elements['phone_number'].value = s.phone_number || '';
            form.elements['email'].value = s.email || '';
            form.elements['balance_due'].value = s.balance_due;
            document.querySelector('#supplierModal h2').innerText = 'Update Profile';
            openModal();
        });
    }

    function deleteSupplier(id, name) {
        if (confirm(`Archive Supplier "${name}" permanently?`)) {
            fetch(`/suppliers/${id}`, { method: 'POST', headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': '<?php echo e(csrf_token()); ?>' }, body: JSON.stringify({ _method: 'DELETE' }) })
                .then(() => fetchData(currentPage));
        }
    }

    document.addEventListener('DOMContentLoaded', () => fetchData(1));
</script>
<style>
    .custom-scrollbar::-webkit-scrollbar { width: 4px; }
    .custom-scrollbar::-webkit-scrollbar-track { background: #f8fafc; }
    .custom-scrollbar::-webkit-scrollbar-thumb { background: #e2e8f0; border-radius: 10px; }
</style>
<?php $__env->stopPush(); ?>
<?php echo $__env->make('layouts.main', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH E:\code_2\general-store\resources\views/pages/supplier.blade.php ENDPATH**/ ?>