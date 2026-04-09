<?= view('layout/header') ?>
<?= view('layout/sidebar') ?>

<link href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css" rel="stylesheet">
<link rel="stylesheet" href="<?= base_url('assets/css/admin.css') ?>">

<div class="main-wrapper">

    <div class="top-header">
        <h2>Dashboard</h2>
    </div>

    <div class="dashboard-box">

        <div class="welcome-text">
            <h3>Haii Admin! 👋</h3>
            <p>Selamat Datang di Dashboard Admin</p>
            <hr>
        </div>

        <div class="stats-grid">

            <!-- USER -->
            <div class="stat-card">
                <div class="icon-box blue">
                    <i class='bx bx-group'></i>
                </div>

                <div>
                    <div class="stat-number">
                        <?= $totalUsers ?? 0 ?>
                    </div>
                    <div class="stat-label">
                        Total User
                    </div>
                </div>
            </div>

            <!-- KATEGORI -->
            <div class="stat-card">
                <div class="icon-box orange">
                    <i class='bx bx-book'></i>
                </div>

                <div>
                    <div class="stat-number">
                        <?= $totalKategori ?? 0 ?>
                    </div>
                    <div class="stat-label">
                        Total Kategori
                    </div>
                </div>
            </div>

            <!-- BAHASA -->
            <div class="stat-card">
                <div class="icon-box green">
                    <i class='bx bx-globe'></i>
                </div>

                <div>
                    <div class="stat-number">
                        <?= $totalBahasa ?? 0 ?>
                    </div>
                    <div class="stat-label">
                        Total Bahasa
                    </div>
                </div>
            </div>

            <!-- SISWA -->
            <div class="stat-card">
                <div class="icon-box pink">
                    <i class='bx bx-child'></i>
                </div>

                <div>
                    <div class="stat-number">
                        <?= $totalSiswa ?? 0 ?>
                    </div>
                    <div class="stat-label">
                        Total Siswa
                    </div>
                </div>
            </div>

        </div>

    </div>

</div>

<?= view('layout/footer') ?>