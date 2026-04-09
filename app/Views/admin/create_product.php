<?= view('layout/header') ?>
<?= view('layout/sidebar') ?>
<link rel="stylesheet" href="<?= base_url('assets/css/admin-form.css') ?>">

<div class="main">

    <h3>Tambah Produk</h3>

    <?php if(session()->getFlashdata('error')): ?>
        <div style="background:#ff4d4d;color:white;padding:10px;border-radius:6px;margin-bottom:10px;">
            <?= session()->getFlashdata('error') ?>
        </div>
    <?php endif; ?>

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

            <label>Nama Produk</label>
            <input type="text" name="nama_produk" required>

            <label>Hari Mulai</label>
            <select name="hari_mulai" required>
                <option>Senin</option>
                <option>Selasa</option>
                <option>Rabu</option>
                <option>Kamis</option>
                <option>Jumat</option>
                <option>Sabtu</option>
                <option>Minggu</option>
            </select>

            <label>Hari Selesai</label>
            <select name="hari_selesai" required>
                <option>Senin</option>
                <option>Selasa</option>
                <option>Rabu</option>
                <option>Kamis</option>
                <option>Jumat</option>
                <option>Sabtu</option>
                <option>Minggu</option>
            </select>

            <label>Jam Mulai</label>
            <input type="time" name="jam_mulai" required>

            <label>Jam Selesai</label>
            <input type="time" name="jam_selesai" required>

            <label>Harga</label>
            <input type="number" name="harga_produk" required>

            <label>Kuota</label>
            <input type="number" name="kuota">

            <label>Mentor</label>
            <input type="text" name="mentor">

            <button class="tambah">Simpan</button>
            <a href="<?= base_url('admin/products') ?>" class="kembali">← Kembali</a>

        </form>

    </div>

</div>

<?= view('layout/footer') ?>