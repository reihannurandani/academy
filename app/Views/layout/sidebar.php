<div class="bg-dark text-white p-3" style="width:250px; min-height:100vh;">
    <h4>GLOBAL LANGUAGE<br>ACADEMY 🌍</h4>
    <hr>

    <?php if(session()->get('role') == 'admin'): ?>
        <a href="<?= base_url('admin/dashboard') ?>" class="text-white d-block mb-2">Dashboard</a>
        <a href="<?= base_url('admin/users') ?>" class="text-white d-block mb-2">Users</a>
        <a href="<?= base_url('admin/categories') ?>" class="text-white d-block mb-2">Categories</a>
        <a href="<?= base_url('admin/products') ?>" class="text-white d-block mb-2">bahasa</a>
    <?php endif; ?>

    <?php if(session()->get('role') == 'kasir'): ?>
        <a href="<?= base_url('kasir/dashboard') ?>" class="text-white d-block mb-2">Dashboard</a>
        <a href="<?= base_url('kasir/transaksi') ?>" class="text-white d-block mb-2">Transaksi</a>
    <?php endif; ?>

    <?php if(session()->get('role') == 'owner'): ?>
        <a href="<?= base_url('owner/dashboard') ?>" class="text-white d-block mb-2">Dashboard</a>
        <a href="<?= base_url('owner/laporan') ?>" class="text-white d-block mb-2">Laporan</a>
        <a href="<?= base_url('owner/logs') ?>" class="text-white d-block mb-2">Logs</a>
    <?php endif; ?>

    <hr>
    <a href="<?= base_url('logout') ?>" class="text-danger">Logout</a>
</div>

<div class="p-4 w-100">
