<?= view('layout/header') ?>
<?= view('layout/sidebar') ?>

<div class="container mt-4">

    <div class="card p-4 shadow" style="max-width:600px;margin:auto;">
        <h4 class="text-center mb-3">GLOBAL LANGUAGE ACADEMY 🌍</h4>
        <hr>

        <p><strong>Invoice:</strong> 
            <?= $transaksi['invoice'] ?? 'INV-'.str_pad($transaksi['id'], 5, '0', STR_PAD_LEFT) ?>
        </p>

        <p><strong>Nama Siswa:</strong> <?= $transaksi['nama_siswa'] ?></p>

        <p><strong>Tanggal:</strong> 
            <?= date('d-m-Y', strtotime($transaksi['created_at'])) ?>
        </p>

        <hr>

        <?php 
            $namaProgram = [];
            $hargaSatuan = [];
            $totalQty = 0;
            $subtotal = 0;

            foreach ($detail as $d) {
                $namaProgram[] = $d['nama_produk'];
                $hargaSatuan[] = number_format($d['harga'], 0, ',', '.');
                $totalQty += $d['qty'];
                $subtotal += $d['subtotal'];
            }
        ?>

        <p><strong>Program:</strong> 
            <?= implode(', ', $namaProgram) ?>
        </p>

        <p><strong>Harga Satuan:</strong> 
            Rp <?= implode(', ', $hargaSatuan) ?>
        </p>

        <p><strong>Qty:</strong> <?= $totalQty ?></p>

        <p><strong>Subtotal:</strong> 
            Rp <?= number_format($subtotal, 0, ',', '.') ?>
        </p>

        <hr>

        <p><strong>Total:</strong> 
            Rp <?= number_format($transaksi['total_harga'], 0, ',', '.') ?>
        </p>

        <p><strong>Bayar:</strong> 
            Rp <?= number_format($transaksi['uang_bayar'], 0, ',', '.') ?>
        </p>

        <p><strong>Kembali:</strong> 
            Rp <?= number_format($transaksi['uang_kembali'], 0, ',', '.') ?>
        </p>

        <p><strong>Status:</strong> 
            <span class="badge bg-success">LUNAS</span>
        </p>

        <div class="text-center mt-3">
            <button onclick="window.print()" class="btn btn-primary">
                Print Struk
            </button>
        </div>
    </div>

</div>

<?= view('layout/footer') ?>
