<?= view('layout/header') ?>
<?= view('layout/sidebar') ?>

<div class="main">

    <!-- HEADER + LOGO -->
    <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:20px;">
        <h2>Tambah User</h2>

        <lottie-player
            src="https://assets2.lottiefiles.com/packages/lf20_zrqthn6o.json"
            background="transparent"
            speed="1"
            style="width:120px;height:120px;"
            loop
            autoplay>
        </lottie-player>
    </div>

    <div style="background:#cbd5e1; padding:40px; border-radius:30px; width:500px;">

        <form method="post" action="<?= base_url('admin/store-user') ?>">

            <input name="username" class="form-control mb-3" placeholder="Username" required>

            <input name="password" type="password" class="form-control mb-3" placeholder="Password" required>

            <input name="nama" class="form-control mb-3" placeholder="Nama Lengkap" required>

            <select name="role" class="form-control mb-3">
                <option value="admin">Admin</option>
                <option value="kasir">Kasir</option>
                <option value="owner">Owner</option>
            </select>

            <select name="status" class="form-control mb-4">
                <option value="aktif">Aktif</option>
                <option value="nonaktif">Nonaktif</option>
            </select>

            <button style="background:#2563eb; color:white; padding:10px 25px; border-radius:20px; border:none;">
                Simpan User
            </button>

            <a href="<?= base_url('admin/users') ?>" 
               style="margin-left:10px; text-decoration:none;">
               Batal
            </a>

        </form>

    </div>

</div>

<?= view('layout/footer') ?>
