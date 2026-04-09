<!DOCTYPE html>
<html>
<head>
    <title>Laporan Keuangan</title>

    <style>
        body {
            font-family: sans-serif;
            font-size: 11px;
            color: #333;
        }

        .header {
            text-align: center;
            padding: 10px;
            border-bottom: 2px solid #2563eb;
            margin-bottom: 15px;
        }

        .header h2 {
            margin: 0;
            color: #2563eb;
        }

        .header small {
            color: #777;
        }

        /* SUMMARY */
        .summary {
            width: 100%;
            margin-bottom: 15px;
        }

        .summary td {
            padding: 8px;
        }

        .card {
            border: 1px solid #ddd;
            border-radius: 8px;
            padding: 10px;
            background: #f9fbff;
        }

        .label {
            color: #777;
            font-size: 11px;
        }

        .value {
            font-size: 14px;
            font-weight: bold;
            color: #1f2937;
        }

        .highlight {
            background: #e0f2fe;
            border-left: 4px solid #2563eb;
        }

        /* TABLE */
        table {
            width: 100%;
            border-collapse: collapse;
        }

        thead {
            background: #2563eb;
            color: white;
        }

        th {
            padding: 7px;
            font-size: 11px;
        }

        td {
            padding: 6px;
            border-bottom: 1px solid #ddd;
            text-align: center;
        }

        tbody tr:nth-child(even) {
            background: #f1f5f9;
        }

        .text-left {
            text-align: left;
        }

        .text-right {
            text-align: right;
        }
    </style>
</head>

<body>

<?php
$totalTransaksi     = $totalTransaksi ?? 0;
$pendapatanHariIni  = $pendapatanHariIni ?? 0;
$pendapatanBulanIni = $pendapatanBulanIni ?? 0;
$totalPendapatan    = $totalPendapatan ?? 0;
$transactions       = $transactions ?? [];
?>

<!-- HEADER -->
<div class="header">
    <h2>📊 Laporan Keuangan</h2>
    <small><?= date('d M Y') ?></small>
</div>

<table class="summary">
    <tr>
        <td width="50%">
            <div class="card">
                <div class="label">Total Transaksi</div>
                <div class="value"><?= $totalTransaksi ?></div>
            </div>
        </td>
        <td width="50%">
            <div class="card">
                <div class="label">Pendapatan Hari Ini</div>
                <div class="value">
                    Rp <?= number_format($pendapatanHariIni,0,',','.') ?>
                </div>
            </div>
        </td>
    </tr>

    <tr>
        <td>
            <div class="card">
                <div class="label">Pendapatan Bulan Ini</div>
                <div class="value">
                    Rp <?= number_format($pendapatanBulanIni,0,',','.') ?>
                </div>
            </div>
        </td>
        <td>
            <div class="card highlight">
                <div class="label">Total Pendapatan</div>
                <div class="value">
                    Rp <?= number_format($totalPendapatan,0,',','.') ?>
                </div>
            </div>
        </td>
    </tr>
</table>

<table>
    <thead>
        <tr>
            <th>No</th>
            <th>Invoice</th>
            <th>Nama Siswa</th>
            <th>Kursus</th>
            <th>Tgl Transaksi</th>
            <th>Tgl Mulai</th>
            <th>Tgl Selesai</th>
            <th>Total</th>
        </tr>
    </thead>

    <tbody>
        <?php if(!empty($transactions)): ?>
            <?php $no = 1; foreach($transactions as $t): ?>
            <tr>
                <td><?= $no++ ?></td>
                <td><?= $t['invoice'] ?></td>

                <td class="text-left">
                    <?= $t['nama_siswa'] ?? '-' ?>
                </td>

                <td class="text-left">
                    <?= $t['kursus'] ?? '-' ?>
                </td>

                <!-- TANGGAL TRANSAKSI -->
                <td>
                    <?= !empty($t['created_at']) 
                        ? date('d-m-Y H:i', strtotime($t['created_at'])) 
                        : '-' ?>
                </td>

                <!-- TANGGAL MULAI -->
                <td>
                    <?= !empty($t['tanggal_mulai']) 
                        ? date('d-m-Y', strtotime($t['tanggal_mulai'])) 
                        : '-' ?>
                </td>

                <!-- TANGGAL SELESAI -->
                <td>
                    <?= !empty($t['tanggal_selesai']) 
                        ? date('d-m-Y', strtotime($t['tanggal_selesai'])) 
                        : '-' ?>
                </td>

                <td class="text-right">
                    Rp <?= number_format($t['total_harga'],0,',','.') ?>
                </td>
            </tr>
            <?php endforeach; ?>
        <?php else: ?>
            <tr>
                <td colspan="8">Tidak ada data transaksi</td>
            </tr>
        <?php endif; ?>
    </tbody>
</table>

</body>
</html>