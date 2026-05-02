<?php

declare(strict_types=1);

require_once __DIR__ . '/../config/database.php';

function get_featured_series(int $limit = 8): array
{
    $stmt = db()->prepare('SELECT * FROM series WHERE is_featured = 1 ORDER BY created_at DESC LIMIT :limit');
    $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
    $stmt->execute();
    return $stmt->fetchAll();
}

function get_series(int $limit = 24): array
{
    $stmt = db()->prepare('SELECT * FROM series ORDER BY created_at DESC LIMIT :limit');
    $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
    $stmt->execute();
    return $stmt->fetchAll();
}

function search_series(string $query, int $limit = 30): array
{
    $stmt = db()->prepare(
        'SELECT * FROM series WHERE title LIKE :q_title OR description LIKE :q_description ORDER BY created_at DESC LIMIT :limit'
    );
    $likeQuery = '%' . $query . '%';
    $stmt->bindValue(':q_title', $likeQuery, PDO::PARAM_STR);
    $stmt->bindValue(':q_description', $likeQuery, PDO::PARAM_STR);
    $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
    $stmt->execute();
    return $stmt->fetchAll();
}

function get_series_by_id(int $id): ?array
{
    $stmt = db()->prepare('SELECT * FROM series WHERE id = :id LIMIT 1');
    $stmt->execute(['id' => $id]);
    $record = $stmt->fetch();
    return $record ?: null;
}

function get_episodes_for_series(int $seriesId): array
{
    $stmt = db()->prepare(
        'SELECT * FROM episodes WHERE series_id = :series_id ORDER BY season_number ASC, episode_number ASC'
    );
    $stmt->execute(['series_id' => $seriesId]);
    return $stmt->fetchAll();
}
