<?= view('layout/header') ?>
<?= view('layout/sidebar') ?>
<link rel="stylesheet" href="<?= base_url('assets/css/admin-form.css') ?>">

<div class="main">

    <h3>Tambah Produk</h3>

    <div class="table-box" style="max-width:500px;">

        <form method="post" action="<?= base_url('admin/store-product') ?>" class="form-user">

            <label for="id_kategori">Kategori</label>
            <select name="id_kategori" id="id_kategori" required>
                <?php foreach($categories as $c): ?>
                    <option value="<?= $c['id'] ?>">
                        <?= esc($c['nama_kategori']) ?>
                    </option>
                <?php endforeach; ?>
            </select>

            <label for="nama_produk">Nama Produk</label>
            <input type="text" name="nama_produk" id="nama_produk" placeholder="Nama Produk" required>

            <label for="harga_produk">Harga</label>
            <input type="number" name="harga_produk" id="harga_produk" placeholder="Harga" required>

            <label for="jam_kursus">Jam Kursus</label>
            <input type="text" name="jam_kursus" id="jam_kursus" placeholder="Jam Kursus (contoh: 13:00 - 15:00)" required>

            <label for="kuota">Kuota</label>
            <input type="number" name="kuota" id="kuota" placeholder="Kuota">

            <label for="mentor">Mentor</label>
            <input type="text" name="mentor" id="mentor" placeholder="Mentor">

            <label for="status">Status</label>
            <select name="status" id="status">
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
