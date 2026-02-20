<?= view('layout/header') ?>
<?= view('layout/sidebar') ?>

<div class="main">

    <h4 class="mb-3">Kelola Bahasa</h4>

    <a href="<?= base_url('admin/create-product') ?>" class="tambah">
        + Tambah Produk
    </a>

    <div class="content-box mt-3">

        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Nama</th>
                    <th>Kategori</th>
                    <th>Harga</th>
                    <th>Jam</th>
                    <th>Kuota</th>
                    <th>Status</th>
                    <th width="120">Aksi</th>
                </tr>
            </thead>
            <tbody>
            <?php foreach($products as $p): ?>
                <tr>
                    <td><?= esc($p['nama_produk']) ?></td>
                    <td><?= esc($p['nama_kategori']) ?></td>
                    <td>Rp <?= number_format($p['harga_produk'],0,',','.') ?></td>
                    <td><?= esc($p['jam_kursus']) ?></td>
                    <td><?= esc($p['kuota']) ?></td>
                    <td>
                        <?php if($p['status']=='tersedia'): ?>
                            <span class="badge-success">Tersedia</span>
                        <?php else: ?>
                            <span class="badge-danger">Tidak</span>
                        <?php endif; ?>
                    </td>
                    <td>
                        <a href="<?= base_url('admin/edit-product/'.$p['id']) ?>">Edit</a> |
                        <a href="<?= base_url('admin/delete-product/'.$p['id']) ?>">Delete</a>
                    </td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>

    </div>

</div>

<?= view('layout/footer') ?>
