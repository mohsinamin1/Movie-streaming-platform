<?php

declare(strict_types=1);

require_once __DIR__ . '/../app/config/config.php';
require_once __DIR__ . '/../app/core/helpers.php';
require_once __DIR__ . '/../app/core/user_guard.php';
require_once __DIR__ . '/../app/config/database.php';

$stmt = db()->prepare('SELECT * FROM notifications WHERE user_id = :user_id AND type = :type ORDER BY sent_at DESC');
$stmt->execute([
    'user_id' => (int)current_user()['id'],
    'type' => 'recommendation',
]);
$rows = $stmt->fetchAll();

$reviews = [];
foreach ($rows as $row) {
    $payload = json_decode((string)$row['message'], true);
    if (is_array($payload) && ($payload['kind'] ?? '') === 'review') {
        $row['payload'] = $payload;
        $reviews[] = $row;
    }
}

require_once __DIR__ . '/../app/views/partials/header.php';
require_once __DIR__ . '/../app/views/partials/navbar.php';
?>
<main class="container">
    <h1>My Reviews</h1>
    <?php foreach ($reviews as $review): ?>
        <article class="card">
            <p>Target: <?= e((string)$review['payload']['target']) ?> #<?= e((string)$review['payload']['target_id']) ?></p>
            <p>Rating: <?= e((string)$review['payload']['rating']) ?>/5</p>
            <p>Status: <?= e((string)$review['payload']['status']) ?></p>
            <p><?= e((string)$review['payload']['text']) ?></p>
        </article>
    <?php endforeach; ?>
</main>
<?php require_once __DIR__ . '/../app/views/partials/footer.php'; ?>
