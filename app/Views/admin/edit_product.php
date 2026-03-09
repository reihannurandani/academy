<?= view('layout/header') ?>
<?= view('layout/sidebar') ?>
<link rel="stylesheet" href="<?= base_url('assets/css/admin-form.css') ?>">

<h3>Edit Produk</h3>

<form method="post" action="<?= base_url('admin/update-product/'.$product['id']) ?>">

<select name="id_kategori">
<?php foreach($categories as $c): ?>
<option value="<?= $c['id'] ?>" 
<?= $product['id_kategori']==$c['id']?'selected':'' ?>>
<?= $c['nama_kategori'] ?>
</option>
<?php endforeach; ?>
</select>

<input name="nama_produk" value="<?= $product['nama_produk'] ?>">
<input name="harga_produk" value="<?= $product['harga_produk'] ?>">
<input name="jam_kursus" value="<?= $product['jam_kursus'] ?>">
<input name="kuota" value="<?= $product['kuota'] ?>">

<select name="status">
<option value="tersedia" <?= $product['status']=='tersedia'?'selected':'' ?>>Tersedia</option>
<option value="tidak tersedia" <?= $product['status']=='tidak tersedia'?'selected':'' ?>>Tidak Tersedia</option>
</select>

<button>Update</button>
</form>
