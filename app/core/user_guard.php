<?php

declare(strict_types=1);

require_once __DIR__ . '/auth.php';
require_once __DIR__ . '/helpers.php';

if (!is_logged_in()) {
    flash('error', 'Please login first.');
    redirect('../public/login.php');
}
