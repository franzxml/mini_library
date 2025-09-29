<h1 class="title">Daftar Buku</h1>
<a class="button is-primary" href="/books/create">Tambah</a>
<table class="table is-fullwidth">
<thead><tr><th>ID</th><th>Judul</th><th>Penulis</th><th>Aksi</th></tr></thead>
<tbody>
<?php foreach ($books as $b): ?>
<tr>
<td><?= $b->getId() ?></td>
<td><?= htmlspecialchars($b->__get('title')) ?></td>
<td><?= htmlspecialchars($b->__get('author')) ?></td>
<td>
<a class="button is-small" href="/books/show?id=<?= $b->getId() ?>">JSON</a>
<form style="display:inline" method="post" action="/books/clone">
<input type="hidden" name="id" value="<?= $b->getId() ?>">
<button class="button is-small is-info" type="submit">Clone</button>
</form>
</td>
</tr>
<?php endforeach; ?>
</tbody>
</table>