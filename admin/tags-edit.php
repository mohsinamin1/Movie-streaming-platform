<?php
declare(strict_types=1);
require_once __DIR__ . '/../app/config/config.php';
require_once __DIR__ . '/../app/core/helpers.php';
require_once __DIR__ . '/../app/core/admin_guard.php';
require_once __DIR__ . '/../app/config/database.php';

$id = (int)($_GET['id'] ?? 0);
$stmt = db()->prepare('SELECT * FROM tags WHERE id = :id LIMIT 1');
$stmt->execute(['id' => $id]);
$item = $stmt->fetch();
if (!$item) {
    redirect('tags-list.php');
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && ($_POST['action'] ?? '') === 'update') {
    db()->prepare('UPDATE tags SET name=:name WHERE id=:id')->execute([
        'id' => $id,
        'name' => $_POST['name'],
    ]);
    flash('success', 'Tag updated.');
    redirect('tags-list.php');
}

require_once __DIR__ . '/../app/views/partials/header.php';
require_once __DIR__ . '/../app/views/partials/navbar.php';
?>
<main class="container narrow">
    <h1>Edit Tag</h1>
    <form method="post" class="card form-grid">
        <input type="hidden" name="action" value="update">
        <input name="name" value="<?= e($item['name']) ?>" required>
        <button type="submit">Update</button>
    </form>
</main>
<?php require_once __DIR__ . '/../app/views/partials/footer.php'; ?>