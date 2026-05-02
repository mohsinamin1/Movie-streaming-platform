<?php

declare(strict_types=1);

require_once __DIR__ . '/../config/database.php';

function find_user_by_email(string $email): ?array
{
    $stmt = db()->prepare('SELECT * FROM users WHERE email = :email LIMIT 1');
    $stmt->execute(['email' => $email]);
    $user = $stmt->fetch();
    return $user ?: null;
}

function create_user(string $email, string $username, string $passwordHash, ?string $country): int
{
    $stmt = db()->prepare(
        'INSERT INTO users (email, username, password_hash, country) VALUES (:email, :username, :password_hash, :country)'
    );

    $stmt->execute([
        'email' => $email,
        'username' => $username,
        'password_hash' => $passwordHash,
        'country' => $country,
    ]);

    return (int)db()->lastInsertId();
}

function find_user_by_id(int $id): ?array
{
    $stmt = db()->prepare('SELECT * FROM users WHERE id = :id LIMIT 1');
    $stmt->execute(['id' => $id]);
    $user = $stmt->fetch();
    return $user ?: null;
}
