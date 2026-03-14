<?= view('layout/header') ?>
<?= view('layout/sidebar') ?>
<link rel="stylesheet" href="<?= base_url('assets/css/admin-form.css') ?>">

<div class="main">
    
<h3>Edit Produk</h3>

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

        <label>Harga Produk</label>
        <input type="number" name="harga_produk" value="<?= $product['harga_produk'] ?>" required>

        <label>Jam Kursus</label>
        <input type="text" name="jam_kursus" value="<?= $product['jam_kursus'] ?>" placeholder="Jam Kursus (contoh: 13:00 - 15:00)" required>

        <label>Kuota</label>
        <input type="number" name="kuota" value="<?= $product['kuota'] ?>">

        <label>Mentor</label>
        <input type="text" name="mentor" value="<?= $product['mentor'] ?>" placeholder="Mentor">

        <label>Status</label>
        <select name="status">
            <option value="tersedia" <?= $product['status']=='tersedia'?'selected':'' ?>>Tersedia</option>
            <option value="tidak tersedia" <?= $product['status']=='tidak tersedia'?'selected':'' ?>>Tidak Tersedia</option>
        </select>

        <button class="tambah">Update</button>
        <a href="<?= base_url('admin/products') ?>" class="kembali">← Kembali</a>
    </form>
</div>
