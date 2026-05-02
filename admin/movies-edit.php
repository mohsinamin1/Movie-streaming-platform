<?php
declare(strict_types=1);
require_once __DIR__ . '/../app/config/config.php';
require_once __DIR__ . '/../app/core/helpers.php';
require_once __DIR__ . '/../app/core/admin_guard.php';
require_once __DIR__ . '/../app/config/database.php';

$id = (int)($_GET['id'] ?? 0);
$movie = db()->prepare('SELECT * FROM movies WHERE id = :id LIMIT 1');
$movie->execute(['id' => $id]);
$movie = $movie->fetch();
if (!$movie) { redirect('movies-list.php'); }

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $stmt = db()->prepare('UPDATE movies SET title=:title, description=:description, duration_min=:duration_min, release_year=:release_year, language=:language, rating=:rating, imdb_score=:imdb_score, poster_url=:poster_url, trailer_url=:trailer_url, is_featured=:is_featured WHERE id=:id');
    $stmt->execute(['id' => $id,'title' => $_POST['title'], 'description' => $_POST['description'], 'duration_min' => (int)$_POST['duration_min'], 'release_year' => (int)$_POST['release_year'], 'language' => $_POST['language'], 'rating' => $_POST['rating'], 'imdb_score' => (float)$_POST['imdb_score'], 'poster_url' => $_POST['poster_url'], 'trailer_url' => $_POST['trailer_url'], 'is_featured' => isset($_POST['is_featured']) ? 1 : 0]);
    flash('success', 'Movie updated.');
    redirect('movies-list.php');
}
require_once __DIR__ . '/../app/views/partials/header.php';
require_once __DIR__ . '/../app/views/partials/navbar.php';
?>
<main class="container narrow"><h1>Edit Movie</h1><form method="post" class="card form-grid">
<input name="title" value="<?= e($movie['title']) ?>" required>
<textarea name="description"><?= e((string)$movie['description']) ?></textarea>
<input name="duration_min" type="number" value="<?= e((string)$movie['duration_min']) ?>" required>
<input name="release_year" type="number" value="<?= e((string)($movie['release_year'] ?? '')) ?>">
<input name="language" value="<?= e((string)($movie['language'] ?? '')) ?>">
<input name="rating" value="<?= e((string)($movie['rating'] ?? '')) ?>">
<input name="imdb_score" type="number" step="0.1" value="<?= e((string)($movie['imdb_score'] ?? '')) ?>">
<input name="poster_url" value="<?= e((string)($movie['poster_url'] ?? '')) ?>">
<input name="trailer_url" value="<?= e((string)($movie['trailer_url'] ?? '')) ?>">
<label><input type="checkbox" name="is_featured" <?= ((int)$movie['is_featured'] === 1) ? 'checked' : '' ?>> Featured</label>
<button type="submit">Update</button></form></main>
<?php require_once __DIR__ . '/../app/views/partials/footer.php'; ?>
