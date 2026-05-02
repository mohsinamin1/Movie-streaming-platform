<?php
declare(strict_types=1);
require_once __DIR__ . '/../../core/auth.php';
?>
<header class="topbar">
    <div class="container row between center">
        <a class="brand" href="<?= e(APP_URL) ?>/home.php">MovieDB</a>
        <nav class="row gap">
            <a href="<?= e(APP_URL) ?>/home.php">Home</a>
            <a href="<?= e(APP_URL) ?>/browse-movies.php">Movies</a>
            <a href="<?= e(APP_URL) ?>/browse-series.php">Series</a>
            <a href="<?= e(APP_URL) ?>/search.php">Search</a>
            <?php if (is_logged_in()): ?>
                <a href="<?= e(APP_URL) ?>/my-reviews.php">My Reviews</a>
                <?php if (is_admin()): ?>
                    <a href="<?= e(APP_URL) ?>/../admin/dashboard.php">Admin</a>
                    <a href="<?= e(APP_URL) ?>/../admin/movies-list.php">Manage Movies</a>
                    <a href="<?= e(APP_URL) ?>/../admin/series-list.php">Manage Series</a>
                <?php endif; ?>
                <a href="<?= e(APP_URL) ?>/logout.php">Logout</a>
            <?php else: ?>
                <a href="<?= e(APP_URL) ?>/login.php">Login</a>
                <a href="<?= e(APP_URL) ?>/register.php">Register</a>
            <?php endif; ?>
        </nav>
    </div>
</header>
