<?= view('layout/header') ?>
<?= view('layout/sidebar') ?>
<link rel="stylesheet" href="<?= base_url('assets/css/admin-menu.css') ?>">

<style>
.row-danger{
    background-color: #ffcccc !important;
}
.row-danger td{
    color: #a10000;
    font-weight: bold;
}
.table-custom tr{
    transition: 0.3s;
}
</style>

<div class="main">

    <div class="page-header">
        <h2>Kelola Mapel</h2>
    </div>

    <div class="menu-container">

        <?php if(session()->getFlashdata('error')): ?>
            <div style="background:#ff4d4d;color:white;padding:10px;border-radius:6px;margin-bottom:10px;">
                <?= session()->getFlashdata('error') ?>
            </div>
        <?php endif; ?>

        <?php if(session()->getFlashdata('success')): ?>
            <div style="background:#28a745;color:white;padding:10px;border-radius:6px;margin-bottom:10px;">
                <?= session()->getFlashdata('success') ?>
            </div>
        <?php endif; ?>

        <div class="action-bar">
            <a href="<?= base_url('admin/create-product') ?>" class="btn-add">
                Tambah +
            </a>

            <div class="search-box">
                <input type="text" id="searchProduct" placeholder="Cari...">
            </div>
        </div>

        <table class="table-custom" id="tableProduct">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Nama Bahasa</th>
                    <th>Kategori</th>
                    <th>Harga</th>
                    <th>Jadwal</th>
                    <th>Kuota</th>
                    <th>Mentor</th>
                    <th>Status</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
            <?php $no=1; foreach($products as $p): ?>
                <tr class="<?= ($p['kuota'] <= 0) ? 'row-danger' : '' ?>">
                    <td><?= $no++ ?></td>
                    <td><?= esc($p['nama_produk']) ?></td>
                    <td><?= esc($p['nama_kategori']) ?></td>
                    <td>Rp <?= number_format($p['harga_produk'],0,',','.') ?></td>

                    <td>
                        <b><?= esc($p['hari_mulai']) ?> - <?= esc($p['hari_selesai']) ?></b><br>
                        <?= esc($p['jam_mulai']) ?> - <?= esc($p['jam_selesai']) ?>
                    </td>

                    <td><?= esc($p['kuota']) ?></td>
                    <td><?= esc($p['mentor']) ?></td>

                    <td>
                        <?php if($p['kuota'] <= 0): ?>
                            <span class="badge-danger">tidak tersedia</span>
                        <?php else: ?>
                            <span class="badge-success">tersedia</span>
                        <?php endif; ?>
                    </td>

                    <td>
                        <a href="<?= base_url('admin/edit-product/'.$p['id']) ?>" class="btn-edit">edit</a>

                        <button class="btn-delete"
                                onclick="openModal(<?= $p['id']; ?>)">
                            🗑
                        </button>
                    </td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>

    </div>

</div>

<script>
document.getElementById("searchProduct").addEventListener("keyup", function() {
    let input = this.value.toLowerCase();
    let rows = document.querySelectorAll("#tableProduct tbody tr");

    rows.forEach(function(row){
        let text = row.innerText.toLowerCase();
        row.style.display = text.includes(input) ? "" : "none";
    });
});
</script>

<?= view('layout/footer') ?>