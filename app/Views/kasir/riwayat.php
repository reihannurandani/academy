<?= view('layout/header') ?>
<?= view('layout/sidebar') ?>

<link rel="stylesheet" href="<?= base_url('assets/css/kasir.css') ?>">

<div class="main">

    <div class="dashboard-header">
        <h2>Riwayat Transaksi</h2>
    </div>

    <div class="dashboard-card">

        <?php if(session()->getFlashdata('error')): ?>
            <div class="custom-alert">
                <?= session()->getFlashdata('error') ?>
            </div>
        <?php endif; ?>

        <!-- ================= SEARCH ================= -->
        <div class="action-bar">
            <div class="search-box">
                <input type="text" id="searchNama" placeholder="Cari nama siswa...">
            </div>
        </div>

        <!-- ================= TABLE ================= -->
        <div class="custom-table">
            <table id="tableTransaksi">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Invoice</th>
                        <th>Nama Siswa</th>
                        <th>Total</th>
                        <th>Tanggal</th>
                        <th>Aksi</th>
                    </tr>
                </thead>

                <tbody>
                    <?php $no=1; foreach($transaksi as $t): ?>
                    <tr>
                        <td><?= $no++ ?></td>
                        <td><?= $t['invoice'] ?></td>
                        <td class="nama-siswa"><?= $t['nama_siswa'] ?></td>
                        <td>Rp <?= number_format($t['total_harga'],0,',','.') ?></td>
                        <td><?= date('d-m-Y H:i', strtotime($t['created_at'])) ?></td>
                        <td>
                            <a href="<?= base_url('kasir/detail/'.$t['id']) ?>" class="btn-modern btn-detail-modern">
                                🔍 Detail
                            </a>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>

            </table>
        </div>

    </div>

</div>

<script>
// ================= SEARCH NAMA SAJA =================
document.getElementById("searchNama").addEventListener("keyup", function(){

    let input = this.value.toLowerCase();
    let rows = document.querySelectorAll("#tableTransaksi tbody tr");

    rows.forEach(function(row){

        let nama = row.querySelector(".nama-siswa").innerText.toLowerCase();

        if(nama.includes(input)){
            row.style.display = "";
        }else{
            row.style.display = "none";
        }

    });

});
</script>

<?= view('layout/footer') ?>