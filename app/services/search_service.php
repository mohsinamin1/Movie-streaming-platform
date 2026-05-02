<?php

declare(strict_types=1);

require_once __DIR__ . '/../repositories/movie_repository.php';
require_once __DIR__ . '/../repositories/series_repository.php';

function global_search(string $query): array
{
    return [
        'movies' => search_movies($query),
        'series' => search_series($query),
    ];
}
