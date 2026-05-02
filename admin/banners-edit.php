<?php
declare(strict_types=1);
require_once __DIR__ . '/../app/config/config.php';
require_once __DIR__ . '/../app/core/helpers.php';
require_once __DIR__ . '/../app/core/admin_guard.php';
require_once __DIR__ . '/../app/config/database.php';

$id = (int)($_GET['id'] ?? 0);
$stmt = db()->prepare('SELECT * FROM banners WHERE id = :id LIMIT 1');
$stmt->execute(['id' => $id]);
$item = $stmt->fetch();
if (!$item) {
    redirect('banners-list.php');
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && ($_POST['action'] ?? '') === 'update') {
    db()->prepare('UPDATE banners SET title=:title, image_url=:image_url, link_url=:link_url, region=:region, display_order=:display_order, is_active=:is_active, valid_from=:valid_from, valid_until=:valid_until WHERE id=:id')->execute([
        'id' => $id,
        'title' => $_POST['title'],
        'image_url' => $_POST['image_url'],
        'link_url' => $_POST['link_url'],
        'region' => $_POST['region'],
        'display_order' => (int)$_POST['display_order'],
        'is_active' => isset($_POST['is_active']) ? 1 : 0,
        'valid_from' => $_POST['valid_from'] ?: null,
        'valid_until' => $_POST['valid_until'] ?: null,
    ]);
    flash('success', 'Banner updated.');
    redirect('banners-list.php');
}

require_once __DIR__ . '/../app/views/partials/header.php';
require_once __DIR__ . '/../app/views/partials/navbar.php';
?>
<main class="container narrow">
    <h1>Edit Banner</h1>
    <form method="post" class="card form-grid">
        <input type="hidden" name="action" value="update">
        <input name="title" value="<?= e($item['title']) ?>" required>
        <input name="image_url" value="<?= e($item['image_url']) ?>" required>
        <input name="link_url" value="<?= e((string)($item['link_url'] ?? '')) ?>">
        <input name="region" value="<?= e((string)($item['region'] ?? '')) ?>">
        <input type="number" name="display_order" value="<?= e((string)$item['display_order']) ?>">
        <label><input type="checkbox" name="is_active" <?= ((int)$item['is_active'] === 1) ? 'checked' : '' ?>> Active</label>
        <input type="datetime-local" name="valid_from" value="<?= e((string)($item['valid_from'] ?? '')) ?>">
        <input type="datetime-local" name="valid_until" value="<?= e((string)($item['valid_until'] ?? '')) ?>">
        <button type="submit">Update</button>
    </form>
</main>
<?php require_once __DIR__ . '/../app/views/partials/footer.php'; ?>