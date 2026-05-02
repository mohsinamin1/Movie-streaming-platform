declare(strict_types=1);
require_once __DIR__ . '/../app/config/config.php'; require_once __DIR__ . '/../app/core/helpers.php'; require_once __DIR__ . '/../app/core/admin_guard.php'; require_once __DIR__ . '/../app/config/database.php';
if($_SERVER['REQUEST_METHOD']==='POST'){ if(($_POST['action']??'')==='create'){db()->prepare('INSERT INTO genres (name, description) VALUES (:name,:description)')->execute(['name'=>$_POST['name'],'description'=>$_POST['description']]); flash('success','Genre added.');} elseif(($_POST['action']??'')==='delete'){db()->prepare('DELETE FROM genres WHERE id=:id')->execute(['id'=>(int)$_POST['id']]); flash('success','Genre deleted.');} redirect('genres-list.php'); }
$items=db()->query('SELECT * FROM genres ORDER BY id DESC')->fetchAll(); require_once __DIR__ . '/../app/views/partials/header.php'; require_once __DIR__ . '/../app/views/partials/navbar.php'; require_once __DIR__ . '/../app/views/partials/flash.php'; ?><main class="container"><h1>Genres</h1><form method="post" class="card form-grid"><input type="hidden" name="action" value="create"><input name="name" placeholder="Genre name" required><textarea name="description" placeholder="Description"></textarea><button type="submit">Add Genre</button></form><div class="card"><table width="100%"><tr><th>Name</th><th>Action</th></tr><?php foreach($items as $item): ?><tr><td><?= e($item['name']) ?></td><td><form method="post" style="display:inline"><input type="hidden" name="action" value="delete"><input type="hidden" name="id" value="<?= (int)$item['id'] ?>"><button type="submit">Delete</button></form></td></tr><?php endforeach; ?></table></div></main><?php require_once __DIR__ . '/../app/views/partials/footer.php'; ?>
<?php
declare(strict_types=1);
require_once __DIR__ . '/../app/config/config.php';
require_once __DIR__ . '/../app/core/helpers.php';
require_once __DIR__ . '/../app/core/admin_guard.php';
require_once __DIR__ . '/../app/config/database.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
	if (($_POST['action'] ?? '') === 'create') {
		db()->prepare('INSERT INTO genres (name, description) VALUES (:name,:description)')->execute([
			'name' => $_POST['name'],
			'description' => $_POST['description'],
		]);
		flash('success', 'Genre added.');
	} elseif (($_POST['action'] ?? '') === 'delete') {
		db()->prepare('DELETE FROM genres WHERE id=:id')->execute(['id' => (int)$_POST['id']]);
		flash('success', 'Genre deleted.');
	}

	redirect('genres-list.php');
}

$items = db()->query('SELECT * FROM genres ORDER BY id DESC')->fetchAll();
require_once __DIR__ . '/../app/views/partials/header.php';
require_once __DIR__ . '/../app/views/partials/navbar.php';
require_once __DIR__ . '/../app/views/partials/flash.php';
?>
<main class="container">
	<h1>Genres</h1>
	<form method="post" class="card form-grid">
		<input type="hidden" name="action" value="create">
		<input name="name" placeholder="Genre name" required>
		<textarea name="description" placeholder="Description"></textarea>
		<button type="submit">Add Genre</button>
	</form>
	<div class="card">
		<table width="100%">
			<tr><th>Name</th><th>Action</th></tr>
			<?php foreach ($items as $item): ?>
				<tr>
					<td><?= e($item['name']) ?></td>
					<td>
						<a href="genres-edit.php?id=<?= (int)$item['id'] ?>">Edit</a>
						<form method="post" style="display:inline">
							<input type="hidden" name="action" value="delete">
							<input type="hidden" name="id" value="<?= (int)$item['id'] ?>">
							<button type="submit">Delete</button>
						</form>
					</td>
				</tr>
			<?php endforeach; ?>
		</table>
	</div>
</main>
<?php require_once __DIR__ . '/../app/views/partials/footer.php'; ?>
