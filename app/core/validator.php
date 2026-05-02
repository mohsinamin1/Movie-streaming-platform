<?php

declare(strict_types=1);

function validate_required(array $data, array $fields): array
{
    $errors = [];

    foreach ($fields as $field) {
        if (!isset($data[$field]) || trim((string)$data[$field]) === '') {
            $errors[$field] = ucfirst(str_replace('_', ' ', $field)) . ' is required.';
        }
    }

    return $errors;
}

function validate_rating(int $rating): ?string
{
    if ($rating < 1 || $rating > 5) {
        return 'Rating must be between 1 and 5.';
    }

    return null;
}
