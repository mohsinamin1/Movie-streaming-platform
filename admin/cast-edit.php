<?php
declare(strict_types=1);
require_once __DIR__ . '/../app/config/config.php';
require_once __DIR__ . '/../app/core/helpers.php';
require_once __DIR__ . '/../app/core/admin_guard.php';
require_once __DIR__ . '/../app/config/database.php';

$id = (int)($_GET['id'] ?? 0);
$stmt = db()->prepare('SELECT * FROM cast_members WHERE id = :id LIMIT 1');
$stmt->execute(['id' => $id]);
$item = $stmt->fetch();
if (!$item) {
    redirect('cast-list.php');
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && ($_POST['action'] ?? '') === 'update') {
    db()->prepare('UPDATE cast_members SET full_name=:full_name, birth_date=:birth_date, nationality=:nationality, bio=:bio, photo_url=:photo_url WHERE id=:id')->execute([
        'id' => $id,
        'full_name' => $_POST['full_name'],
        'birth_date' => $_POST['birth_date'] ?: null,
        'nationality' => $_POST['nationality'],
        'bio' => $_POST['bio'],
        'photo_url' => $_POST['photo_url'],
    ]);
    flash('success', 'Cast member updated.');
    redirect('cast-list.php');
}

require_once __DIR__ . '/../app/views/partials/header.php';
require_once __DIR__ . '/../app/views/partials/navbar.php';
?>
<main class="container narrow">
    <h1>Edit Cast Member</h1>
    <form method="post" class="card form-grid">
        <input type="hidden" name="action" value="update">
        <input name="full_name" value="<?= e($item['full_name']) ?>" required>
        <input type="date" name="birth_date" value="<?= e((string)($item['birth_date'] ?? '')) ?>">
        <input name="nationality" value="<?= e((string)($item['nationality'] ?? '')) ?>">
        <textarea name="bio"><?= e((string)($item['bio'] ?? '')) ?></textarea>
        <input name="photo_url" value="<?= e((string)($item['photo_url'] ?? '')) ?>">
        <button type="submit">Update</button>
    </form>
</main>
<?php require_once __DIR__ . '/../app/views/partials/footer.php'; ?>