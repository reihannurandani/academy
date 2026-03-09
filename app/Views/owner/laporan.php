<?= view('layout/header') ?>
<?= view('layout/sidebar') ?>

<link rel="stylesheet" href="<?= base_url('assets/css/owner.css') ?>">

<div class="main">

    <div class="top-box">
        <div>
            <h2>Keuangan</h2>
        </div>

        <a href="<?= base_url('owner/cetak-pdf') ?>" class="btn-pdf">
            Cetak PDF
        </a>
    </div>

    <!-- CARD AREA -->
    <div class="card-grid">

        <div class="finance-card">
            <h3>Rp.<?= number_format($pendapatanHariIni ?? 0,0,',','.') ?></h3>
            <p>Pendapatan Hari Ini</p>
        </div>

        <div class="finance-card">
            <h3>Rp.<?= number_format($pendapatanBulanIni ?? 0,0,',','.') ?></h3>
            <p>Pendapatan Bulan Ini</p>
        </div>

        <div class="finance-card">
            <h3><?= $totalTransaksi ?></h3>
            <p>Total Transaksi</p>
        </div>

        <div class="finance-card">
            <h3>Rp.<?= number_format($totalPendapatan ?? 0,0,',','.') ?></h3>
            <p>Total Pendapatan</p>
        </div>

    </div>

    <!-- TABLE -->
    <h3 class="table-title">Data Transaksi</h3>

    <div class="table-wrapper">
        <table>
            <thead>
                <tr>
                    <th>Invoice</th>
                    <th>Total</th>
                    <th>Tanggal</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach($transactions as $t): ?>
                <tr>
                    <td><?= $t['invoice'] ?></td>
                    <td>Rp.<?= number_format($t['total_harga'],0,',','.') ?></td>
                    <td><?= date('Y-m-d H:i', strtotime($t['created_at'])) ?></td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>

</div>

<?= view('layout/footer') ?>