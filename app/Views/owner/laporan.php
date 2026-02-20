<?= view('layout/header') ?>
<?= view('layout/sidebar') ?>

<h3>Laporan Transaksi</h3>

<form method="get">
    <input type="date" name="start">
    <input type="date" name="end">
    <button class="btn btn-primary btn-sm">Filter</button>
</form>

<table class="table table-bordered mt-3">
<tr><th>Invoice</th><th>Total</th><th>Tanggal</th></tr>
<?php foreach($transactions as $t): ?>
<tr>
<td><?= $t['invoice'] ?></td>
<td><?= number_format($t['total_harga']) ?></td>
<td><?= $t['created_at'] ?></td>
</tr>
<?php endforeach; ?>
</table>

<?= view('layout/footer') ?>
