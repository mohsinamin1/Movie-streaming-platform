<?php

declare(strict_types=1);

require_once __DIR__ . '/../app/config/config.php';
require_once __DIR__ . '/../app/config/database.php';
require_once __DIR__ . '/../app/core/helpers.php';
require_once __DIR__ . '/../app/core/admin_guard.php';

$stats = [
    'users' => (int)db()->query('SELECT COUNT(*) FROM users')->fetchColumn(),
    'movies' => (int)db()->query('SELECT COUNT(*) FROM movies')->fetchColumn(),
    'series' => (int)db()->query('SELECT COUNT(*) FROM series')->fetchColumn(),
    'pending_reviews' => 0,
];

$rows = db()->query("SELECT message FROM notifications WHERE type='recommendation'")->fetchAll();
foreach ($rows as $row) {
    $payload = json_decode((string)$row['message'], true);
    if (is_array($payload) && ($payload['kind'] ?? '') === 'review' && ($payload['status'] ?? '') === 'pending') {
        $stats['pending_reviews']++;
    }
}

require_once __DIR__ . '/../app/views/partials/header.php';
require_once __DIR__ . '/../app/views/partials/navbar.php';
?>
<main class="container">
    <h1>Admin Dashboard</h1>
    <div class="grid cards">
        <article class="card"><h3>Users</h3><p><?= e((string)$stats['users']) ?></p></article>
        <article class="card"><h3>Movies</h3><p><?= e((string)$stats['movies']) ?></p></article>
        <article class="card"><h3>Series</h3><p><?= e((string)$stats['series']) ?></p></article>
        <article class="card"><h3>Pending Reviews</h3><p><?= e((string)$stats['pending_reviews']) ?></p></article>
    </div>

    <h2>Content Management</h2>
    <div class="card form-grid">
        <a href="movies-list.php">Manage Movies</a>
        <a href="movies-create.php">Add New Movie</a>
        <a href="series-list.php">Manage Series</a>
        <a href="series-create.php">Add New Series</a>
        <a href="episodes-list.php">Manage Episodes</a>
    </div>

    <p><a href="reviews-moderation.php">Go to Review Moderation</a></p>
    <p><a href="logout.php">Admin Logout</a></p>
</main>
<?php require_once __DIR__ . '/../app/views/partials/footer.php'; ?>
