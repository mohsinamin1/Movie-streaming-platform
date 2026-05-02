declare(strict_types=1);
require_once __DIR__ . '/../app/config/config.php'; require_once __DIR__ . '/../app/core/helpers.php'; require_once __DIR__ . '/../app/core/admin_guard.php'; require_once __DIR__ . '/../app/config/database.php';
if($_SERVER['REQUEST_METHOD']==='POST'){ if(($_POST['action']??'')==='create'){db()->prepare('INSERT INTO cast_members (full_name, birth_date, nationality, bio, photo_url) VALUES (:full_name,:birth_date,:nationality,:bio,:photo_url)')->execute(['full_name'=>$_POST['full_name'],'birth_date'=>$_POST['birth_date']?:null,'nationality'=>$_POST['nationality'],'bio'=>$_POST['bio'],'photo_url'=>$_POST['photo_url']]); flash('success','Cast member added.');} elseif(($_POST['action']??'')==='delete'){db()->prepare('DELETE FROM cast_members WHERE id=:id')->execute(['id'=>(int)$_POST['id']]); flash('success','Cast member deleted.');} redirect('cast-list.php'); }
$items=db()->query('SELECT * FROM cast_members ORDER BY id DESC')->fetchAll(); require_once __DIR__ . '/../app/views/partials/header.php'; require_once __DIR__ . '/../app/views/partials/navbar.php'; require_once __DIR__ . '/../app/views/partials/flash.php'; ?><main class="container"><h1>Cast Members</h1><form method="post" class="card form-grid"><input type="hidden" name="action" value="create"><input name="full_name" placeholder="Full name" required><input type="date" name="birth_date"><input name="nationality" placeholder="Nationality"><textarea name="bio" placeholder="Bio"></textarea><input name="photo_url" placeholder="Photo URL"><button type="submit">Add Cast</button></form><div class="card"><table width="100%"><tr><th>Name</th><th>Action</th></tr><?php foreach($items as $item): ?><tr><td><?= e($item['full_name']) ?></td><td><form method="post" style="display:inline"><input type="hidden" name="action" value="delete"><input type="hidden" name="id" value="<?= (int)$item['id'] ?>"><button type="submit">Delete</button></form></td></tr><?php endforeach; ?></table></div></main><?php require_once __DIR__ . '/../app/views/partials/footer.php'; ?>
<?php
declare(strict_types=1);
require_once __DIR__ . '/../app/config/config.php';
require_once __DIR__ . '/../app/core/helpers.php';
require_once __DIR__ . '/../app/core/admin_guard.php';
require_once __DIR__ . '/../app/config/database.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
	if (($_POST['action'] ?? '') === 'create') {
		db()->prepare('INSERT INTO cast_members (full_name, birth_date, nationality, bio, photo_url) VALUES (:full_name,:birth_date,:nationality,:bio,:photo_url)')->execute([
			'full_name' => $_POST['full_name'],
			'birth_date' => $_POST['birth_date'] ?: null,
			'nationality' => $_POST['nationality'],
			'bio' => $_POST['bio'],
			'photo_url' => $_POST['photo_url'],
		]);
		flash('success', 'Cast member added.');
	} elseif (($_POST['action'] ?? '') === 'delete') {
		db()->prepare('DELETE FROM cast_members WHERE id=:id')->execute(['id' => (int)$_POST['id']]);
		flash('success', 'Cast member deleted.');
	}

	redirect('cast-list.php');
}

$items = db()->query('SELECT * FROM cast_members ORDER BY id DESC')->fetchAll();
require_once __DIR__ . '/../app/views/partials/header.php';
require_once __DIR__ . '/../app/views/partials/navbar.php';
require_once __DIR__ . '/../app/views/partials/flash.php';
?>
<main class="container">
	<h1>Cast Members</h1>
	<form method="post" class="card form-grid">
		<input type="hidden" name="action" value="create">
		<input name="full_name" placeholder="Full name" required>
		<input type="date" name="birth_date">
		<input name="nationality" placeholder="Nationality">
		<textarea name="bio" placeholder="Bio"></textarea>
		<input name="photo_url" placeholder="Photo URL">
		<button type="submit">Add Cast</button>
	</form>
	<div class="card">
		<table width="100%">
			<tr><th>Name</th><th>Action</th></tr>
			<?php foreach ($items as $item): ?>
				<tr>
					<td><?= e($item['full_name']) ?></td>
					<td>
						<a href="cast-edit.php?id=<?= (int)$item['id'] ?>">Edit</a>
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
