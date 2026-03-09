<!DOCTYPE html>
<html>
<head>
    <title>Laporan Keuangan</title>
    <style>
        body { font-family: sans-serif; font-size: 12px; }
        h2 { text-align: center; }
        table { width: 100%; border-collapse: collapse; margin-top: 10px; }
        table, th, td { border: 1px solid black; }
        th, td { padding: 6px; text-align: center; }
        .summary td { text-align: left; }
    </style>
</head>
<body>

<h2>LAPORAN KEUANGAN</h2>

<!-- ================= RINGKASAN ================= -->
<table class="summary">
    <tr>
        <td>Total Transaksi</td>
        <td>: <?= $totalTransaksi ?></td>
    </tr>
    <tr>
        <td>Pendapatan Hari Ini</td>
        <td>: Rp <?= number_format($pendapatanHariIni,0,',','.') ?></td>
    </tr>
    <tr>
        <td>Pendapatan Bulan Ini</td>
        <td>: Rp <?= number_format($pendapatanBulanIni,0,',','.') ?></td>
    </tr>
    <tr>
        <td><strong>Total Seluruh Pendapatan</strong></td>
        <td><strong>: Rp <?= number_format($totalPendapatan,0,',','.') ?></strong></td>
    </tr>
</table>

<br>

<!-- ================= TABEL TRANSAKSI ================= -->
<table>
    <thead>
        <tr>
            <th>No</th>
            <th>Invoice</th>
            <th>Total</th>
            <th>Tanggal</th>
        </tr>
    </thead>
    <tbody>
        <?php $no = 1; foreach($transactions as $t): ?>
        <tr>
            <td><?= $no++ ?></td>
            <td><?= $t['invoice'] ?></td>
            <td>Rp <?= number_format($t['total_harga'],0,',','.') ?></td>
            <td><?= date('d-m-Y', strtotime($t['created_at'])) ?></td>
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>

</body>
</html>