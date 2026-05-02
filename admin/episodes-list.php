<?php
declare(strict_types=1);
require_once __DIR__ . '/../app/config/config.php';
require_once __DIR__ . '/../app/core/helpers.php';
require_once __DIR__ . '/../app/core/admin_guard.php';
require_once __DIR__ . '/../app/config/database.php';

if ($_SERVER['REQUEST_METHOD']==='POST' && ($_POST['action'] ?? '')==='delete') { db()->prepare('DELETE FROM episodes WHERE id=:id')->execute(['id'=>(int)$_POST['id']]); flash('success','Episode deleted.'); redirect('episodes-list.php'); }
$items=db()->query('SELECT e.*, s.title AS series_title FROM episodes e JOIN series s ON s.id=e.series_id ORDER BY e.id DESC')->fetchAll();
require_once __DIR__ . '/../app/views/partials/header.php'; require_once __DIR__ . '/../app/views/partials/navbar.php'; require_once __DIR__ . '/../app/views/partials/flash.php';
?><main class="container"><h1>Episodes</h1><p><a href="episodes-create.php">Add Episode</a></p><div class="card"><table width="100%"><tr><th>Series</th><th>S/E</th><th>Title</th><th>Actions</th></tr><?php foreach($items as $item): ?><tr><td><?= e($item['series_title']) ?></td><td>S<?= e((string)$item['season_number']) ?>E<?= e((string)$item['episode_number']) ?></td><td><?= e($item['title']) ?></td><td><a href="episodes-edit.php?id=<?= (int)$item['id'] ?>">Edit</a><form method="post" style="display:inline"><input type="hidden" name="action" value="delete"><input type="hidden" name="id" value="<?= (int)$item['id'] ?>"><button type="submit">Delete</button></form></td></tr><?php endforeach; ?></table></div></main><?php require_once __DIR__ . '/../app/views/partials/footer.php'; ?>
