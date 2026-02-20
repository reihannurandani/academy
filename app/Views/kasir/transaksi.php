<?= view('layout/header') ?>
<?= view('layout/sidebar') ?>

<div class="container mt-4">

<div class="card shadow-lg border-0"
     style="background: linear-gradient(135deg,#6ea8fe,#3d7bfd); border-radius:20px;">
    <div class="card-body text-white p-4">

        <h4 class="mb-4">
            <i class="bi bi-cart-check-fill me-2"></i> Transaksi
        </h4>

        <form method="post" action="<?= base_url('kasir/save-transaksi') ?>">

            <!-- DATA SISWA -->
            <h5 class="mb-3">
                <i class="bi bi-person-fill me-2"></i> Data Siswa
            </h5>

            <div class="mb-3">
                <input name="nama_siswa"
                       class="form-control rounded-pill"
                       placeholder="Nama Siswa" required>
            </div>

            <div class="mb-3">
                <input name="no_hp"
                       class="form-control rounded-pill"
                       placeholder="No HP" required>
            </div>

            <div class="mb-4">
                <textarea name="alamat"
                          class="form-control rounded-4"
                          placeholder="Alamat"
                          rows="2"></textarea>
            </div>

            <!-- PILIH BAHASA -->
            <h5 class="mb-3">
                <i class="bi bi-translate me-2"></i> Pilih Bahasa
            </h5>

            <div class="row">
                <?php foreach($products as $p): ?>
                <div class="col-md-3 mb-3">
                    <label class="card text-center p-3 border-0 shadow-sm language-card"
                           style="cursor:pointer; border-radius:20px;">

                        <input type="checkbox"
                               name="id_produk[]"
                               value="<?= $p['id'] ?>"
                               data-harga="<?= $p['harga_produk'] ?>"
                               class="d-none pilihProduk">

                        <div class="mb-2">
                            <i class="bi bi-globe2 fs-1 text-primary"></i>
                        </div>

                        <h6 class="fw-bold">
                            <?= esc($p['nama_produk']) ?>
                        </h6>

                        <small class="text-muted">
                            Rp <?= number_format($p['harga_produk']) ?> / bulan
                        </small>

                    </label>
                </div>
                <?php endforeach; ?>
            </div>

                        <!-- DURASI -->
            <h5 class="mb-3">
                <i class="bi bi-clock-fill me-2"></i> Durasi (Bulan)
            </h5>

            <div class="mb-4">
                <input type="number"
                       id="durasi"
                       name="durasi"
                       class="form-control rounded-pill"
                       placeholder="Masukkan durasi (contoh: 3)"
                       min="1"
                       required>
            </div>


 <!-- TOTAL -->
<div class="mt-4 p-3 bg-white rounded-4 text-dark">

    <div class="mb-3">
        <label>Total Harga</label>
        <input id="total"
               type="text"
               class="form-control rounded-pill"
               readonly>
    </div>

    <!-- Hidden input untuk kirim angka asli -->
    <input type="hidden" name="total_harga" id="total_raw">

    <div class="mb-3">
        <label>Uang Bayar</label>
        <input name="uang_bayar"
               id="uang_bayar"
               type="number"
               class="form-control rounded-pill"
               required>
    </div>

    <div class="mb-3">
        <label>Uang Kembalian</label>
        <input id="kembalian"
               type="text"
               class="form-control rounded-pill"
               readonly>
    </div>

    <button class="btn btn-primary w-100 rounded-pill">
        <i class="bi bi-check-circle-fill me-2"></i>
        Simpan Transaksi
    </button>

</div>


<!-- SCRIPT HITUNG TOTAL & KEMBALIAN -->
<script>
function formatRupiah(angka) {
    return angka.toLocaleString('id-ID');
}

function hitungSemua() {
    let durasi = parseInt(document.getElementById('durasi').value) || 0;
    let total = 0;

    // Hitung total dari semua produk yang dipilih
    document.querySelectorAll('.pilihProduk:checked').forEach(item => {
        let harga = parseInt(item.dataset.harga);
        total += harga * durasi;
    });

    // Tampilkan total (format rupiah)
    document.getElementById('total').value =
        total > 0 ? formatRupiah(total) : '';

    // Simpan total angka asli ke hidden input
    document.getElementById('total_raw').value = total;

    // Hitung kembalian
    let bayar = parseInt(document.getElementById('uang_bayar').value) || 0;
    let kembali = bayar - total;

    document.getElementById('kembalian').value =
        kembali >= 0 ? formatRupiah(kembali) : '';
}

// Event pilih bahasa
document.querySelectorAll('.pilihProduk').forEach(item => {
    item.addEventListener('change', hitungSemua);
});

// Event ubah durasi
document.getElementById('durasi').addEventListener('input', hitungSemua);

// Event isi uang bayar
document.getElementById('uang_bayar').addEventListener('input', hitungSemua);
</script>

<style>
.language-card:hover {
    transform: scale(1.05);
    transition: 0.3s;
}

.language-card input:checked + div i {
    color: #0d6efd;
}

.language-card input:checked ~ h6 {
    color: #0d6efd;
}
</style>

<?= view('layout/footer') ?>

