<?php

declare(strict_types=1);

require_once __DIR__ . '/../app/config/config.php';
require_once __DIR__ . '/../app/core/helpers.php';
require_once __DIR__ . '/../app/core/auth.php';
require_once __DIR__ . '/../app/core/csrf.php';
require_once __DIR__ . '/../app/core/validator.php';
require_once __DIR__ . '/../app/repositories/movie_repository.php';
require_once __DIR__ . '/../app/services/review_service.php';

$id = (int)($_GET['id'] ?? 0);
$movie = get_movie_by_id($id);

if (!$movie) {
    flash('error', 'Movie not found.');
    redirect('browse-movies.php');
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!is_logged_in()) {
        flash('error', 'Please login to submit a review.');
        redirect('login.php');
    }

    if (!verify_csrf((string)($_POST['_token'] ?? ''))) {
        flash('error', 'Invalid request token.');
        redirect('movie-detail.php?id=' . $id);
    }

    $rating = (int)($_POST['rating'] ?? 0);
    $text = trim((string)($_POST['text'] ?? ''));

    $ratingError = validate_rating($rating);
    if ($ratingError !== null) {
        flash('error', $ratingError);
        redirect('movie-detail.php?id=' . $id);
    }

    submit_review((int)current_user()['id'], 'movie', $id, $rating, $text);
    flash('success', 'Review submitted. Waiting for admin approval.');
    redirect('movie-detail.php?id=' . $id);
}

$approvedReviews = get_approved_reviews('movie', $id);
$avg = get_average_rating($approvedReviews);

require_once __DIR__ . '/../app/views/partials/header.php';
require_once __DIR__ . '/../app/views/partials/navbar.php';
require_once __DIR__ . '/../app/views/partials/flash.php';
?>
<main class="container">
    <article class="card">
        <h1><?= e($movie['title']) ?></h1>
        <p><?= e((string)$movie['description']) ?></p>
        <p>Duration: <?= e((string)$movie['duration_min']) ?> min</p>
        <p>Average User Rating: <?= e((string)$avg) ?>/5</p>
    </article>

    <section class="card">
        <h2>Submit Review</h2>
        <?php if (is_logged_in()): ?>
            <form method="post" class="form-grid">
                <input type="hidden" name="_token" value="<?= e(csrf_token()) ?>">
                <label>Rating (1-5)</label>
                <input type="number" name="rating" min="1" max="5" required>
                <label>Review</label>
                <textarea name="text" rows="4" required></textarea>
                <button type="submit">Submit</button>
            </form>
        <?php else: ?>
            <p>Please <a href="login.php">login</a> to submit a review.</p>
        <?php endif; ?>
    </section>

    <section>
        <h2>Approved Reviews</h2>
        <?php foreach ($approvedReviews as $review): ?>
            <article class="card">
                <p><strong><?= e($review['username']) ?></strong> rated <?= e((string)$review['payload']['rating']) ?>/5</p>
                <p><?= e((string)$review['payload']['text']) ?></p>
            </article>
        <?php endforeach; ?>
    </section>
</main>
<?php require_once __DIR__ . '/../app/views/partials/footer.php'; ?>
