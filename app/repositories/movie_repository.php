<?php

declare(strict_types=1);

require_once __DIR__ . '/../config/database.php';

function get_featured_movies(int $limit = 8): array
{
    $stmt = db()->prepare('SELECT * FROM movies WHERE is_featured = 1 ORDER BY created_at DESC LIMIT :limit');
    $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
    $stmt->execute();
    return $stmt->fetchAll();
}

function get_movies(int $limit = 24): array
{
    $stmt = db()->prepare('SELECT * FROM movies ORDER BY created_at DESC LIMIT :limit');
    $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
    $stmt->execute();
    return $stmt->fetchAll();
}

function search_movies(string $query, int $limit = 30): array
{
    $stmt = db()->prepare(
        'SELECT * FROM movies WHERE title LIKE :q_title OR description LIKE :q_description ORDER BY created_at DESC LIMIT :limit'
    );
    $likeQuery = '%' . $query . '%';
    $stmt->bindValue(':q_title', $likeQuery, PDO::PARAM_STR);
    $stmt->bindValue(':q_description', $likeQuery, PDO::PARAM_STR);
    $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
    $stmt->execute();
    return $stmt->fetchAll();
}

function get_movie_by_id(int $id): ?array
{
    $stmt = db()->prepare('SELECT * FROM movies WHERE id = :id LIMIT 1');
    $stmt->execute(['id' => $id]);
    $movie = $stmt->fetch();
    return $movie ?: null;
}
