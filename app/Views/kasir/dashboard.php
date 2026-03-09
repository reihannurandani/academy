<?= view('layout/header') ?>
<?= view('layout/sidebar') ?>

<link rel="stylesheet" href="<?= base_url('assets/css/kasir.css') ?>">

<div class="main">

    <div class="dashboard-header">
        <h2>Dashboard kasir</h2>
    </div>

    <div class="dashboard-card">

        <!-- Welcome -->
        <div class="welcome-box">
            <h3>Haii Kasir!</h3>
            <p>Selamat Datang Di Dashboard Kasir</p>
            <hr>
        </div>

        <!-- Bahasa tersedia -->
        <div class="section-box">
            <h4>Bahasa tersedia</h4>

            <div class="custom-table">
                <table>
                    <thead>
                        <tr>
                            <th>Bahasa</th>
                            <th>Kategori</th>
                            <th>Harga</th>
                            <th>Kuota</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach($products as $p): ?>
                        <tr>
                            <td><?= esc($p['nama_produk']) ?></td>
                            <td><?= esc($p['kategori'] ?? '-') ?></td>
                            <td>Rp <?= number_format($p['harga_produk'],0,',','.') ?></td>
                            <td><?= esc($p['kuota']) ?></td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Daftar siswa -->
        <div class="section-box mt-30">
            <h4>Daftar Siswa</h4>

            <div class="custom-table">
                <table>
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama</th>
                            <th>Kursus</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $no=1; foreach($siswa_daftar as $s): ?>
                        <tr>
                            <td><?= $no++ ?></td>
                            <td><?= esc($s['nama_siswa']) ?></td>
                            <td><?= esc($s['kursus']) ?></td>
                            <td><span class="status-badge">Aktif</span></td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>

    </div>
</div>

<?= view('layout/footer') ?>