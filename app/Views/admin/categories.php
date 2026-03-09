<?= view('layout/header') ?>
<?= view('layout/sidebar') ?>
<link rel="stylesheet" href="<?= base_url('assets/css/admin-menu.css') ?>">

<div class="main">

    <div class="page-header">
        <h2>Kelola Kategori</h2>
    </div>

    <div class="menu-container">

        <div class="action-bar">
            <a href="<?= base_url('admin/create-category') ?>" class="btn-add">
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
                    <th>Nama Kategori</th>
                    <th>Deskripsi</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
            <?php $no=1; foreach($categories as $c): ?>
                <tr>
                    <td><?= $no++ ?></td>
                    <td><?= esc($c['nama_kategori']) ?></td>
                    <td><?= esc($c['deskripsi']) ?></td>
                    <td>
                        <a href="<?= base_url('admin/edit-category/'.$c['id']) ?>" class="btn-edit">edit</a>

                        <!-- Tombol Hapus -->
                        <button class="btn-delete"
                                onclick="openModal(<?= $c['id']; ?>)">
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
        "<?= base_url('admin/delete-category/') ?>" + id;
}

function closeModal() {
    document.getElementById("confirmModal").style.display = "none";
}
</script>

<?= view('layout/footer') ?>