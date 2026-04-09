<?= view('layout/header') ?>
<?= view('layout/sidebar') ?>
<link rel="stylesheet" href="<?= base_url('assets/css/admin-form.css') ?>">

<div class="main">
    
<h3>Edit Produk</h3>

<?php if(session()->getFlashdata('error')): ?>
    <div style="background:#ff4d4d;color:white;padding:10px;border-radius:6px;margin-bottom:10px;">
        <?= session()->getFlashdata('error') ?>
    </div>
<?php endif; ?>

<div class="table-box" style="max-width:500px;">
    <form method="post" action="<?= base_url('admin/update-product/'.$product['id']) ?>" class="form-user">

        <label>Kategori</label>
        <select name="id_kategori" required>
            <?php foreach($categories as $c): ?>
                <option value="<?= $c['id'] ?>" <?= $product['id_kategori']==$c['id']?'selected':'' ?>>
                    <?= esc($c['nama_kategori']) ?>
                </option>
            <?php endforeach; ?>
        </select>

        <label>Nama Produk</label>
        <input type="text" name="nama_produk" value="<?= $product['nama_produk'] ?>" required>

        <label>Hari Mulai</label>
        <select name="hari_mulai">
            <?php $hari = ['Senin','Selasa','Rabu','Kamis','Jumat','Sabtu','Minggu']; ?>
            <?php foreach($hari as $h): ?>
                <option <?= $product['hari_mulai']==$h?'selected':'' ?>><?= $h ?></option>
            <?php endforeach; ?>
        </select>

        <label>Hari Selesai</label>
        <select name="hari_selesai">
            <?php foreach($hari as $h): ?>
                <option <?= $product['hari_selesai']==$h?'selected':'' ?>><?= $h ?></option>
            <?php endforeach; ?>
        </select>

        <label>Jam Mulai</label>
        <input type="time" name="jam_mulai" value="<?= $product['jam_mulai'] ?>" required>

        <label>Jam Selesai</label>
        <input type="time" name="jam_selesai" value="<?= $product['jam_selesai'] ?>" required>

        <label>Harga</label>
        <input type="number" name="harga_produk" value="<?= $product['harga_produk'] ?>" required>

        <label>Kuota</label>
        <input type="number" name="kuota" value="<?= $product['kuota'] ?>">

        <label>Mentor</label>
        <input type="text" name="mentor" value="<?= $product['mentor'] ?>">

        <button class="tambah">Update</button>
        <a href="<?= base_url('admin/products') ?>" class="kembali">← Kembali</a>
    </form>
</div>