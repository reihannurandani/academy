<?= view('layout/header') ?>
<?= view('layout/sidebar') ?>
<link rel="stylesheet" href="<?= base_url('assets/css/admin-form.css') ?>">

<div class="main">

    <div class="page-header">
        Kelola User
    </div>

    <div class="form-section">

        <div class="form-label-badge">
            tambah
        </div>

        <div class="form-card">

            <form method="post" action="<?= base_url('admin/store-user') ?>">

                <input 
                    name="username" 
                    class="form-input" 
                    placeholder="Username"
                    required
                >

                <input  
                    name="nama" 
                    class="form-input" 
                    placeholder="Nama"
                    required
                >

                <input 
                    type="password"
                    name="password"
                    class="form-input"
                    placeholder="Password"
                    required
                >

                <select name="role" class="form-input">
                    <option value="admin">Admin</option>
                    <option value="kasir">Kasir</option>
                    <option value="owner">Owner</option>
                </select>

                <select name="status" class="form-input">
                    <option value="aktif">Aktif</option>
                    <option value="nonaktif">Nonaktif</option>
                </select>

                <button type="submit" class="btn-update">
                    Simpan
                </button>

            </form>

        </div>

        <a href="<?= base_url('admin/users') ?>" class="btn-back">
            kembali
        </a>

    </div>

</div>

<?= view('layout/footer') ?>