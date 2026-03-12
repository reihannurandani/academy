<?= view('layout/header') ?>
<?= view('layout/sidebar') ?>
<link rel="stylesheet" href="<?= base_url('assets/css/admin-menu.css') ?>">

<div class="main">

    <div class="page-header">
        <h2>Kelola Bahasa</h2>
    </div>

    <div class="menu-container">

        <div class="action-bar">
            <a href="<?= base_url('admin/create-product') ?>" class="btn-add">
                Tambah +
            </a>

            <div class="search-box">
                <input type="text" placeholder="Cari...">
            </div>
        </div>

        <table class="table-custom">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Nama Bahasa</th>
                    <th>Kategori</th>
                    <th>Harga</th>
                    <th>Jam</th>
                    <th>Kuota</th>
                    <th>mentor</th>
                    <th>Status</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
            <?php $no=1; foreach($products as $p): ?>
                <tr>
                    <td><?= $no++ ?></td>
                    <td><?= esc($p['nama_produk']) ?></td>
                    <td><?= esc($p['nama_kategori']) ?></td>
                    <td>Rp <?= number_format($p['harga_produk'],0,',','.') ?></td>
                    <td><?= esc($p['jam_kursus']) ?></td>
                    <td><?= esc($p['kuota']) ?></td>
                    <td><?= esc($p['mentor']) ?></td>
                    <td>
                        <?php if($p['status']=='tersedia'): ?>
                            <span class="badge-success">tersedia</span>
                        <?php else: ?>
                            <span class="badge-danger">tidak</span>
                        <?php endif; ?>
                    </td>
                    <td>
                        <a href="<?= base_url('admin/edit-product/'.$p['id']) ?>" class="btn-edit">edit</a>

                        <!-- Tombol Hapus -->
                        <button class="btn-delete"
                                onclick="openModal(<?= $p['id']; ?>)">
                            🗑
                        </button>
                    </td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>

    </div>

</div>

<!-- ========================= -->
<!-- MODAL KONFIRMASI -->
<!-- ========================= -->
<div id="confirmModal" class="modal-overlay">
    <div class="modal-box">
        <h3>Yakin?</h3>

        <div class="modal-action">
            <a id="confirmDelete" href="#" class="btn-yes">Ya</a>
            <button onclick="closeModal()" class="btn-cancel">Cancel</button>
        </div>
    </div>
</div>

<script>
function openModal(id) {
    document.getElementById("confirmModal").style.display = "flex";
    document.getElementById("confirmDelete").href =
        "<?= base_url('admin/delete-product/') ?>" + id;
}

function closeModal() {
    document.getElementById("confirmModal").style.display = "none";
}
</script>

<?= view('layout/footer') ?>