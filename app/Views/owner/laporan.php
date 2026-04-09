<?= view('layout/header') ?>
<?= view('layout/sidebar') ?>

<link rel="stylesheet" href="<?= base_url('assets/css/owner.css') ?>">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

<style>
/* ===== FILTER DROPDOWN ===== */
.filter-wrapper{
    display:flex;
    justify-content:flex-end;
    position:relative;
    margin-bottom:20px;
}

.filter-btn{
    background:#2563eb;
    color:#fff;
    border:none;
    padding:10px 15px;
    border-radius:8px;
    cursor:pointer;
    font-weight:500;
}

.filter-dropdown{
    position:absolute;
    top:45px;
    right:0;
    width:260px;
    background:#fff;
    border-radius:12px;
    box-shadow:0 6px 20px rgba(0,0,0,0.15);
    padding:15px;
    display:none;
    z-index:100;
}

.filter-dropdown h4{
    font-size:14px;
    margin-bottom:10px;
    color:#555;
}

.filter-list{
    max-height:150px;
    overflow-y:auto;
    margin-bottom:10px;
}

.filter-item{
    display:flex;
    align-items:center;
    margin-bottom:6px;
    font-size:14px;
}

.filter-actions{
    display:flex;
    gap:8px;
}

.filter-actions button,
.filter-actions a{
    flex:1;
    text-align:center;
    padding:6px;
    border-radius:6px;
    font-size:13px;
    text-decoration:none;
}

.btn-apply{
    background:#16a34a;
    color:white;
    border:none;
}

.btn-reset{
    background:#6b7280;
    color:white;
}
</style>

<div class="main">

    <div class="top-box">
        <h2>Keuangan</h2>

        <a href="<?= base_url('owner/cetak-pdf') ?>" class="btn-pdf">
            Cetak PDF
        </a>
    </div>

    <!-- ================= CARD ================= -->
    <div class="card-grid">
        <div class="finance-card">
            <div class="icon blue"><i class="fa-solid fa-sack-dollar"></i></div>
            <div>
                <h3>Rp.<?= number_format($pendapatanHariIni ?? 0,0,',','.') ?></h3>
                <p>Pendapatan Hari Ini</p>
            </div>
        </div>

        <div class="finance-card">
            <div class="icon gold"><i class="fa-solid fa-calendar-days"></i></div>
            <div>
                <h3>Rp.<?= number_format($pendapatanBulanIni ?? 0,0,',','.') ?></h3>
                <p>Pendapatan Bulan Ini</p>
            </div>
        </div>

        <div class="finance-card">
            <div class="icon green"><i class="fa-solid fa-receipt"></i></div>
            <div>
                <h3><?= $totalTransaksi ?></h3>
                <p>Total Transaksi</p>
            </div>
        </div>

        <div class="finance-card">
            <div class="icon pink"><i class="fa-solid fa-chart-line"></i></div>
            <div>
                <h3>Rp.<?= number_format($totalPendapatan ?? 0,0,',','.') ?></h3>
                <p>Total Pendapatan</p>
            </div>
        </div>
    </div>

        <!-- ================= FILTER ================= -->
    <div class="filter-wrapper">

        <button class="filter-btn" onclick="toggleFilter()">
            <i class="fa fa-filter"></i> Filter
        </button>

        <form method="get" class="filter-dropdown" id="filterBox">

            <h4>Pilih Kursus</h4>

            <div class="filter-list">
                <?php foreach($mapelList as $m): ?>
                    <label class="filter-item">
                        <input type="checkbox" name="mapel[]" value="<?= $m['id'] ?>"
                            <?= (isset($_GET['mapel']) && in_array($m['id'], $_GET['mapel'])) ? 'checked' : '' ?>>
                        &nbsp; <?= $m['nama_produk'] ?>
                    </label>
                <?php endforeach; ?>
            </div>

            <div class="filter-actions">
                <button type="submit" class="btn-apply">Terapkan</button>
                <a href="<?= base_url('owner/laporan') ?>" class="btn-reset">Reset</a>
            </div>

        </form>

    </div>

    <!-- ================= TABLE ================= -->
    <h3 class="table-title">Data Transaksi</h3>

    <div class="table-wrapper">
        <table>
            <thead>
                <tr>
                    <th>Invoice</th>
                    <th>Nama Siswa</th>
                    <th>Kursus</th>
                    <th>Total</th>
                    <th>Tanggal</th>
                    <th>Aksi</th>
                </tr>
            </thead>

            <tbody>
                <?php foreach($transactions as $t): ?>
                <tr>
                    <td><?= $t['invoice'] ?></td>
                    <td><?= $t['nama_siswa'] ?></td>
                    <td><?= $t['kursus'] ?></td>
                    <td>Rp.<?= number_format($t['total_harga'],0,',','.') ?></td>
                    <td><?= date('Y-m-d H:i', strtotime($t['created_at'])) ?></td>
                    <td>
                        <a href="<?= base_url('owner/detail/'.$t['id']) ?>" 
                           class="btn-modern btn-detail-modern">
                           🔍 Detail
                        </a>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>

</div>

<script>
function toggleFilter(){
    const box = document.getElementById('filterBox');
    box.style.display = box.style.display === 'block' ? 'none' : 'block';
}

// auto close kalau klik luar
document.addEventListener('click', function(e){
    const box = document.getElementById('filterBox');
    const btn = document.querySelector('.filter-btn');

    if(!box.contains(e.target) && !btn.contains(e.target)){
        box.style.display = 'none';
    }
});
</script>

<?= view('layout/footer') ?>