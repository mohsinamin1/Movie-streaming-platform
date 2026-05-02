<?php

declare(strict_types=1);

require_once __DIR__ . '/../app/config/config.php';
require_once __DIR__ . '/../app/core/helpers.php';
require_once __DIR__ . '/../app/repositories/movie_repository.php';
require_once __DIR__ . '/../app/repositories/series_repository.php';

$featuredMovies = get_featured_movies();
$featuredSeries = get_featured_series();

require_once __DIR__ . '/../app/views/partials/header.php';
require_once __DIR__ . '/../app/views/partials/navbar.php';
require_once __DIR__ . '/../app/views/partials/flash.php';
?>
<main class="container">
    <section class="hero">
        <h1>Discover Movies and Series</h1>
        <p>Database-powered platform built with your project schema.</p>
    </section>

    <section>
        <h2>Featured Movies</h2>
        <div class="grid cards">
            <?php foreach ($featuredMovies as $movie): ?>
                <article class="card">
                    <h3><?= e($movie['title']) ?></h3>
                    <p><?= e((string)($movie['release_year'] ?? 'N/A')) ?> | IMDb <?= e((string)($movie['imdb_score'] ?? '0.0')) ?></p>
                    <a href="movie-detail.php?id=<?= (int)$movie['id'] ?>">View Details</a>
                </article>
            <?php endforeach; ?>
        </div>
    </section>

    <section>
        <h2>Featured Series</h2>
        <div class="grid cards">
            <?php foreach ($featuredSeries as $series): ?>
                <article class="card">
                    <h3><?= e($series['title']) ?></h3>
                    <p>Seasons: <?= e((string)$series['total_seasons']) ?> | IMDb <?= e((string)($series['imdb_score'] ?? '0.0')) ?></p>
                    <a href="series-detail.php?id=<?= (int)$series['id'] ?>">View Details</a>
                </article>
            <?php endforeach; ?>
        </div>
    </section>
</main>
<?php require_once __DIR__ . '/../app/views/partials/footer.php'; ?>
