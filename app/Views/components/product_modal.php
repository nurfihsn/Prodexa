<div id="productModal" class="fixed inset-0 z-50 hidden" aria-labelledby="modal-title" role="dialog" aria-modal="true">
    <div class="fixed inset-0 glass-overlay transition-opacity opacity-0" id="modalBackdrop"></div>
    <div class="fixed inset-0 z-10 overflow-y-auto">
        <div class="flex min-h-full items-center justify-center p-4">
            <div class="relative transform overflow-hidden rounded-2xl bg-white text-left shadow-2xl transition-all sm:w-full sm:max-w-lg opacity-0 translate-y-4 scale-95" id="modalPanel">

                <div class="bg-slate-50 px-6 py-4 border-b border-slate-100 flex justify-between items-center">
                    <h3 class="text-lg font-bold text-slate-900" id="modalTitle">Tambah Produk</h3>
                    <button onclick="closeModal()" class="text-slate-400 hover:text-red-500"><i class="ph ph-x text-xl"></i></button>
                </div>

                <form id="productForm" class="px-6 py-6 space-y-5" onsubmit="submitForm(event)">
                    <input type="hidden" id="productId" name="id">

                    <!-- Upload -->
                    <div class="flex justify-center">
                        <div class="relative group cursor-pointer w-full">
                            <input type="file" id="gambar" name="gambar" class="hidden" accept="image/*" onchange="previewImage(event)">
                            <label for="gambar" class="flex flex-col items-center justify-center w-full h-40 border-2 border-dashed border-slate-300 rounded-xl hover:bg-slate-50 transition-all" id="dropzone">
                                <img id="imgPreview" src="" class="absolute inset-0 w-full h-full object-cover rounded-xl hidden">
                                <div id="placeholderPreview" class="text-center p-4">
                                    <i class="ph ph-image text-3xl text-slate-400 mb-2"></i>
                                    <p class="text-sm text-slate-500">Klik upload gambar</p>
                                </div>
                            </label>
                        </div>
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-slate-700 mb-1">Nama Produk</label>
                        <input type="text" name="nama_produk" id="nama_produk" required class="w-full px-4 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-brand-500 outline-none">
                    </div>
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-semibold text-slate-700 mb-1">Harga</label>
                            <input type="text" name="harga" id="harga" required class="w-full px-4 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-brand-500 outline-none" placeholder="0" onkeyup="formatCurrency(this)">
                        </div>
                        <div>
                            <label class="block text-sm font-semibold text-slate-700 mb-1">Stok</label>
                            <input type="number" name="stok" id="stok" required class="w-full px-4 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-brand-500 outline-none">
                        </div>
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-slate-700 mb-1">Deskripsi</label>
                        <textarea name="deskripsi" id="deskripsi" rows="3" class="w-full px-4 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-brand-500 outline-none"></textarea>
                    </div>

                    <div class="bg-slate-50 -mx-6 -mb-6 px-6 py-4 border-t border-slate-100 flex justify-end gap-3">
                        <button type="button" onclick="closeModal()" class="px-4 py-2 rounded-lg text-slate-600 hover:bg-slate-200">Batal</button>
                        <button type="submit" class="px-6 py-2 rounded-lg bg-brand-600 text-white hover:bg-brand-700 shadow-lg shadow-brand-500/30 flex items-center gap-2">
                            <i class="ph ph-check-circle"></i> Simpan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>