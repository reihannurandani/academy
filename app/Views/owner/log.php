<?= view('layout/header') ?>
<?= view('layout/sidebar') ?>

<link rel="stylesheet" href="<?= base_url('assets/css/owner.css') ?>">

<div class="main">

    <!-- HEADER -->
    <div class="top-box">
        <div>
            <h2 style="margin-bottom:5px;">LOG AKTIVITAS USER</h2>
            <small style="color:#888;">Jejak digital semua pengguna & sistem</small>
        </div>
    </div>

    <!-- FILTER -->
    <div class="card-filter">
        <form method="get">

            <div class="filter-left">
                <label>Periode Log</label>
                <div class="date-group">
                    <input type="date" name="start">
                    <span>s/d</span>
                    <input type="date" name="end">
                </div>
            </div>

            <div class="filter-middle">
                <label>Cari User / Aktivitas</label>
                <input type="text" name="search" placeholder="Cari nama user atau aktivitas...">
            </div>

            <div class="filter-right">
                <button class="btn-filter">Terapkan Filter</button>
            </div>

        </form>
    </div>

    <!-- TABLE -->
    <div class="table-wrapper modern">

        <table class="modern-table">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Pelaku (User)</th>
                    <th>Role</th>
                    <th>Tindakan / Aktivitas</th>
                    <th>Waktu Kejadian</th>
                </tr>
            </thead>

            <tbody>
                <?php $no=1; foreach($logs as $l): ?>
                <tr>

                    <td><?= $no++ ?></td>

                    <td>
                        <div class="user-info">
                            <div class="avatar">
                                <i class="fa fa-user"></i>
                            </div>
                            <div>
                                <strong><?= $l['nama'] ?></strong><br>
                                <small>-</small>
                            </div>
                        </div>
                    </td>

                    <td>
                        <?php
                        $role = strtolower($l['role']);
                        $color = 'gray';

                        if($role == 'owner') $color = 'purple';
                        elseif($role == 'kasir') $color = 'blue';
                        elseif($role == 'admin') $color = 'green';
                        ?>

                        <span class="badge <?= $color ?>">
                            <?= strtoupper($l['role']) ?>
                        </span>
                    </td>

                    <td>
                        <?= $l['activity'] ?>
                    </td>

                    <td>
                        <strong><?= date('d M Y', strtotime($l['created_at'])) ?></strong><br>
                        <small><?= date('H:i:s', strtotime($l['created_at'])) ?> WIB</small>
                    </td>

                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>

    </div>

</div>

<?= view('layout/footer') ?>