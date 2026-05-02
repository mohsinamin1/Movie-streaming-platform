<?php
declare(strict_types=1);
require_once __DIR__ . '/../app/config/config.php';
require_once __DIR__ . '/../app/core/helpers.php';
require_once __DIR__ . '/../app/core/admin_guard.php';
require_once __DIR__ . '/../app/config/database.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    db()->prepare('INSERT INTO series (title, description, total_seasons, status, language, rating, imdb_score, poster_url, trailer_url, is_featured) VALUES (:title,:description,:total_seasons,:status,:language,:rating,:imdb_score,:poster_url,:trailer_url,:is_featured)')->execute([
        'title'=>$_POST['title'],'description'=>$_POST['description'],'total_seasons'=>(int)$_POST['total_seasons'],'status'=>$_POST['status'],'language'=>$_POST['language'],'rating'=>$_POST['rating'],'imdb_score'=>(float)$_POST['imdb_score'],'poster_url'=>$_POST['poster_url'],'trailer_url'=>$_POST['trailer_url'],'is_featured'=>isset($_POST['is_featured'])?1:0]);
    flash('success', 'Series created.'); redirect('series-list.php');
}
require_once __DIR__ . '/../app/views/partials/header.php'; require_once __DIR__ . '/../app/views/partials/navbar.php';
?><main class="container narrow"><h1>Add Series</h1><form method="post" class="card form-grid"><input name="title" placeholder="Title" required><textarea name="description" placeholder="Description"></textarea><input name="total_seasons" type="number" placeholder="Total Seasons" required><input name="status" placeholder="Status (ongoing/completed/cancelled)"><input name="language" placeholder="Language"><input name="rating" placeholder="Rating"><input name="imdb_score" type="number" step="0.1" placeholder="IMDb Score"><input name="poster_url" placeholder="Poster URL"><input name="trailer_url" placeholder="Trailer URL"><label><input type="checkbox" name="is_featured"> Featured</label><button type="submit">Save</button></form></main><?php require_once __DIR__ . '/../app/views/partials/footer.php'; ?>
