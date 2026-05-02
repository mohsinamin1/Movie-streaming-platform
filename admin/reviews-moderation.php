<?php

declare(strict_types=1);

require_once __DIR__ . '/../app/config/config.php';
require_once __DIR__ . '/../app/core/helpers.php';
require_once __DIR__ . '/../app/core/admin_guard.php';
require_once __DIR__ . '/../app/core/csrf.php';
require_once __DIR__ . '/../app/services/moderation_service.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!verify_csrf((string)($_POST['_token'] ?? ''))) {
        flash('error', 'Invalid request token.');
        redirect('reviews-moderation.php');
    }

    $id = (int)($_POST['notification_id'] ?? 0);
    $action = (string)($_POST['action'] ?? '');

    if ($action === 'approve') {
        approve_review($id);
        flash('success', 'Review approved.');
    } elseif ($action === 'reject') {
        reject_review($id);
        flash('success', 'Review rejected.');
    }

    redirect('reviews-moderation.php');
}

$pending = pending_reviews();

require_once __DIR__ . '/../app/views/partials/header.php';
require_once __DIR__ . '/../app/views/partials/navbar.php';
require_once __DIR__ . '/../app/views/partials/flash.php';
?>
<main class="container">
    <h1>Review Moderation</h1>

    <?php foreach ($pending as $item): ?>
        <article class="card">
            <p>User: <?= e($item['username']) ?></p>
            <p>Target: <?= e((string)$item['payload']['target']) ?> #<?= e((string)$item['payload']['target_id']) ?></p>
            <p>Rating: <?= e((string)$item['payload']['rating']) ?>/5</p>
            <p><?= e((string)$item['payload']['text']) ?></p>

            <form method="post" class="row gap">
                <input type="hidden" name="_token" value="<?= e(csrf_token()) ?>">
                <input type="hidden" name="notification_id" value="<?= (int)$item['id'] ?>">
                <button type="submit" name="action" value="approve">Approve</button>
                <button type="submit" name="action" value="reject">Reject</button>
            </form>
        </article>
    <?php endforeach; ?>
</main>
<?php require_once __DIR__ . '/../app/views/partials/footer.php'; ?>
