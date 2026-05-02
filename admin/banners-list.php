declare(strict_types=1);
require_once __DIR__ . '/../app/config/config.php'; require_once __DIR__ . '/../app/core/helpers.php'; require_once __DIR__ . '/../app/core/admin_guard.php'; require_once __DIR__ . '/../app/config/database.php';
if($_SERVER['REQUEST_METHOD']==='POST'){ if(($_POST['action']??'')==='create'){db()->prepare('INSERT INTO banners (title, image_url, link_url, region, display_order, is_active, valid_from, valid_until) VALUES (:title,:image_url,:link_url,:region,:display_order,:is_active,:valid_from,:valid_until)')->execute(['title'=>$_POST['title'],'image_url'=>$_POST['image_url'],'link_url'=>$_POST['link_url'],'region'=>$_POST['region'],'display_order'=>(int)$_POST['display_order'],'is_active'=>isset($_POST['is_active'])?1:0,'valid_from'=>$_POST['valid_from']?:null,'valid_until'=>$_POST['valid_until']?:null]); flash('success','Banner added.');} elseif(($_POST['action']??'')==='delete'){db()->prepare('DELETE FROM banners WHERE id=:id')->execute(['id'=>(int)$_POST['id']]); flash('success','Banner deleted.');} redirect('banners-list.php'); }
$items=db()->query('SELECT * FROM banners ORDER BY display_order ASC, id DESC')->fetchAll(); require_once __DIR__ . '/../app/views/partials/header.php'; require_once __DIR__ . '/../app/views/partials/navbar.php'; require_once __DIR__ . '/../app/views/partials/flash.php'; ?><main class="container"><h1>Banners</h1><form method="post" class="card form-grid"><input type="hidden" name="action" value="create"><input name="title" placeholder="Banner title" required><input name="image_url" placeholder="Image URL" required><input name="link_url" placeholder="Link URL"><input name="region" placeholder="Region" value="global"><input type="number" name="display_order" placeholder="Display Order" value="0"><label><input type="checkbox" name="is_active" checked> Active</label><input type="datetime-local" name="valid_from"><input type="datetime-local" name="valid_until"><button type="submit">Add Banner</button></form><div class="card"><table width="100%"><tr><th>Title</th><th>Region</th><th>Action</th></tr><?php foreach($items as $item): ?><tr><td><?= e($item['title']) ?></td><td><?= e((string)$item['region']) ?></td><td><form method="post" style="display:inline"><input type="hidden" name="action" value="delete"><input type="hidden" name="id" value="<?= (int)$item['id'] ?>"><button type="submit">Delete</button></form></td></tr><?php endforeach; ?></table></div></main><?php require_once __DIR__ . '/../app/views/partials/footer.php'; ?>
<?php
declare(strict_types=1);
require_once __DIR__ . '/../app/config/config.php';
require_once __DIR__ . '/../app/core/helpers.php';
require_once __DIR__ . '/../app/core/admin_guard.php';
require_once __DIR__ . '/../app/config/database.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
	if (($_POST['action'] ?? '') === 'create') {
		db()->prepare('INSERT INTO banners (title, image_url, link_url, region, display_order, is_active, valid_from, valid_until) VALUES (:title,:image_url,:link_url,:region,:display_order,:is_active,:valid_from,:valid_until)')->execute([
			'title' => $_POST['title'],
			'image_url' => $_POST['image_url'],
			'link_url' => $_POST['link_url'],
			'region' => $_POST['region'],
			'display_order' => (int)$_POST['display_order'],
			'is_active' => isset($_POST['is_active']) ? 1 : 0,
			'valid_from' => $_POST['valid_from'] ?: null,
			'valid_until' => $_POST['valid_until'] ?: null,
		]);
		flash('success', 'Banner added.');
	} elseif (($_POST['action'] ?? '') === 'delete') {
		db()->prepare('DELETE FROM banners WHERE id=:id')->execute(['id' => (int)$_POST['id']]);
		flash('success', 'Banner deleted.');
	}

	redirect('banners-list.php');
}

$items = db()->query('SELECT * FROM banners ORDER BY display_order ASC, id DESC')->fetchAll();
require_once __DIR__ . '/../app/views/partials/header.php';
require_once __DIR__ . '/../app/views/partials/navbar.php';
require_once __DIR__ . '/../app/views/partials/flash.php';
?>
<main class="container">
	<h1>Banners</h1>
	<form method="post" class="card form-grid">
		<input type="hidden" name="action" value="create">
		<input name="title" placeholder="Banner title" required>
		<input name="image_url" placeholder="Image URL" required>
		<input name="link_url" placeholder="Link URL">
		<input name="region" placeholder="Region" value="global">
		<input type="number" name="display_order" placeholder="Display Order" value="0">
		<label><input type="checkbox" name="is_active" checked> Active</label>
		<input type="datetime-local" name="valid_from">
		<input type="datetime-local" name="valid_until">
		<button type="submit">Add Banner</button>
	</form>
	<div class="card">
		<table width="100%">
			<tr><th>Title</th><th>Region</th><th>Action</th></tr>
			<?php foreach ($items as $item): ?>
				<tr>
					<td><?= e($item['title']) ?></td>
					<td><?= e((string)$item['region']) ?></td>
					<td>
						<a href="banners-edit.php?id=<?= (int)$item['id'] ?>">Edit</a>
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
