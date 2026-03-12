<div class="sidebar">

    <div>
        <div class="logo">
            <h4>GLOBAL LANGUAGE<br>ACADEMY 🌍</h4>
        </div>

        <?php $role = session()->get('role'); ?>

        <?php if($role == 'admin'): ?>
            <a href="<?= base_url('admin/dashboard') ?>"><i class="fa fa-home"></i> Dashboard</a>
            <a href="<?= base_url('admin/users') ?>"><i class="fa fa-users"></i> Users</a>
            <a href="<?= base_url('admin/categories') ?>"><i class="fa fa-layer-group"></i> Categories</a>
            <a href="<?= base_url('admin/products') ?>"><i class="fa fa-language"></i> Mapel</a>
        <?php endif; ?>

        <?php if($role == 'kasir'): ?>
            <a href="<?= base_url('kasir/dashboard') ?>"><i class="fa fa-home"></i> Dashboard</a>
            <a href="<?= base_url('kasir/transaksi') ?>"><i class="fa fa-cash-register"></i> Transaksi</a>
        <?php endif; ?>

        <?php if($role == 'owner'): ?>
            <a href="<?= base_url('owner/dashboard') ?>"><i class="fa fa-home"></i> Dashboard</a>
            <a href="<?= base_url('owner/laporan') ?>"><i class="fa fa-chart-line"></i> Laporan</a>
            <a href="<?= base_url('owner/logs') ?>"><i class="fa fa-clock-rotate-left"></i> Logs</a>
        <?php endif; ?>
    </div>

    <a href="<?= base_url('logout') ?>" class="logout">
        <i class="fa fa-right-from-bracket"></i> Logout
    </a>

</div>