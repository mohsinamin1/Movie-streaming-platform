<?php
declare(strict_types=1);
require_once __DIR__ . '/../app/config/config.php';
require_once __DIR__ . '/../app/core/helpers.php';
require_once __DIR__ . '/../app/core/admin_guard.php';
require_once __DIR__ . '/../app/config/database.php';

$id = (int)($_GET['id'] ?? 0);
$stmt = db()->prepare('SELECT * FROM genres WHERE id = :id LIMIT 1');
$stmt->execute(['id' => $id]);
$item = $stmt->fetch();
if (!$item) {
    redirect('genres-list.php');
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && ($_POST['action'] ?? '') === 'update') {
    db()->prepare('UPDATE genres SET name=:name, description=:description WHERE id=:id')->execute([
        'id' => $id,
        'name' => $_POST['name'],
        'description' => $_POST['description'],
    ]);
    flash('success', 'Genre updated.');
    redirect('genres-list.php');
}

require_once __DIR__ . '/../app/views/partials/header.php';
require_once __DIR__ . '/../app/views/partials/navbar.php';
?>
<main class="container narrow">
    <h1>Edit Genre</h1>
    <form method="post" class="card form-grid">
        <input type="hidden" name="action" value="update">
        <input name="name" value="<?= e($item['name']) ?>" required>
        <textarea name="description"><?= e((string)$item['description']) ?></textarea>
        <button type="submit">Update</button>
    </form>
</main>
<?php require_once __DIR__ . '/../app/views/partials/footer.php'; ?>