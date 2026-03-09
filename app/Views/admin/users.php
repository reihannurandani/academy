<?= view('layout/header') ?>
<?= view('layout/sidebar') ?>
<link rel="stylesheet" href="<?= base_url('assets/css/admin-menu.css') ?>">

<div class="main">

    <div class="page-header">
        <h2>Kelola User</h2>
    </div>

    <div class="menu-container">

        <div class="action-bar">
            <a href="<?= base_url('admin/create-user') ?>" class="btn-add">
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
                    <th>Nama User</th>
                    <th>Nama</th>
                    <th>Role</th>
                    <th>Status</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
            <?php $no=1; foreach($users as $u): ?>
                <tr>
                    <td><?= $no++ ?></td>
                    <td><?= esc($u['username']) ?></td>
                    <td><?= esc($u['nama']) ?></td>
                    <td><?= esc($u['role']) ?></td>
                    <td>
                        <?php if($u['status']=='aktif'): ?>
                            <span class="badge-success">aktif</span>
                        <?php else: ?>
                            <span class="badge-danger">nonaktif</span>
                        <?php endif; ?>
                    </td>
                    <td>
                        <a href="<?= base_url('admin/edit-user/'.$u['id']) ?>" class="btn-edit">edit</a>

                        <!-- Tombol Hapus -->
                        <button class="btn-delete"
                                onclick="openModal(<?= $u['id']; ?>)">
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
        "<?= base_url('admin/delete-user/') ?>" + id;
}

function closeModal() {
    document.getElementById("confirmModal").style.display = "none";
}
</script>

<?= view('layout/footer') ?>