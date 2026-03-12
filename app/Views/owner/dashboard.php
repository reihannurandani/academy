<?= view('layout/header') ?>
<?= view('layout/sidebar') ?>

<link rel="stylesheet" href="<?= base_url('assets/css/owner.css') ?>">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

<div class="main">

    <!-- HEADER BOX -->
    <div class="top-box">
        <div>
            <h2>Dashboard Owner</h2>
            <p>Haii Owner! <br> Selamat Datang Di Dashboard Owner</p>
        </div>
    </div>

    <!-- CARD AREA -->
    <div class="card-container">

        <!-- Pendapatan Hari Ini -->
        <div class="card">
            <div class="icon blue">
                <i class="fa-solid fa-sack-dollar"></i>
            </div>
            <div>
                <h3>Rp <?= number_format($pendapatanHariIni) ?></h3>
                <p>Pendapatan Hari Ini</p>
            </div>
        </div>

        <!-- Total Pendapatan -->
        <div class="card">
            <div class="icon gold">
                <i class="fa-solid fa-chart-line"></i>
            </div>
            <div>
                <h3>Rp <?= number_format($totalPendapatan) ?></h3>
                <p>Total Pendapatan</p>
            </div>
        </div>

        <!-- Total User -->
        <div class="card">
            <div class="icon green">
                <i class="fa-solid fa-users"></i>
            </div>
            <div>
                <h3><?= $totalUser ?></h3>
                <p>Total User</p>
            </div>
        </div>

        <!-- Total Siswa -->
        <div class="card">
            <div class="icon pink">
                <i class="fa-solid fa-user-graduate"></i>
            </div>
            <div>
                <h3><?= $totalSiswa ?></h3>
                <p>Total Siswa</p>
            </div>
        </div>

    </div>

    <!-- TABLE -->
    <h3 class="section-title">Daftar Siswa</h3>

    <div class="table-box">
        <table>
            <thead>
                <tr>
                    <th>No</th>
                    <th>Nama</th>
                    <th>Kursus</th>
                    <th>Kategori</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
            <?php $no=1; foreach($students as $s): 

            $today = date('Y-m-d');

            if(isset($s['tanggal_selesai'])){
                if($s['tanggal_selesai'] >= $today){
                    $status = 'aktif';
                }else{
                    $status = 'selesai';
                }
            }else{
                $status = 'aktif';
            }

            ?>

            <tr>
            <td><?= $no++ ?></td>
            <td><?= $s['nama_siswa'] ?></td>
            <td><?= $s['kursus'] ?? '-' ?></td>
            <td><?= $s['kategori'] ?? '-' ?></td>

            <td>
            <?php if($status == 'aktif'): ?>

            <span style="color:green;font-weight:bold">
            Aktif
            </span>

            <?php else: ?>

            <span style="color:red;font-weight:bold">
            Selesai
            </span>

            <?php endif; ?>
            </td>

            </tr>

            <?php endforeach ?>
            </tbody>
        </table>
    </div>

</div>

<?= view('layout/footer') ?>