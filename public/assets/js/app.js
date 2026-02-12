function formatCurrency(input) {
    let value = input.value.replace(/\D/g, '');
    if (value !== '') {
        value = new Intl.NumberFormat('id-ID').format(value);
    }
    input.value = value;
}

// Modal Handling
const modal = document.getElementById('productModal');
const backdrop = document.getElementById('modalBackdrop');
const panel = document.getElementById('modalPanel');

function openModal(editMode = false) {
    modal.classList.remove('hidden');
    setTimeout(() => {
        backdrop.classList.remove('opacity-0');
        panel.classList.remove('opacity-0', 'translate-y-4', 'scale-95');
        panel.classList.add('translate-y-0', 'scale-100');
    }, 10);

    if (!editMode) {
        document.getElementById('productForm').reset();
        document.getElementById('productId').value = '';
        document.getElementById('modalTitle').innerText = 'Tambah Produk Baru';
        resetImagePreview();
    } else {
        document.getElementById('modalTitle').innerText = 'Edit Produk';
    }
}

function closeModal() {
    backdrop.classList.add('opacity-0');
    panel.classList.remove('translate-y-0', 'scale-100');
    panel.classList.add('opacity-0', 'translate-y-4', 'scale-95');
    setTimeout(() => {
        modal.classList.add('hidden');
    }, 300);
}

// Image Preview Handling
function previewImage(event) {
    const file = event.target.files[0];
    if (file) {
        const reader = new FileReader();
        reader.onload = (e) => {
            const img = document.getElementById('imgPreview');
            img.src = e.target.result;
            img.classList.remove('hidden');
            document.getElementById('placeholderPreview').classList.add('hidden');
            document.getElementById('dropzone').classList.add('border-brand-500', 'bg-slate-50');
            document.getElementById('dropzone').classList.remove('border-dashed');
        }
        reader.readAsDataURL(file);
    }
}

function resetImagePreview() {
    document.getElementById('imgPreview').src = '';
    document.getElementById('imgPreview').classList.add('hidden');
    document.getElementById('placeholderPreview').classList.remove('hidden');
    document.getElementById('dropzone').classList.remove('border-brand-500', 'bg-slate-50');
    document.getElementById('dropzone').classList.add('border-dashed');
}

// API
function editProduct(id) {
    fetch(`api.php?action=get_one&id=${id}`)
        .then(res => res.json())
        .then(res => {
            if (res.status === 'success') {
                const data = res.data;
                document.getElementById('productId').value = data.id;
                document.getElementById('nama_produk').value = data.nama_produk;
                const hargaFormatted = new Intl.NumberFormat('id-ID').format(Math.floor(data.harga));
                document.getElementById('harga').value = hargaFormatted;
                document.getElementById('stok').value = data.stok;
                document.getElementById('deskripsi').value = data.deskripsi;

                if (data.gambar) {
                    const img = document.getElementById('imgPreview');
                    img.src = `uploads/${data.gambar}`;
                    img.classList.remove('hidden');
                    document.getElementById('placeholderPreview').classList.add('hidden');
                } else {
                    resetImagePreview();
                }
                openModal(true);
            } else {
                Swal.fire('Error', res.message, 'error');
            }
        });
}

function deleteProduct(id) {
    Swal.fire({
        title: 'Yakin hapus?',
        text: "Data tidak bisa dikembalikan!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#ef4444',
        confirmButtonText: 'Ya, Hapus',
        cancelButtonText: 'Batal'
    }).then((result) => {
        if (result.isConfirmed) {
            const formData = new FormData();
            formData.append('id', id);

            fetch('api.php?action=delete', {
                method: 'POST',
                body: formData
            })
            .then(res => res.json())
            .then(res => {
                if (res.status === 'success') {
                    Swal.fire('Terhapus!', 'Produk berhasil dihapus.', 'success').then(() => location.reload());
                } else {
                    Swal.fire('Gagal', res.message, 'error');
                }
            });
        }
    });
}

function submitForm(e) {
    e.preventDefault();
    const formData = new FormData(e.target);

    const btn = e.target.querySelector('button[type="submit"]');
    const originalText = btn.innerHTML;
    btn.innerHTML = '<i class="ph ph-spinner animate-spin"></i> Loading...';
    btn.disabled = true;

    fetch('api.php?action=save', {
        method: 'POST',
        body: formData
    })
    .then(res => res.json())
    .then(res => {
        if (res.status === 'success') {
            closeModal();
            Swal.fire({
                icon: 'success',
                title: 'Berhasil',
                text: 'Data produk disimpan!',
                showConfirmButton: false,
                timer: 1500
            }).then(() => location.reload());
        } else {
            Swal.fire('Error', res.message, 'error');
            btn.innerHTML = originalText;
            btn.disabled = false;
        }
    })
    .catch(err => {
        Swal.fire('Error', 'Terjadi kesalahan sistem', 'error');
        btn.innerHTML = originalText;
        btn.disabled = false;
    });
}

// Live Search
const searchInput = document.getElementById('searchInput');
if (searchInput) {
    searchInput.addEventListener('keyup', function() {
        const val = this.value.toLowerCase();
        const rows = document.querySelectorAll('.product-row');

        rows.forEach(row => {
            const name = row.querySelector('.product-name').textContent.toLowerCase();
            if (name.includes(val)) {
                row.style.display = '';
            } else {
                row.style.display = 'none';
            }
        });
    });
}
