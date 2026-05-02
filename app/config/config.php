<?php

declare(strict_types=1);

define('APP_NAME', 'Movie Streaming Platform');
define('APP_URL', 'http://localhost/movie-streaming-project/public');

define('DB_HOST', '127.0.0.1');
define('DB_PORT', '3306');
define('DB_NAME', 'movie_streaming');
define('DB_USER', 'root');
define('DB_PASS', '');

define('ADMIN_USERNAME', 'admin');

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
