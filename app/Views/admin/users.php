<?= view('layout/header') ?>
<?= view('layout/sidebar') ?>

<div class="main">

    <!-- HEADER WITH LOGO -->
    <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:20px;">
        <h2>Kelola User</h2>

        <lottie-player
            src="https://assets2.lottiefiles.com/packages/lf20_zrqthn6o.json"
            background="transparent"
            speed="1"
            style="width:120px;height:120px;"
            loop
            autoplay>
        </lottie-player>
    </div>

    <!-- BUTTON TAMBAH -->
    <div style="margin-bottom:20px;">
        <a href="<?= base_url('admin/create-user') ?>" 
           style="background:#2563eb; color:white; padding:10px 20px; border-radius:20px; text-decoration:none;">
           + Tambah User
        </a>
    </div>

    <!-- TABEL -->
    <div style="background:#cbd5e1; padding:30px; border-radius:25px;">
        <table class="table table-bordered">
            <thead style="background:#1e3a8a; color:white;">
                <tr>
                    <th>Nama</th>
                    <th>Username</th>
                    <th>Role</th>
                    <th>Status</th>
                    <th width="150">Aksi</th>
                </tr>
            </thead>

            <tbody>
            <?php if(!empty($users)): ?>
                <?php foreach($users as $u): ?>
                <tr>
                    <td><?= esc($u['nama']) ?></td>
                    <td><?= esc($u['username']) ?></td>
                    <td><?= esc($u['role']) ?></td>
                    <td>
                        <?php if($u['status'] == 'aktif'): ?>
                            <span style="background:#16a34a; color:white; padding:5px 10px; border-radius:15px;">
                                Aktif
                            </span>
                        <?php else: ?>
                            <span style="background:#dc2626; color:white; padding:5px 10px; border-radius:15px;">
                                Nonaktif
                            </span>
                        <?php endif; ?>
                    </td>
                    <td>
                        <a href="<?= base_url('admin/edit-user/'.$u['id']) ?>">Edit</a> |
                        <a href="<?= base_url('admin/delete-user/'.$u['id']) ?>"
                           onclick="return confirm('Yakin ingin hapus?')">
                           Delete
                        </a>
                    </td>
                </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="5" align="center">Belum ada data</td>
                </tr>
            <?php endif; ?>
            </tbody>
        </table>
    </div>

</div>

<?= view('layout/footer') ?>
