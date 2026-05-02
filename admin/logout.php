<?php

declare(strict_types=1);

require_once __DIR__ . '/../app/config/config.php';
require_once __DIR__ . '/../app/core/helpers.php';
require_once __DIR__ . '/../app/core/auth.php';

logout_user();
flash('success', 'Admin session ended.');
redirect('login.php');
