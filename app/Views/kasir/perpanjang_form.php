<?= view('layout/header') ?>
<?= view('layout/sidebar') ?>

<link rel="stylesheet" href="<?= base_url('assets/css/kasir.css') ?>">

<div class="main">

<h2 class="page-title">Form Perpanjangan Kursus</h2>

<form action="<?= base_url('kasir/perpanjang/simpan') ?>" method="post" class="form-modern">

<input type="hidden" name="id_siswa" value="<?= $transaksi['id_siswa'] ?>">

<!-- Nama -->
<div class="form-group">
    <label>Nama Siswa</label>
    <input type="text" value="<?= esc($siswa['nama_siswa']) ?>" readonly>
</div>

<!-- Tanggal Lama -->
<div class="form-group">
    <label>Tanggal Selesai Sebelumnya</label>
    <input type="text" value="<?= $transaksi['tanggal_selesai'] ?>" readonly>
</div>

<!-- Tanggal Mulai -->
<div class="form-group">
    <label>Tanggal Mulai</label>
    <input type="date" name="tanggal_mulai" required>
</div>

<!-- MAPEL LAMA -->
<div class="form-group">
    <label>Mapel Saat Ini</label>

    <div class="mapel-box">
        <?php foreach($mapelSiswa as $m): ?>
            <div class="mapel-item old">
                <div class="text">
                    <b><?= $m['nama_produk'] ?></b><br>
                    <small>Rp <?= number_format($m['harga_produk']) ?></small>
                </div>

                <div class="right">
                    <span class="badge lama">Lama</span>
                    <input type="checkbox" class="produk" 
                        data-harga="<?= $m['harga_produk'] ?>" 
                        name="produk[]" value="<?= $m['id'] ?>" checked>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</div>

<!-- TAMBAH MAPEL -->
<div class="form-group">
    <button type="button" onclick="toggleMapel()" class="btn-modern btn-info">
        ➕ Tambah Mapel
    </button>

    <div id="mapelBaru" style="display:none; margin-top:10px;" class="mapel-box">
        <?php foreach($products as $p): ?>
            <div class="mapel-item new">
                <div class="text">
                    <b><?= $p['nama_produk'] ?></b><br>
                    <small>Rp <?= number_format($p['harga_produk']) ?></small>
                </div>

                <div class="right">
                    <span class="badge baru">Baru</span>
                    <input type="checkbox" class="produk" 
                        data-harga="<?= $p['harga_produk'] ?>" 
                        name="produk[]" value="<?= $p['id'] ?>">
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</div>

<!-- Durasi -->
<div class="form-group">
    <label>Durasi (bulan)</label>
    <input type="number" id="durasi" name="durasi" min="1" required>
</div>

<!-- TOTAL -->
<div class="form-group">
    <label>Total Harga</label>
    <input type="text" id="totalDisplay" readonly value="Rp 0">
</div>

<!-- Bayar -->
<div class="form-group">
    <label>Uang Bayar</label>
    <input type="number" name="uang_bayar" required>
</div>

<!-- BUTTON -->
<div style="margin-top:15px; display:flex; gap:10px;">
    
    <a href="<?= base_url('kasir/perpanjang') ?>">
        <button type="button" class="btn-modern btn-secondary">
            ← Kembali
        </button>
    </a>

    <button type="submit" class="btn-modern btn-success">
        💾 Simpan Perpanjangan
    </button>

</div>

</form>

</div>

<script>
function toggleMapel(){
    let el = document.getElementById('mapelBaru');
    el.style.display = el.style.display === 'none' ? 'block' : 'none';
}

// ✅ HITUNG TOTAL
function hitungTotal(){
    let checkboxes = document.querySelectorAll('.produk:checked');
    let durasi = document.getElementById('durasi').value || 0;

    let total = 0;

    checkboxes.forEach(cb => {
        let harga = parseInt(cb.dataset.harga);
        total += harga * durasi;
    });

    document.getElementById('totalDisplay').value = 'Rp ' + total.toLocaleString('id-ID');
}

// trigger event
document.addEventListener('change', function(e){
    if(e.target.classList.contains('produk') || e.target.id === 'durasi'){
        hitungTotal();
    }
});
</script>

<style>
.mapel-box{
    border:1px solid #ddd;
    border-radius:10px;
    padding:10px;
    max-height:200px;
    overflow:auto;
}

.mapel-item{
    display:flex;
    justify-content:space-between;
    align-items:center;
    padding:10px;
    margin-bottom:6px;
    border-radius:8px;
}

.mapel-item.old{
    background:#f0f8ff;
}

.mapel-item.new{
    background:#fff;
}

.text{
    color:#333;
}

.text small{
    color:#666;
}

.right{
    display:flex;
    align-items:center;
    gap:10px;
}

.badge{
    padding:3px 8px;
    border-radius:6px;
    font-size:12px;
    color:#fff;
}

.badge.lama{
    background:#3498db;
}

.badge.baru{
    background:#2ecc71;
}
</style>

<?= view('layout/footer') ?>