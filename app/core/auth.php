<?php

declare(strict_types=1);

require_once __DIR__ . '/../config/config.php';

function current_user(): ?array
{
    return $_SESSION['user'] ?? null;
}

function login_user(array $user): void
{
    $_SESSION['user'] = [
        'id' => (int)$user['id'],
        'username' => $user['username'],
        'email' => $user['email'],
        'is_admin' => ($user['username'] === ADMIN_USERNAME),
    ];
}

function logout_user(): void
{
    unset($_SESSION['user']);
}

function is_logged_in(): bool
{
    return isset($_SESSION['user']);
}

function is_admin(): bool
{
    return (bool)($_SESSION['user']['is_admin'] ?? false);
}
