<?php

declare(strict_types=1);

require_once __DIR__ . '/auth.php';
require_once __DIR__ . '/helpers.php';

if (!is_logged_in()) {
    flash('error', 'Please login as admin first.');
    redirect('login.php');
}

if (!is_admin()) {
    flash('error', 'Access denied. Admin only.');
    redirect('../public/home.php');
}
