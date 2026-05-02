<?php

declare(strict_types=1);

require_once __DIR__ . '/../app/config/config.php';
require_once __DIR__ . '/../app/core/helpers.php';
require_once __DIR__ . '/../app/core/csrf.php';
require_once __DIR__ . '/../app/services/auth_service.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim((string)($_POST['email'] ?? ''));
    $password = (string)($_POST['password'] ?? '');
    $token = (string)($_POST['_token'] ?? '');

    if (!verify_csrf($token)) {
        flash('error', 'Invalid request token.');
        redirect('login.php');
    }

    if (attempt_login($email, $password)) {
        flash('success', 'Welcome back!');
        redirect('home.php');
    }

    flash('error', 'Invalid email or password.');
    redirect('login.php');
}

require_once __DIR__ . '/../app/views/partials/header.php';
require_once __DIR__ . '/../app/views/partials/navbar.php';
require_once __DIR__ . '/../app/views/partials/flash.php';
?>
<main class="container narrow">
    <h1>Login</h1>
    <form method="post" class="card form-grid">
        <input type="hidden" name="_token" value="<?= e(csrf_token()) ?>">
        <label>Email</label>
        <input type="email" name="email" required>

        <label>Password</label>
        <input type="password" name="password" required>

        <button type="submit">Login</button>
    </form>
</main>
<?php require_once __DIR__ . '/../app/views/partials/footer.php'; ?>
