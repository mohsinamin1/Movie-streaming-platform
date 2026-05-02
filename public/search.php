<?php

declare(strict_types=1);

require_once __DIR__ . '/../app/config/config.php';
require_once __DIR__ . '/../app/core/helpers.php';
require_once __DIR__ . '/../app/services/search_service.php';

$q = trim((string)($_GET['q'] ?? ''));
$result = ['movies' => [], 'series' => []];

if ($q !== '') {
    $result = global_search($q);
}

require_once __DIR__ . '/../app/views/partials/header.php';
require_once __DIR__ . '/../app/views/partials/navbar.php';
?>
<main class="container">
    <h1>Search</h1>
    <form method="get" class="row gap">
        <input type="text" name="q" value="<?= e($q) ?>" placeholder="Search movies or series">
        <button type="submit">Search</button>
    </form>

    <?php if ($q !== ''): ?>
        <h2>Movies</h2>
        <div class="grid cards">
            <?php foreach ($result['movies'] as $movie): ?>
                <article class="card">
                    <h3><?= e($movie['title']) ?></h3>
                    <a href="movie-detail.php?id=<?= (int)$movie['id'] ?>">Details</a>
                </article>
            <?php endforeach; ?>
        </div>

        <h2>Series</h2>
        <div class="grid cards">
            <?php foreach ($result['series'] as $series): ?>
                <article class="card">
                    <h3><?= e($series['title']) ?></h3>
                    <a href="series-detail.php?id=<?= (int)$series['id'] ?>">Details</a>
                </article>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
</main>
<?php require_once __DIR__ . '/../app/views/partials/footer.php'; ?>
