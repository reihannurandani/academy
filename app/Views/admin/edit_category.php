
<link rel="stylesheet" href="<?= base_url('assets/css/admin-form.css') ?>">

<h3>Edit Kategori</h3>

<form method="post" action="<?= base_url('admin/update-category/'.$category['id']) ?>">
    <input name="nama_kategori" value="<?= $category['nama_kategori'] ?>">
    <textarea name="deskripsi"><?= $category['deskripsi'] ?></textarea>
    <button>Update</button>
                <a href="<?= base_url('admin/categories') ?>" class="kembali">
                ← Kembali
            </a>
</form>
