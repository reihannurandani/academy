<?= view('layout/header') ?>
<?= view('layout/sidebar') ?>
<link rel="stylesheet" href="<?= base_url('assets/css/admin-form.css') ?>">

<div class="main">

    <div class="page-header">
        Kelola User
    </div>

    <div class="form-section">

        <div class="form-label-badge">
            edit
        </div>

        <div class="form-card">

            <form method="post" action="<?= base_url('admin/update-user/'.$user['id']) ?>">

                <input 
                    name="username" 
                    value="<?= esc($user['username']) ?>"
                    class="form-input"
                    placeholder="Username"
                    required
                >

                <input 
                    name="nama" 
                    value="<?= esc($user['nama']) ?>"
                    class="form-input"
                    placeholder="Nama"
                    required
                >

                <input 
                    type="password"
                    name="password"
                    class="form-input"
                    placeholder="Password baru (kosongkan jika tidak diganti)"
                >

                <select name="role" class="form-input">
                    <option value="admin" <?= $user['role']=='admin'?'selected':'' ?>>Admin</option>
                    <option value="kasir" <?= $user['role']=='kasir'?'selected':'' ?>>Kasir</option>
                    <option value="owner" <?= $user['role']=='owner'?'selected':'' ?>>Owner</option>
                </select>

                <select name="status" class="form-input">
                    <option value="aktif" <?= $user['status']=='aktif'?'selected':'' ?>>Aktif</option>
                    <option value="nonaktif" <?= $user['status']=='nonaktif'?'selected':'' ?>>Nonaktif</option>
                </select>

                <button type="submit" class="btn-update">
                    Update
                </button>

            </form>

        </div>

        <a href="<?= base_url('admin/users') ?>" class="btn-back">
            kembali
        </a>

    </div>

</div>

<?= view('layout/footer') ?>