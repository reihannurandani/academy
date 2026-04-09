<?php 
$uri = service('uri');
$segment1 = $uri->getSegment(1);
$segment2 = $uri->getSegment(2);
?>

<div class="sidebar">

    <div>
        <div class="logo">
            <h4>GLOBAL LANGUAGE<br>ACADEMY 🌍</h4>
        </div>

        <?php $role = session()->get('role'); ?>

        <?php if($role == 'admin'): ?>
            <a href="<?= base_url('admin/dashboard') ?>" class="<?= ($segment2=='dashboard')?'active':'' ?>">
                <i class="fa fa-home"></i> Dashboard
            </a>

            <a href="<?= base_url('admin/users') ?>" class="<?= ($segment2=='users')?'active':'' ?>">
                <i class="fa fa-users"></i> Users
            </a>

            <a href="<?= base_url('admin/categories') ?>" class="<?= ($segment2=='categories')?'active':'' ?>">
                <i class="fa fa-layer-group"></i> Categories
            </a>

            <a href="<?= base_url('admin/products') ?>" class="<?= ($segment2=='products')?'active':'' ?>">
                <i class="fa fa-language"></i> Mapel
            </a>
        <?php endif; ?>

         <?php if($role == 'kasir'): ?>

            <a href="<?= base_url('kasir/dashboard') ?>" 
               class="<?= (strpos($uri,'kasir') !== false && strpos($uri,'transaksi') === false && strpos($uri,'riwayat') === false) ? 'active' : '' ?>">
                <i class="fa fa-home"></i> Dashboard
            </a>

            <a href="<?= base_url('kasir/transaksi') ?>" 
               class="<?= (strpos($uri,'transaksi') !== false) ? 'active' : '' ?>">
                <i class="fa fa-cash-register"></i> Transaksi
            </a>

            <a href="<?= base_url('kasir/riwayat') ?>" 
               class="<?= (strpos($uri,'riwayat') !== false) ? 'active' : '' ?>">
                <i class="fa fa-clock"></i> Riwayat Transaksi
            </a>

            <a href="<?= base_url('kasir/perpanjang') ?>" 
                class="<?= (strpos($uri,'perpanjang') !== false) ? 'active' : '' ?>">
                    <i class="fa fa-repeat"></i> Perpanjangan
            </a>

        <?php endif; ?>

        <?php if($role == 'owner'): ?>
            <a href="<?= base_url('owner/dashboard') ?>" class="<?= ($segment2=='dashboard')?'active':'' ?>">
                <i class="fa fa-home"></i> Dashboard
            </a>

            <a href="<?= base_url('owner/laporan') ?>" class="<?= ($segment2=='laporan')?'active':'' ?>">
                <i class="fa fa-chart-line"></i> Laporan
            </a>

            <a href="<?= base_url('owner/logs') ?>" class="<?= ($segment2=='logs')?'active':'' ?>">
                <i class="fa fa-clock-rotate-left"></i> Logs
            </a>
        <?php endif; ?>
    </div>

    <a href="<?= base_url('logout') ?>" class="logout">
        <i class="fa fa-right-from-bracket"></i> Logout
    </a>

</div>