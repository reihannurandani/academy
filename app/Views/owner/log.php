<?= view('layout/header') ?>
<?= view('layout/sidebar') ?>

<h3>Log Activity</h3>

<table class="table table-bordered">
<tr><th>User</th><th>Activity</th><th>Waktu</th></tr>
<?php foreach($logs as $l): ?>
<tr>
<td><?= $l['nama'] ?></td>
<td><?= $l['activity'] ?></td>
<td><?= $l['created_at'] ?></td>
</tr>
<?php endforeach; ?>
</table>

<?= view('layout/footer') ?>
