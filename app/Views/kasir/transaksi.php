<?= view('layout/header') ?>
<?= view('layout/sidebar') ?>

<link rel="stylesheet" href="<?= base_url('assets/css/kasir.css') ?>">

<div class="main">

    <div class="dashboard-header">
        <h2>Transaksi</h2>
    </div>

    <div class="transaksi-card">

        <?php if(session()->getFlashdata('error')): ?>
            <div class="custom-alert">
                <span><?= session()->getFlashdata('error') ?></span>
                <button onclick="this.parentElement.style.display='none'">×</button>
            </div>
        <?php endif; ?>

        <form method="post" action="<?= base_url('kasir/saveTransaksi') ?>">

            <!-- ===================== -->
            <!-- DATA SISWA -->
            <!-- ===================== -->
            <h5 class="section-title">Data Siswa</h5>

            <input name="nama_siswa" class="custom-input" placeholder="Nama Siswa" required>
            <input name="no_hp" class="custom-input" placeholder="No. HP" required>
            <textarea name="alamat" class="custom-input" placeholder="Alamat"></textarea>

            <!-- ===================== -->
            <!-- PILIH BAHASA -->
            <!-- ===================== -->
            <h5 class="section-title mt-20">Pilih Bahasa</h5>

<div class="produk-container">
<?php foreach($products as $p): ?>

<label class="produk-card">
    <input type="checkbox"
           name="id_produk[]"
           value="<?= $p['id'] ?>"
           data-harga="<?= $p['harga_produk'] ?>"
           class="pilihProduk">

    <div class="produk-inner">

        <!-- ICON GLOBAL -->
        <div class="produk-icon">
            🌍
        </div>

        <h6><?= esc($p['nama_produk']) ?></h6>

        <div class="produk-detail">

            <div>
                <span>Waktu</span>
                <small><?= esc($p['jam_kursus']) ?></small>
            </div>

            <div>
                <span>Kuota</span>
                <small><?= esc($p['kuota']) ?></small>
            </div>

            <div>
                <span>Harga</span>
                <small>
                    Rp <?= number_format($p['harga_produk'],0,',','.') ?> / bulan
                </small>
            </div>

            <div>
                <span>Status</span>
                <?php if($p['kuota'] > 0): ?>
                    <span class="badge-ready">Ready</span>
                <?php else: ?>
                    <span class="badge-full">Full</span>
                <?php endif; ?>
            </div>

        </div>

        <div class="btn-pilih">Pilih</div>

    </div>
</label>

<?php endforeach; ?>
</div>

            <!-- ===================== -->
            <!-- DURASI & PEMBAYARAN -->
            <!-- ===================== -->

            <input type="number"
                   id="durasi"
                   name="durasi"
                   class="custom-input mt-20"
                   placeholder="Masukan durasi bulan"
                   min="1"
                   required>

            <input id="total"
                   type="text"
                   class="custom-input"
                   placeholder="Total Harga"
                   readonly>

            <input type="hidden" name="total_harga" id="total_raw">

            <input name="uang_bayar"
                   id="uang_bayar"
                   type="number"
                   class="custom-input"
                   placeholder="Uang Bayar"
                   required>

            <input id="kembalian"
                   type="text"
                   class="custom-input"
                   placeholder="Uang Kembalian"
                   readonly>

            <div class="btn-area">
                <button type="submit" class="btn-daftar">
                    Daftar & cetak struk
                </button>
            </div>

        </form>
    </div>
</div>

<script>
function formatRupiah(angka){
    return angka.toLocaleString('id-ID');
}

function hitungSemua(){
    let durasi = parseInt(document.getElementById('durasi').value) || 0;
    let total = 0;

    document.querySelectorAll('.pilihProduk:checked').forEach(item=>{
        total += parseInt(item.dataset.harga) * durasi;
    });

    document.getElementById('total').value =
        total > 0 ? 'Rp ' + formatRupiah(total) : '';

    document.getElementById('total_raw').value = total;

    let bayar = parseInt(document.getElementById('uang_bayar').value) || 0;
    let kembali = bayar - total;

    document.getElementById('kembalian').value =
        kembali >= 0 ? 'Rp ' + formatRupiah(kembali) : '';
}

document.querySelectorAll('.pilihProduk').forEach(item=>{
    item.addEventListener('change', hitungSemua);
});

document.getElementById('durasi').addEventListener('input', hitungSemua);
document.getElementById('uang_bayar').addEventListener('input', hitungSemua);
</script>

<?= view('layout/footer') ?>