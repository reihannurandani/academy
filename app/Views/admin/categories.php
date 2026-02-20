<?= view('layout/header') ?>
<?= view('layout/sidebar') ?>

<div class="main">

    <h3>Kelola Kategori</h3>

    <a href="<?= base_url('admin/create-category') ?>" class="tambah">
        + Tambah Kategori
    </a>

    <div class="table-box mt-3">

        <table class="table table-bordered">
            <tr>
                <th>Nama</th>
                <th>Deskripsi</th>
                <th width="120">Aksi</th>
            </tr>

            <?php foreach($categories as $c): ?>
            <tr>
                <td><?= esc($c['nama_kategori']) ?></td>
                <td><?= esc($c['deskripsi']) ?></td>
                <td>
                    <a href="<?= base_url('admin/edit-category/'.$c['id']) ?>">Edit</a> |
                    <a href="<?= base_url('admin/delete-category/'.$c['id']) ?>"
                       onclick="return confirm('Yakin?')">
                       Delete
                    </a>
                </td>
            </tr>
            <?php endforeach; ?>

        </table>

    </div>

</div>

<?= view('layout/footer') ?>
