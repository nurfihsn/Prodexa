<?php require_once __DIR__ . '/../layouts/header.php'; ?>

<main class="flex-grow container mx-auto px-4 py-8 max-w-6xl">
    <!-- HEADER -->
    <header class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-8">
        <div>
            <h1 class="text-3xl font-bold tracking-tight text-slate-900">Dashboard Produk</h1>
            <p class="text-slate-500 mt-1">Kelola inventaris toko Anda dengan mudah.</p>
        </div>
        <div class="flex gap-3">
            <div class="group w-full md:w-64 flex items-center bg-white border border-slate-200 rounded-xl shadow-sm focus-within:ring-2 focus-within:ring-brand-500 focus-within:border-brand-500 transition-all overflow-hidden">
                <div class="pl-3 flex-shrink-0 flex items-center justify-center pointer-events-none text-slate-400">
                    <i class="ph ph-magnifying-glass text-lg leading-none"></i>
                </div>
                <input type="text" id="searchInput" placeholder="Cari produk..."
                    class="w-full py-2.5 pl-2 pr-4 text-sm bg-transparent border-none focus:ring-0 placeholder:text-slate-400 text-slate-800 outline-none h-full">
            </div>
            <button onclick="openModal()" class="flex items-center gap-2 bg-brand-600 hover:bg-brand-700 text-white px-5 py-2.5 rounded-xl font-medium transition-all shadow-lg shadow-brand-500/30 hover:-translate-y-0.5">
                <i class="ph ph-plus-circle text-lg"></i> <span>Tambah</span>
            </button>
        </div>
    </header>

    <!-- STATS -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
        <div class="bg-white p-5 rounded-2xl border border-slate-100 shadow-soft flex items-center justify-between">
            <div>
                <p class="text-xs font-semibold text-slate-400 uppercase">Total Produk</p>
                <h3 class="text-2xl font-bold text-slate-800 mt-1"><?= count($products) ?></h3>
            </div>
            <div class="p-3 bg-blue-50 text-blue-600 rounded-xl"><i class="ph ph-package text-2xl"></i></div>
        </div>
        <div class="bg-white p-5 rounded-2xl border border-slate-100 shadow-soft flex items-center justify-between">
            <div>
                <p class="text-xs font-semibold text-slate-400 uppercase">Aset (Estimasi)</p>
                <h3 class="text-2xl font-bold text-slate-800 mt-1">Rp <?= number_format($total_asset, 0, ',', '.') ?></h3>
            </div>
            <div class="p-3 bg-emerald-50 text-emerald-600 rounded-xl"><i class="ph ph-currency-dollar text-2xl"></i></div>
        </div>
        <div class="bg-white p-5 rounded-2xl border border-slate-100 shadow-soft flex items-center justify-between">
            <div>
                <p class="text-xs font-semibold text-slate-400 uppercase">Stok Menipis</p>
                <h3 class="text-2xl font-bold text-slate-800 mt-1"><?= $low_stock ?></h3>
            </div>
            <div class="p-3 bg-orange-50 text-orange-600 rounded-xl"><i class="ph ph-warning text-2xl"></i></div>
        </div>
    </div>

    <!-- TABLE -->
    <div class="bg-white rounded-2xl border border-slate-200 shadow-soft overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-slate-50 border-b border-slate-200">
                        <th class="px-6 py-4 text-xs font-bold text-slate-500 uppercase tracking-wider">Produk</th>
                        <th class="px-6 py-4 text-xs font-bold text-slate-500 uppercase tracking-wider">Harga</th>
                        <th class="px-6 py-4 text-xs font-bold text-slate-500 uppercase tracking-wider text-center">Stok</th>
                        <th class="px-6 py-4 text-xs font-bold text-slate-500 uppercase tracking-wider text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody id="productTableBody" class="divide-y divide-slate-100">
                    <?php if (count($products) > 0): ?>
                        <?php foreach ($products as $row):
                            $img = !empty($row['gambar']) ? "uploads/{$row['gambar']}" : "uploads/placeholder.png";

                            $badgeClass = 'bg-emerald-100 text-emerald-700 border-emerald-200';
                            $status = 'Tersedia';
                            if ($row['stok'] == 0) {
                                $badgeClass = 'bg-red-100 text-red-700 border-red-200';
                                $status = 'Habis';
                            } elseif ($row['stok'] <= 5) {
                                $badgeClass = 'bg-orange-100 text-orange-700 border-orange-200';
                                $status = 'Menipis';
                            }
                        ?>
                            <tr class="hover:bg-slate-50 transition-colors group product-row">
                                <td class="px-6 py-4">
                                    <div class="flex items-center gap-4">
                                        <div class="w-12 h-12 rounded-xl overflow-hidden bg-slate-200 border border-slate-200 flex-shrink-0">
                                            <img src="<?= htmlspecialchars($img) ?>" class="w-full h-full object-cover">
                                        </div>
                                        <div>
                                            <h4 class="font-bold text-slate-800 text-sm product-name"><?= htmlspecialchars($row['nama_produk']) ?></h4>
                                            <p class="text-xs text-slate-500 truncate max-w-[200px]"><?= htmlspecialchars(mb_strimwidth($row['deskripsi'], 0, 50, '...')) ?></p>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4 font-semibold text-slate-700 text-sm">
                                    Rp <?= number_format($row['harga'], 0, ',', '.') ?>
                                </td>
                                <td class="px-6 py-4 text-center">
                                    <span class="text-sm font-bold text-slate-700"><?= $row['stok'] ?></span>
                                    <div class="text-[10px] px-2 py-0.5 rounded-full border <?= $badgeClass ?> font-medium mt-1 inline-block"><?= $status ?></div>
                                </td>
                                <td class="px-6 py-4 text-right">
                                    <div class="flex justify-end gap-2">
                                        <button onclick="editProduct(<?= $row['id'] ?>)" class="p-2 border border-slate-200 rounded-lg text-slate-500 hover:text-brand-600 hover:border-brand-200 hover:bg-brand-50 transition-all"><i class="ph ph-pencil-simple text-lg"></i></button>
                                        <button onclick="deleteProduct(<?= $row['id'] ?>)" class="p-2 border border-slate-200 rounded-lg text-slate-500 hover:text-red-600 hover:border-red-200 hover:bg-red-50 transition-all"><i class="ph ph-trash text-lg"></i></button>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="4" class="text-center py-8 text-slate-500">Belum ada data produk.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</main>

<?php require_once __DIR__ . '/../components/product_modal.php'; ?>
<?php require_once __DIR__ . '/../layouts/footer.php'; ?>