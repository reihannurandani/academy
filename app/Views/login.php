<!DOCTYPE html>
<html>
<head>
<title>Login - Global Language Academy</title>

<script src="https://unpkg.com/@lottiefiles/lottie-player@latest/dist/lottie-player.js"></script>

<link rel="stylesheet" href="<?= base_url('assets/css/login.css') ?>">

</head>
<body>

<div class="wrapper">

<div class="hero">

<!-- LEFT ANIMATION -->
<div class="right">

<lottie-player
src="https://assets2.lottiefiles.com/packages/lf20_zrqthn6o.json"
background="transparent"
speed="1"
style="width:340px;height:340px;"
loop
autoplay>
</lottie-player>

</div>

<!-- RIGHT FORM -->
<div class="left">

<h1>Login🌏</h1>
<p class="subtext">
Login untuk mengakses sistem kursus bahasa Jepang, Korea, Spanyol & lainnya.
</p>

<?php if(session()->getFlashdata('error')): ?>
<div class="error">
<?= session()->getFlashdata('error') ?>
</div>
<?php endif; ?>

<form action="<?= base_url('proses-login') ?>" method="post">

<input type="text" name="username" placeholder="Username" required>

<input type="password" name="password" placeholder="Password" required>

<button type="submit">Login</button>

<a href="<?= base_url('/') ?>" class="btn-kembali">
← Kembali ke Beranda
</a>

</form>

</div>

</div>

</div>

</body>
</html>
