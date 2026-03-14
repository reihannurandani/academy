<?= view('layout/header') ?>
<?= view('layout/sidebar') ?>
<link rel="stylesheet" href="<?= base_url('assets/css/admin-form.css') ?>">

<div class="main">

    <h3>Tambah User</h3>

    <div class="table-box" style="max-width:500px;">

        <form method="post" action="<?= base_url('admin/store-user') ?>" class="form-user">

            <input 
                type="text"
                name="username" 
                placeholder="Username"
                required
            >

            <input  
                type="text"
                name="nama" 
                placeholder="Nama"
                required
            >

            <input 
                type="password"
                name="password"
                placeholder="Password"
                required
            >

            <select name="role" required>
                <option value="">Pilih Role</option>
                <option value="admin">Admin</option>
                <option value="kasir">Kasir</option>
                <option value="owner">Owner</option>
            </select>

            <select name="status" required>
                <option value="">Pilih Status</option>
                <option value="aktif">Aktif</option>
                <option value="nonaktif">Nonaktif</option>
            </select>

            <button class="tambah">
                Simpan
            </button>

            <a href="<?= base_url('admin/users') ?>" class="kembali">
                ← Kembali
            </a>

        </form>

    </div>

</div>

<?= view('layout/footer') ?>