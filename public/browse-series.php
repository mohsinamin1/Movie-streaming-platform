<?php

declare(strict_types=1);

require_once __DIR__ . '/../app/config/config.php';
require_once __DIR__ . '/../app/core/helpers.php';
require_once __DIR__ . '/../app/repositories/series_repository.php';

$seriesList = get_series();

require_once __DIR__ . '/../app/views/partials/header.php';
require_once __DIR__ . '/../app/views/partials/navbar.php';
?>
<main class="container">
    <h1>Browse Series</h1>
    <div class="grid cards">
        <?php foreach ($seriesList as $series): ?>
            <article class="card">
                <h3><?= e($series['title']) ?></h3>
                <p>Seasons: <?= e((string)$series['total_seasons']) ?> | Status: <?= e((string)$series['status']) ?></p>
                <a href="series-detail.php?id=<?= (int)$series['id'] ?>">Details</a>
            </article>
        <?php endforeach; ?>
    </div>
</main>
<?php require_once __DIR__ . '/../app/views/partials/footer.php'; ?>
