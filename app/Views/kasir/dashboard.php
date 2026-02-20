<?= view('layout/header') ?>
<?= view('layout/sidebar') ?>

<div class="main">

    <div class="header">
        <h2>Dashboard Kasir</h2>
    </div>

    <div class="dashboard-container">

        <!-- BOX BAHASA TERSEDIA -->
        <div class="dashboard-box">
            <h3>Bahasa Tersedia</h3>

            <div class="table-wrapper">
                <table>
                    <thead>
                        <tr>
                            <th>Bahasa</th>
                            <th>Harga</th>
                            <th>Kuota</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach($products as $p): ?>
                        <tr>
                            <td><?= $p['nama_produk'] ?></td>
                            <td>Rp <?= number_format($p['harga_produk']) ?></td>
                            <td><?= $p['kuota'] ?></td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>

        <!-- BOX SISWA MENDAFTAR -->
            <div class="dashboard-box">
                <h3>Siswa Yang Telah Mendaftar</h3>

                <div class="table-wrapper">
                    <table>
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Nama</th>
                                <th>Kursus</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $no=1; foreach($siswa_daftar as $s): ?>
                            <tr>
                                <td><?= $no++ ?></td>
                                <td><?= $s['nama_siswa'] ?></td>
                                <td><?= $s['kursus'] ?></td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>

    </div>

</div>

<?= view('layout/footer') ?>
