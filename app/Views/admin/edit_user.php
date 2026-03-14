<?= view('layout/header') ?>
<?= view('layout/sidebar') ?>
<link rel="stylesheet" href="<?= base_url('assets/css/admin-form.css') ?>">

<div class="main">

    <h3>Edit User</h3>

    <div class="table-box" style="max-width:500px;">
        <form method="post" action="<?= base_url('admin/update-user/'.$user['id']) ?>" class="form-user">
            <label>Username</label>
            <input name="username" value="<?= esc($user['username']) ?>" placeholder="Username" required>

            <label>Nama</label>
            <input name="nama" value="<?= esc($user['nama']) ?>" placeholder="Nama" required>

            <label>Password Baru</label>
            <input type="password" name="password" placeholder="Password baru (kosongkan jika tidak diganti)">

            <label>Role</label>
            <select name="role">
                <option value="admin" <?= $user['role']=='admin'?'selected':'' ?>>Admin</option>
                <option value="kasir" <?= $user['role']=='kasir'?'selected':'' ?>>Kasir</option>
                <option value="owner" <?= $user['role']=='owner'?'selected':'' ?>>Owner</option>
            </select>

            <label>Status</label>
            <select name="status">
                <option value="aktif" <?= $user['status']=='aktif'?'selected':'' ?>>Aktif</option>
                <option value="nonaktif" <?= $user['status']=='nonaktif'?'selected':'' ?>>Nonaktif</option>
            </select>

            <button class="tambah">Update</button>
            <a href="<?= base_url('admin/users') ?>" class="kembali">← Kembali</a>
        </form>
    </div>

</div>

<?= view('layout/footer') ?>