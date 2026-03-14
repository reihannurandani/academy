<?= view('layout/header') ?>
<?= view('layout/sidebar') ?>
<link rel="stylesheet" href="<?= base_url('assets/css/admin-form.css') ?>">

<div class="main">
    
<h3>Edit Kategori</h3>

<div class="table-box" style="max-width:500px;">
    <form method="post" action="<?= base_url('admin/update-category/'.$category['id']) ?>" class="form-user">
        <label>Nama Kategori</label>
        <input name="nama_kategori" value="<?= $category['nama_kategori'] ?>" required>

        <label>Deskripsi</label>
        <textarea name="deskripsi" required><?= $category['deskripsi'] ?></textarea>

        <button class="tambah">Update</button>
        <a href="<?= base_url('admin/categories') ?>" class="kembali">← Kembali</a>
    </form>
</div>
