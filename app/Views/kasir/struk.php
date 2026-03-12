<div class="container mt-4">

<div class="card shadow" style="max-width:420px;margin:auto;font-family:monospace">

<div class="card-body">

<div class="text-center">
<h5>GLOBAL LANGUAGE ACADEMY</h5>
<small>Kursus Bahasa Internasional</small>
</div>

<hr style="border-top:dashed 1px">

<p>
Invoice : <?= $transaksi['invoice'] ?><br>
Tanggal : <?= date('d-m-Y H:i', strtotime($transaksi['created_at'])) ?><br>
Siswa   : <?= $transaksi['nama_siswa'] ?>
</p>

<hr style="border-top:dashed 1px">

<p>
Mulai   : <?= date('d-m-Y', strtotime($transaksi['tanggal_mulai'])) ?><br>
Selesai : <?= date('d-m-Y', strtotime($transaksi['tanggal_selesai'])) ?><br>
Durasi  : <?= $transaksi['durasi'] ?> Bulan
</p>

<hr style="border-top:dashed 1px">

<table width="100%">
<thead>
<tr>
<th align="left">Program</th>
<th align="center">/bln</th>
<th align="right">Harga</th>
</tr>
</thead>

<tbody>

<?php foreach($detail as $d): ?>

<tr>
<td><?= $d['nama_produk'] ?></td>
<td align="center"><?= $d['qty'] ?></td>
<td align="right">
Rp <?= number_format($d['subtotal'],0,',','.') ?>
</td>
</tr>

<?php endforeach; ?>

</tbody>
</table>

<hr style="border-top:dashed 1px">

<table width="100%">

<tr>
<td>Total</td>
<td align="right">
Rp <?= number_format($transaksi['total_harga'],0,',','.') ?>
</td>
</tr>

<tr>
<td>Bayar</td>
<td align="right">
Rp <?= number_format($transaksi['uang_bayar'],0,',','.') ?>
</td>
</tr>

<tr>
<td>Kembali</td>
<td align="right">
Rp <?= number_format($transaksi['uang_kembali'],0,',','.') ?>
</td>
</tr>

</table>

<hr style="border-top:dashed 1px">

<p class="text-center">
Status : <b>LUNAS</b>
</p>

<p class="text-center">
Terima kasih telah mendaftar
</p>

<p class="text-center">
<b>Hari Minggu Libur</b>
</p>

<div class="text-center mt-3 no-print">
<button onclick="window.print()" class="btn btn-primary btn-sm">
Print Struk
</button>
</div>

</div>
</div>
</div>

<style>
@media print{
.no-print{
display:none;
}
}
</style>

<?= view('layout/footer') ?>