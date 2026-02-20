<h3>Edit User</h3>

<form method="post" action="<?= base_url('admin/update-user/'.$user['id']) ?>">

<input name="nama" value="<?= $user['nama'] ?>">
<input name="username" value="<?= $user['username'] ?>">
<input name="password" type="password" placeholder="Kosongkan jika tidak diubah">

<select name="role">
    <option value="admin" <?= $user['role']=='admin'?'selected':'' ?>>Admin</option>
    <option value="kasir" <?= $user['role']=='kasir'?'selected':'' ?>>Kasir</option>
    <option value="owner" <?= $user['role']=='owner'?'selected':'' ?>>Owner</option>
</select>

<select name="status">
    <option value="aktif" <?= $user['status']=='aktif'?'selected':'' ?>>Aktif</option>
    <option value="nonaktif" <?= $user['status']=='nonaktif'?'selected':'' ?>>Nonaktif</option>
</select>

<button>Update</button>

</form>
