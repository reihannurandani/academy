<?= view('layout/header') ?>
<?= view('layout/sidebar') ?>

<div class="main">

    <h3>Tambah Produk</h3>

    <div class="table-box" style="max-width:500px;">

        <form method="post" action="<?= base_url('admin/store-product') ?>" class="form-user">

            <label>Kategori</label>
            <select name="id_kategori" required>
                <?php foreach($categories as $c): ?>
                    <option value="<?= $c['id'] ?>">
                        <?= esc($c['nama_kategori']) ?>
                    </option>
                <?php endforeach; ?>
            </select>

            <input type="text" name="nama_produk" placeholder="Nama Produk" required>

            <input type="number" name="harga_produk" placeholder="Harga" required>

            <input type="text" name="jam_kursus" placeholder="Jam Kursus (contoh: 13:00 - 15:00)" required>

            <input type="number" name="kuota" placeholder="Kuota">

            <select name="status">
                <option value="tersedia">Tersedia</option>
                <option value="tidak tersedia">Tidak Tersedia</option>
            </select>

            <button class="tambah">Simpan</button>

            <a href="<?= base_url('admin/products') ?>" class="kembali">
                ← Kembali
            </a>

        </form>

    </div>

</div>

<?= view('layout/footer') ?>
