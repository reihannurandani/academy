<?= view('layout/header') ?>
<?= view('layout/sidebar') ?>

<div class="main">

    <h3>Tambah Kategori</h3>

    <div class="table-box" style="max-width:500px;">

        <form method="post" action="<?= base_url('admin/store-category') ?>" class="form-user">

            <input type="text" name="nama_kategori" placeholder="Nama Kategori" required>

            <textarea name="deskripsi" placeholder="Deskripsi"></textarea>

            <button class="tambah">Simpan</button>

            <a href="<?= base_url('admin/categories') ?>" class="kembali">
                ← Kembali
            </a>

        </form>

    </div>

</div>

<?= view('layout/footer') ?>
