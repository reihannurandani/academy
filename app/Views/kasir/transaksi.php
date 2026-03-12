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

<form action="<?= base_url('kasir/save-transaksi') ?>" method="post">

<!-- ===================== -->
<!-- DATA SISWA -->
<!-- ===================== -->

<h5 class="section-title">Data Siswa</h5>

<input name="nama_siswa" class="custom-input" placeholder="Nama Siswa" required>

<input name="no_hp" class="custom-input" placeholder="No. HP" required>

<textarea name="alamat" class="custom-input" placeholder="Alamat"></textarea>


<!-- ===================== -->
<!-- TANGGAL KURSUS -->
<!-- ===================== -->

<h5 class="section-title mt-20">Tanggal Kursus</h5>

<input
type="date"
name="tanggal_mulai"
id="tanggal_mulai"
class="custom-input"
required>

<input
type="text"
id="tanggal_selesai_preview"
class="custom-input"
placeholder="Tanggal Selesai"
readonly>


<!-- ===================== -->
<!-- PILIH BAHASA -->
<!-- ===================== -->

<h5 class="section-title mt-20">Pilih Bahasa</h5>

<div class="produk-container">

<?php foreach($products as $p): ?>

<label class="produk-card <?= ($p['kuota'] <= 0) ? 'disabled-card' : '' ?>">

<input
type="checkbox"
name="id_produk[]"
value="<?= $p['id'] ?>"
data-harga="<?= $p['harga_produk'] ?>"
class="pilihProduk"
<?= ($p['kuota'] <= 0) ? 'disabled' : '' ?>
hidden
>

<div class="produk-inner">

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
<!-- DURASI -->
<!-- ===================== -->

<h5 class="section-title mt-20">Durasi (perbulan)</h5>

<input
type="number"
id="durasi"
name="durasi"
class="custom-input mt-20"
placeholder="Masukan durasi bulan"
min="1"
required>


<!-- ===================== -->
<!-- TOTAL -->
<!-- ===================== -->

<input
id="total"
type="text"
class="custom-input"
placeholder="Total Harga"
readonly>


<!-- ===================== -->
<!-- PEMBAYARAN -->
<!-- ===================== -->

<input
name="uang_bayar"
id="uang_bayar"
type="number"
class="custom-input"
placeholder="Uang Bayar"
required>


<input
id="kembalian"
type="text"
class="custom-input"
placeholder="Uang Kembalian"
readonly>


<div class="btn-area">
<button type="submit" class="btn-daftar">
Daftar & Cetak Struk
</button>
</div>

</form>

</div>
</div>


<script>

function rupiah(angka){
return angka.toLocaleString('id-ID');
}

function hitungTotal(){

let durasi = parseInt(document.getElementById('durasi').value) || 0;
let total = 0;

document.querySelectorAll('.pilihProduk:checked').forEach(item=>{
total += parseInt(item.dataset.harga) * durasi;
});

document.getElementById('total').value =
total > 0 ? 'Rp ' + rupiah(total) : '';

let bayar = parseInt(document.getElementById('uang_bayar').value) || 0;
let kembali = bayar - total;

document.getElementById('kembalian').value =
kembali >= 0 ? 'Rp ' + rupiah(kembali) : '';

hitungTanggalSelesai();

}

function hitungTanggalSelesai(){

let mulai = document.getElementById('tanggal_mulai').value;
let durasi = parseInt(document.getElementById('durasi').value) || 0;

if(mulai && durasi){

let t = new Date(mulai);
t.setMonth(t.getMonth() + durasi);

let selesai = t.toISOString().split('T')[0];

document.getElementById('tanggal_selesai_preview').value = selesai;

}

}

document.querySelectorAll('.pilihProduk').forEach(item=>{
item.addEventListener('change', hitungTotal);
});

document.getElementById('durasi').addEventListener('input', hitungTotal);
document.getElementById('uang_bayar').addEventListener('input', hitungTotal);
document.getElementById('tanggal_mulai').addEventListener('change', hitungTotal);

</script>

<?= view('layout/footer') ?>