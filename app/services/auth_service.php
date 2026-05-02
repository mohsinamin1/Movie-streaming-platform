<?php

declare(strict_types=1);

require_once __DIR__ . '/../repositories/user_repository.php';
require_once __DIR__ . '/../core/auth.php';

function attempt_login(string $email, string $password): bool
{
    $user = find_user_by_email($email);
    if (!$user) {
        return false;
    }

    if (!password_verify($password, $user['password_hash'])) {
        return false;
    }

    login_user($user);
    return true;
}

function register_account(string $email, string $username, string $password, ?string $country): bool
{
    if (find_user_by_email($email)) {
        return false;
    }

    $hash = password_hash($password, PASSWORD_DEFAULT);
    create_user($email, $username, $hash, $country);

    return true;
}
