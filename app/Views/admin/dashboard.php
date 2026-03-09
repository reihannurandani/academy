<?= view('layout/header') ?>
<?= view('layout/sidebar') ?>

<!-- BOXICONS -->
<link href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css" rel="stylesheet">

<link rel="stylesheet" href="<?= base_url('assets/css/admin.css') ?>">

<div class="main-wrapper">

    <!-- HEADER -->
    <div class="top-header">
        <h2>Dashboard Admin</h2>
    </div>

    <!-- BOX BIRU BESAR -->
    <div class="dashboard-box">

        <!-- WELCOME -->
        <div class="welcome-text">
            <h3>Hai, Admin 👋</h3>
            <p>Selamat datang di Dashboard Admin Han's Academy</p>
            <hr>
        </div>

        <!-- GRID STATISTIK -->
        <div class="stats-grid">

            <!-- TOTAL USER -->
            <div class="stat-card">
                <div class="stat-icon">
                    <i class='bx bx-user'></i>
                </div>
                <div class="stat-number">
                    <?= $totalUsers ?? 0 ?>
                </div>
                <div class="stat-label">
                    Total User
                </div>
            </div>

            <!-- TOTAL KATEGORI -->
            <div class="stat-card">
                <div class="stat-icon">
                    <i class='bx bx-category'></i>
                </div>
                <div class="stat-number">
                    <?= $totalKategori ?? 0 ?>
                </div>
                <div class="stat-label">
                    Total Kategori
                </div>
            </div>

            <!-- TOTAL BAHASA / PRODUK -->
            <div class="stat-card">
                <div class="stat-icon">
                    <i class='bx bx-world'></i>
                </div>
                <div class="stat-number">
                    <?= $totalBahasa ?? 0 ?>
                </div>
                <div class="stat-label">
                    Total Bahasa
                </div>
            </div>

            <!-- TOTAL SISWA -->
            <div class="stat-card">
                <div class="stat-icon">
                    <i class='bx bx-group'></i>
                </div>
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

<?= view('layout/footer') ?>