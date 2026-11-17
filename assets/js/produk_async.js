// assets/js/produk_async.js - Fetch API AJAX, Debouncing Search & Async Delete
document.addEventListener('DOMContentLoaded', () => {
    const searchInput = document.getElementById('live-search-input');
    const kategoriSelect = document.getElementById('live-kategori-filter');
    const gridContainer = document.getElementById('live-produk-grid');
    const statusBadge = document.getElementById('live-search-status');

    if (!searchInput || !gridContainer) return;

    const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '';
    let debounceTimer = null;

    function escapeHtml(str) {
        if (!str) return '';
        return String(str)
            .replace(/&/g, '&amp;')
            .replace(/</g, '&lt;')
            .replace(/>/g, '&gt;')
            .replace(/"/g, '&quot;')
            .replace(/'/g, '&#039;');
    }

    function formatRupiah(angka) {
        return new Intl.NumberFormat('id-ID').format(angka);
    }

    async function fetchProduk() {
        const q = searchInput.value.trim();
        const kat = kategoriSelect ? kategoriSelect.value : '';
        
        if (statusBadge) statusBadge.textContent = 'Syncing...';

        try {
            const url = `modules/api/cari_produk.php?q=${encodeURIComponent(q)}&kategori=${encodeURIComponent(kat)}`;
            const response = await fetch(url);
            const result = await response.json();

            if (result.status === 'success') {
                renderCards(result.data);
                if (statusBadge) statusBadge.textContent = `${result.total} Specimens Found`;
            }
        } catch (err) {
            console.error('Fetch error:', err);
            if (statusBadge) statusBadge.textContent = 'API Connection Error';
        }
    }

    function renderCards(items) {
        if (items.length === 0) {
            gridContainer.innerHTML = `
                <div class="col-span-full bg-white p-10 rounded-[2rem] border border-zinc-100 text-center text-zinc-400 text-xs">
                    Tidak ada komoditas yang cocok dengan kata kunci pencarian.
                </div>`;
            return;
        }

        gridContainer.innerHTML = items.map(item => `
            <div id="card-produk-${item.id}" class="bg-white rounded-[2rem] border border-zinc-100 p-6 flex flex-col justify-between transition hover:shadow-sm">
                <div>
                    <div class="flex items-center justify-between gap-2 mb-3">
                        <span class="font-mono text-[11px] px-2.5 py-1 rounded-full bg-brand-surface text-zinc-600">${escapeHtml(item.kode_produk)}</span>
                        <span class="text-[11px] font-semibold px-3 py-1 rounded-full bg-brand-cream text-brand-ink">${escapeHtml(item.kategori)}</span>
                    </div>
                    <h4 class="font-bold text-brand-ink text-base mb-1.5">${escapeHtml(item.nama_produk)}</h4>
                    <p class="text-xs text-zinc-500 line-clamp-2 mb-5 leading-relaxed">${escapeHtml(item.deskripsi || 'Komoditas budidaya berkualitas.')}</p>
                </div>
                <div class="pt-4 border-t border-zinc-100 flex items-center justify-between">
                    <div>
                        <p class="text-sm font-extrabold text-brand-ink">Rp ${formatRupiah(item.harga)}</p>
                        <p class="text-[11px] text-zinc-400">Stock: ${item.stok} ${escapeHtml(item.satuan)}</p>
                    </div>
                    <button onclick="hapusProdukAsync(${item.id}, '${escapeHtml(item.nama_produk)}')" 
                            class="inline-flex items-center gap-1.5 px-3.5 py-2 text-[11px] font-semibold rounded-full bg-red-50 text-red-600 hover:bg-red-600 hover:text-white transition">
                        <i data-lucide="trash-2" class="w-3.5 h-3.5"></i>
                        <span>Delete</span>
                    </button>
                </div>
            </div>
        `).join('');

        if (window.lucide) {
            lucide.createIcons();
        }
    }

    searchInput.addEventListener('input', () => {
        clearTimeout(debounceTimer);
        debounceTimer = setTimeout(fetchProduk, 350);
    });

    if (kategoriSelect) {
        kategoriSelect.addEventListener('change', fetchProduk);
    }

    window.hapusProdukAsync = async function(id, nama) {
        if (!confirm(`Hapus "${nama}" secara asinkron?`)) return;

        try {
            const response = await fetch('modules/api/hapus_produk.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-Token': csrfToken
                },
                body: JSON.stringify({ id: id, csrf_token: csrfToken })
            });

            const res = await response.json();
            if (res.status === 'success') {
                const card = document.getElementById(`card-produk-${id}`);
                if (card) {
                    card.style.opacity = '0';
                    setTimeout(() => fetchProduk(), 250);
                }
            } else {
                alert(res.message || 'Gagal menghapus produk.');
            }
        } catch (err) {
            alert('Terjadi kesalahan jaringan saat menghapus data.');
        }
    };

    fetchProduk();
});