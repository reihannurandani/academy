<?= view('layout/header') ?>
<?= view('layout/sidebar') ?>

<link rel="stylesheet" href="<?= base_url('assets/css/owner.css') ?>">

<div class="main">

    <div class="top-box">
        <div>
            <h2>Logs Activity</h2>
        </div>
    </div>

    <h3 class="table-title">Aktivitas Sistem</h3>

    <div class="table-wrapper">
        <table>
            <thead>
                <tr>
                    <th>No</th>
                    <th>User</th>
                    <th>Activity</th>
                    <th>Waktu</th>
                </tr>
            </thead>
            <tbody>
                <?php $no=1; foreach($logs as $l): ?>
                <tr>
                    <td><?= $no++ ?></td>
                    <td><?= $l['nama'] ?></td>
                    <td><?= $l['activity'] ?></td>
                    <td><?= date('Y-m-d H:i', strtotime($l['created_at'])) ?></td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>

</div>

<?= view('layout/footer') ?>