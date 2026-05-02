<?php

declare(strict_types=1);

require_once __DIR__ . '/../app/config/config.php';
require_once __DIR__ . '/../app/core/helpers.php';
require_once __DIR__ . '/../app/repositories/movie_repository.php';

$movies = get_movies();

require_once __DIR__ . '/../app/views/partials/header.php';
require_once __DIR__ . '/../app/views/partials/navbar.php';
?>
<main class="container">
    <h1>Browse Movies</h1>
    <div class="grid cards">
        <?php foreach ($movies as $movie): ?>
            <article class="card">
                <h3><?= e($movie['title']) ?></h3>
                <p><?= e((string)($movie['release_year'] ?? 'N/A')) ?> | <?= e((string)$movie['duration_min']) ?> min</p>
                <a href="movie-detail.php?id=<?= (int)$movie['id'] ?>">Details</a>
            </article>
        <?php endforeach; ?>
    </div>
</main>
<?php require_once __DIR__ . '/../app/views/partials/footer.php'; ?>
