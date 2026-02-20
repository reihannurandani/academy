<?= view('layout/header') ?>
<?= view('layout/sidebar') ?>

<!DOCTYPE html>
<html>
<head>
    <title>Dashboard Admin</title>
    <style>
        body {
            margin:0;
            font-family: Arial, sans-serif;
            background:#3d7dd8;
        }

        .header {
            background:#d9e2ef;
            padding:25px;
            border-radius:0 0 20px 20px;
        }

        .container {
            width:80%;
            margin:60px auto;
            background:#d9e2ef;
            padding:60px;
            border-radius:20px;
            display:flex;
            justify-content:space-around;
        }

        .card {
            width:220px;
            height:220px;
            background:#4a86d9;
            border-radius:20px;
            text-align:center;
            color:white;
            padding-top:60px;
            text-decoration:none;
            transition:0.3s;
        }

        .card:hover {
            background:#2f6fca;
            transform:scale(1.05);
        }

        .logout {
            margin:40px;
        }

        .logout a {
            background:#1f3c6d;
            padding:10px 20px;
            border-radius:10px;
            color:white;
            text-decoration:none;
        }
    </style>
</head>
<body>

<div class="header">
    <h2>Dashboard Admin</h2>
    <p>Selamat datang, <?= session()->get('nama') ?></p>
</div>

<div class="container">

    <a href="<?= base_url('admin/users') ?>" class="card">
        <h3>Kelola Users</h3>
    </a>

    <a href="<?= base_url('admin/categories') ?>" class="card">
        <h3>Kelola Kategori</h3>
    </a>

    <a href="<?= base_url('admin/products') ?>" class="card">
        <h3>Kelola Bahasa</h3>
    </a>

</div>

<div class="logout">
    <a href="<?= base_url('logout') ?>">Logout</a>
</div>

</body>
</html>
