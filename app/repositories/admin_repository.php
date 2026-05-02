<?php

declare(strict_types=1);

require_once __DIR__ . '/../config/database.php';

function fetch_all(string $table, string $orderBy = 'id DESC'): array
{
    $sql = sprintf('SELECT * FROM %s ORDER BY %s', $table, $orderBy);
    return db()->query($sql)->fetchAll();
}

function fetch_one(string $table, int $id): ?array
{
    $stmt = db()->prepare(sprintf('SELECT * FROM %s WHERE id = :id LIMIT 1', $table));
    $stmt->execute(['id' => $id]);
    $row = $stmt->fetch();
    return $row ?: null;
}
