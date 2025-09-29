<h1 class="title">Daftar Anggota</h1>
<a class="button is-primary" href="/members/create">Tambah</a>
<table class="table is-fullwidth">
<thead><tr><th>ID</th><th>Nama</th><th>Email</th></tr></thead>
<tbody>
<?php foreach ($members as $m): ?>
<tr>
<td><?= $m->getId() ?></td>
<td><?= htmlspecialchars($m->jsonSerialize()['name']) ?></td>
<td><?= htmlspecialchars($m->jsonSerialize()['email']) ?></td>
</tr>
<?php endforeach; ?>
</tbody>
</table>