<?= view('layout/header') ?>
<?= view('layout/sidebar') ?>

<link rel="stylesheet" href="<?= base_url('assets/css/kasir.css') ?>">

<div class="main">

    <div class="dashboard-header">
        <h2>Detail Transaksi</h2>
    </div>

    <div class="transaksi-card">

        <!-- ===================== -->
        <!-- INFO UTAMA -->
        <!-- ===================== -->
        <div class="detail-grid">

            <div class="detail-item">
                <span>Invoice</span>
                <strong><?= $transaksi['invoice'] ?></strong>
            </div>

            <div class="detail-item">
                <span>Nama Siswa</span>
                <strong><?= $transaksi['nama_siswa'] ?></strong>
            </div>

            <div class="detail-item">
                <span>Tanggal</span>
                <strong><?= date('d-m-Y H:i', strtotime($transaksi['created_at'])) ?></strong>
            </div>

        </div>

        <!-- ===================== -->
        <!-- KURSUS -->
        <!-- ===================== -->
        <div class="section-box">

            <h4>Informasi Kursus</h4>

            <div class="detail-grid">

                <div class="detail-item">
                    <span>Mulai</span>
                    <strong><?= $transaksi['tanggal_mulai'] ?></strong>
                </div>

                <div class="detail-item">
                    <span>Selesai</span>
                    <strong><?= $transaksi['tanggal_selesai'] ?></strong>
                </div>

                <div class="detail-item">
                    <span>Durasi</span>
                    <strong><?= $transaksi['durasi'] ?> bulan</strong>
                </div>

            </div>

        </div>

        <!-- ===================== -->
        <!-- TABLE -->
        <!-- ===================== -->
        <div class="section-box">

            <h4>Detail Kursus</h4>

            <div class="custom-table">
                <table>
                    <thead>
                        <tr>
                            <th>Program</th>
                            <th>Harga</th>
                            <th>Durasi</th>
                            <th>Subtotal</th>
                        </tr>
                    </thead>

                    <tbody>
                        <?php foreach($detail as $d): ?>
                        <tr>
                            <td><?= $d['nama_produk'] ?></td>
                            <td>Rp <?= number_format($d['harga'],0,',','.') ?></td>
                            <td><?= $d['qty'] ?> bulan</td>
                            <td>Rp <?= number_format($d['subtotal'],0,',','.') ?></td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>

        </div>

        <!-- ===================== -->
        <!-- TOTAL BOX -->
        <!-- ===================== -->
        <div class="total-box">

            <div>
                <span>Total</span>
                <h3>Rp <?= number_format($transaksi['total_harga'],0,',','.') ?></h3>
            </div>

            <div>
                <span>Bayar</span>
                <h3>Rp <?= number_format($transaksi['uang_bayar'],0,',','.') ?></h3>
            </div>

            <div>
                <span>Kembali</span>
                <h3 class="kembali">
                    Rp <?= number_format($transaksi['uang_kembali'],0,',','.') ?>
                </h3>
            </div>

        </div>

        <!-- ===================== -->
        <!-- BUTTON -->
        <!-- ===================== -->
        <div class="btn-area">

            <a href="<?= base_url('kasir/cetakStruk/'.$transaksi['id']) ?>" 
            target="_blank" 
            class="btn-modern btn-struk">
                🧾 Cetak Struk
            </a>

            <a href="<?= base_url('kasir/riwayat') ?>" 
            class="btn-modern btn-secondary">
                ← Kembali
            </a>

        </div>
        
    </div>

</div>

<?= view('layout/footer') ?>