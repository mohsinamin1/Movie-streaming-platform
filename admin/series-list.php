<?php
declare(strict_types=1);
require_once __DIR__ . '/../app/config/config.php';
require_once __DIR__ . '/../app/core/helpers.php';
require_once __DIR__ . '/../app/core/admin_guard.php';
require_once __DIR__ . '/../app/config/database.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && ($_POST['action'] ?? '') === 'delete') {
    db()->prepare('DELETE FROM series WHERE id = :id')->execute(['id' => (int)$_POST['id']]);
    flash('success', 'Series deleted.');
    redirect('series-list.php');
}
$items = db()->query('SELECT * FROM series ORDER BY id DESC')->fetchAll();
require_once __DIR__ . '/../app/views/partials/header.php';
require_once __DIR__ . '/../app/views/partials/navbar.php';
require_once __DIR__ . '/../app/views/partials/flash.php';
?>
<main class="container"><h1>Series</h1><p><a href="series-create.php">Add Series</a></p><div class="card"><table width="100%"><tr><th>Title</th><th>Status</th><th>Actions</th></tr><?php foreach ($items as $item): ?><tr><td><?= e($item['title']) ?></td><td><?= e((string)$item['status']) ?></td><td><a href="series-edit.php?id=<?= (int)$item['id'] ?>">Edit</a><form method="post" style="display:inline"><input type="hidden" name="action" value="delete"><input type="hidden" name="id" value="<?= (int)$item['id'] ?>"><button type="submit">Delete</button></form></td></tr><?php endforeach; ?></table></div></main><?php require_once __DIR__ . '/../app/views/partials/footer.php'; ?>
