<?php
declare(strict_types=1);
require_once __DIR__ . '/../app/config/config.php';
require_once __DIR__ . '/../app/core/helpers.php';
require_once __DIR__ . '/../app/core/admin_guard.php';
require_once __DIR__ . '/../app/config/database.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (($_POST['action'] ?? '') === 'delete') {
        $stmt = db()->prepare('DELETE FROM movies WHERE id = :id');
        $stmt->execute(['id' => (int)$_POST['id']]);
        flash('success', 'Movie deleted.');
        redirect('movies-list.php');
    }
}

$movies = db()->query('SELECT * FROM movies ORDER BY id DESC')->fetchAll();
require_once __DIR__ . '/../app/views/partials/header.php';
require_once __DIR__ . '/../app/views/partials/navbar.php';
require_once __DIR__ . '/../app/views/partials/flash.php';
?>
<main class="container">
    <h1>Movies</h1>
    <p><a href="movies-create.php">Add Movie</a></p>
    <div class="card">
        <table width="100%">
            <tr><th>Title</th><th>Year</th><th>Actions</th></tr>
            <?php foreach ($movies as $movie): ?>
                <tr>
                    <td><?= e($movie['title']) ?></td>
                    <td><?= e((string)($movie['release_year'] ?? '')) ?></td>
                    <td>
                        <a href="movies-edit.php?id=<?= (int)$movie['id'] ?>">Edit</a>
                        <form method="post" style="display:inline">
                            <input type="hidden" name="action" value="delete">
                            <input type="hidden" name="id" value="<?= (int)$movie['id'] ?>">
                            <button type="submit">Delete</button>
                        </form>
                    </td>
                </tr>
            <?php endforeach; ?>
        </table>
    </div>
</main>
<?php require_once __DIR__ . '/../app/views/partials/footer.php'; ?>
