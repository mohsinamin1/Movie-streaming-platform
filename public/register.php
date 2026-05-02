<?php

declare(strict_types=1);

require_once __DIR__ . '/../app/config/config.php';
require_once __DIR__ . '/../app/core/helpers.php';
require_once __DIR__ . '/../app/core/csrf.php';
require_once __DIR__ . '/../app/services/auth_service.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim((string)($_POST['email'] ?? ''));
    $username = trim((string)($_POST['username'] ?? ''));
    $password = (string)($_POST['password'] ?? '');
    $country = trim((string)($_POST['country'] ?? ''));
    $token = (string)($_POST['_token'] ?? '');

    if (!verify_csrf($token)) {
        flash('error', 'Invalid request token.');
        redirect('register.php');
    }

    if (register_account($email, $username, $password, $country !== '' ? $country : null)) {
        flash('success', 'Registration successful. Please login.');
        redirect('login.php');
    }

    flash('error', 'Registration failed. Email may already exist.');
    redirect('register.php');
}

require_once __DIR__ . '/../app/views/partials/header.php';
require_once __DIR__ . '/../app/views/partials/navbar.php';
require_once __DIR__ . '/../app/views/partials/flash.php';
?>
<main class="container narrow">
    <h1>Create Account</h1>
    <form method="post" class="card form-grid">
        <input type="hidden" name="_token" value="<?= e(csrf_token()) ?>">
        <label>Email</label>
        <input type="email" name="email" required>

        <label>Username</label>
        <input type="text" name="username" required>

        <label>Password</label>
        <input type="password" name="password" minlength="6" required>

        <label>Country</label>
        <input type="text" name="country">

        <button type="submit">Register</button>
    </form>
</main>
<?php require_once __DIR__ . '/../app/views/partials/footer.php'; ?>
