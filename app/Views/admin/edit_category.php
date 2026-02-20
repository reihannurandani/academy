<h3>Edit Kategori</h3>

<form method="post" action="<?= base_url('admin/update-category/'.$category['id']) ?>">
    <input name="nama_kategori" value="<?= $category['nama_kategori'] ?>">
    <textarea name="deskripsi"><?= $category['deskripsi'] ?></textarea>
    <button>Update</button>
</form>
