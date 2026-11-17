<div class="bg-white p-6 rounded-[2rem] border border-zinc-100 mb-6">
    <div class="flex flex-col md:flex-row gap-4 justify-between items-center">
        <div class="w-full md:w-1/2">
            <label class="block text-[11px] font-semibold text-zinc-500 uppercase tracking-wider mb-1.5">Real-Time Search (Debounced Fetch API)</label>
            <div class="relative">
                <span class="absolute inset-y-0 left-3.5 flex items-center text-zinc-400">
                    <i data-lucide="search" class="w-4 h-4"></i>
                </span>
                <input type="text" id="live-search-input" placeholder="Cari nama ikan, tanaman air, atau kode SKU..." 
                       class="w-full pl-10 pr-4 py-2.5 text-sm bg-brand-surface border border-transparent focus:bg-white focus:border-brand-ink rounded-2xl outline-none transition">
            </div>
        </div>

        <div class="w-full md:w-1/4">
            <label class="block text-[11px] font-semibold text-zinc-500 uppercase tracking-wider mb-1.5">Category Filter</label>
            <select id="live-kategori-filter" class="w-full px-4 py-2.5 text-sm bg-brand-surface border border-transparent focus:bg-white focus:border-brand-ink rounded-2xl outline-none transition">
                <option value="">All Categories</option>
                <option value="Ikan Hias">Ikan Hias</option>
                <option value="Tanaman Air">Tanaman Air</option>
                <option value="Hardscape & Media">Hardscape &amp; Media</option>
                <option value="Pakan & Obat">Pakan &amp; Obat</option>
            </select>
        </div>

        <div class="w-full md:w-auto text-right self-end">
            <span id="live-search-status" class="inline-block px-4 py-2.5 rounded-full bg-brand-surface text-xs font-semibold text-brand-ink">
                Initializing...
            </span>
        </div>
    </div>
</div>

<!-- Grid Dinamis diisi oleh assets/js/produk_async.js -->
<div id="live-produk-grid" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-5">
    <div class="col-span-full text-center py-12 text-zinc-400 text-xs">Loading specimens from REST API...</div>
</div>