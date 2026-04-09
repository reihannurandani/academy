<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<title>Struk</title>

<style>
body{
    font-family: monospace;
    font-size: 12px;
    width: 260px;
    margin: auto;
    line-height: 1.4;
    word-wrap: break-word;
}

.text-center{
    text-align:center;
}

.line{
    border-top:1px dashed #000;
    margin:8px 0;
}

/* ✅ BIAR TEKS TIDAK KE POTONG */
.wrap{
    word-break: break-word;
}

/* TABLE PRODUK */
table{
    width:100%;
    border-collapse: collapse;
}

td{
    font-size:12px;
    vertical-align: top;
    padding:2px 0;
}

/* KOLOM */
.col-nama{
    width:70%;
    word-break: break-word;
}

.col-qty{
    width:30%;
    text-align:right;
}

/* TOTAL */
.total{
    display:flex;
    justify-content:space-between;
}

.bold{
    font-weight:bold;
}

.small{
    font-size:11px;
}
</style>

</head>

<body>

<div class="text-center">
    <b>GLOBAL LANGUAGE</b><br>
    <small>Kursus Bahasa</small>
</div>

<div class="line"></div>

<div class="wrap">
    Invoice : <?= $transaksi['invoice'] ?><br>
    Tanggal : <?= date('d-m-Y H:i', strtotime($transaksi['created_at'])) ?><br>
    Siswa   : <?= $transaksi['nama_siswa'] ?><br>
</div>

<div class="line"></div>

<div class="wrap">
    Mulai   : <?= date('d-m-Y', strtotime($transaksi['tanggal_mulai'])) ?><br>
    Selesai : <?= date('d-m-Y', strtotime($transaksi['tanggal_selesai'])) ?><br>
    Durasi  : <?= $transaksi['durasi'] ?> Bulan
</div>

<div class="line"></div>

<table>
<?php foreach($detail as $d): ?>
<tr>
    <td class="col-nama">
        <?= $d['nama_produk'] ?>
    </td>
    <td class="col-qty">
        x<?= $d['qty'] ?>
    </td>
</tr>
<tr>
    <td colspan="2" class="small">
        Rp <?= number_format($d['subtotal'],0,',','.') ?>
    </td>
</tr>
<?php endforeach; ?>
</table>

<div class="line"></div>

<div class="total">
    <span>Total</span>
    <span>Rp <?= number_format($transaksi['total_harga'],0,',','.') ?></span>
</div>

<div class="total">
    <span>Bayar</span>
    <span>Rp <?= number_format($transaksi['uang_bayar'],0,',','.') ?></span>
</div>

<div class="total bold">
    <span>Kembali</span>
    <span>Rp <?= number_format($transaksi['uang_kembali'],0,',','.') ?></span>
</div>

<div class="line"></div>

<div class="text-center">
    <b>*** LUNAS ***</b><br>
    Terima kasih 🙏
</div>

</body>
</html>