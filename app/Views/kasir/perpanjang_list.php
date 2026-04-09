<?= view('layout/header') ?>
<?= view('layout/sidebar') ?>

<link rel="stylesheet" href="<?= base_url('assets/css/kasir.css') ?>">

<div class="main">

    <h2 class="page-title">Perpanjangan Siswa</h2>

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
                        <?= (!empty($selectedMapel) && in_array($m['id'], $selectedMapel)) ? 'checked' : '' ?>>
                    <span><?= $m['nama_produk'] ?></span>
                </label>
            <?php endforeach; ?>
        </div>

        <div class="filter-actions">
            <button type="submit" class="btn-apply">Terapkan</button>
            <a href="<?= base_url('kasir/perpanjang') ?>" class="btn-reset">Reset</a>
        </div>

    </form>

</div>

<!-- Toggle sederhana -->
<script>
function toggleFilter(){
    var box = document.getElementById("filterBox");
    box.style.display = (box.style.display === "block") ? "none" : "block";
}
</script>

    <!-- 🔥 TABLE CARD -->
    <div class="card-table">
        <table class="table-modern">
            <thead>
                <tr>
                    <th>Nama Siswa</th>
                    <th>Kursus</th>
                    <th>Kategori</th>
                    <th>Tanggal</th>
                    <th>Status</th>
                    <th>Aksi</th>
                </tr>
            </thead>

            <tbody>
                <?php if(empty($transaksi)): ?>
                    <tr>
                        <td colspan="6" style="text-align:center; padding:20px;">
                            Data tidak ditemukan
                        </td>
                    </tr>
                <?php endif; ?>

                <?php foreach($transaksi as $t): 
                    $today  = date('Y-m-d');
                    $status = ($t['tanggal_selesai'] >= $today) ? 'Aktif' : 'Expired';
                ?>
                <tr>
                    <td><?= esc($t['nama_siswa']) ?></td>

                    <td><?= $t['kursus'] ?? '-' ?></td>
                    <td><?= $t['kategori'] ?? '-' ?></td>

                    <td>
                        <div><?= $t['tanggal_mulai'] ?></div>
                        <small style="color:#6b7280;">s/d <?= $t['tanggal_selesai'] ?></small>
                    </td>

                    <td>
                        <?php if($status == 'Aktif'): ?>
                            <span style="background:#dcfce7;color:#166534;padding:5px 10px;border-radius:6px;font-size:12px;">
                                Aktif
                            </span>
                        <?php else: ?>
                            <span style="background:#fee2e2;color:#991b1b;padding:5px 10px;border-radius:6px;font-size:12px;">
                                Expired
                            </span>
                        <?php endif; ?>
                    </td>

                    <td>
                        <a href="<?= base_url('kasir/perpanjang/'.$t['id']) ?>" 
                           class="btn-modern btn-warning">
                           Perpanjang
                        </a>
                    </td>
                </tr>
                <?php endforeach; ?>

            </tbody>

        </table>
    </div>

</div>

<?= view('layout/footer') ?>