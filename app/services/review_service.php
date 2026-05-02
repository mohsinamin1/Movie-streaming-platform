<?php

declare(strict_types=1);

require_once __DIR__ . '/../repositories/notification_repository.php';

function submit_review(int $userId, string $targetType, int $targetId, int $rating, string $text): int
{
    return create_review_notification($userId, $targetType, $targetId, $rating, $text);
}

function get_approved_reviews(string $targetType, int $targetId): array
{
    $reviews = get_review_notifications_by_target($targetType, $targetId);
    $approved = [];

    foreach ($reviews as $review) {
        $status = $review['payload']['status'] ?? 'pending';
        if ($status === 'approved') {
            $approved[] = $review;
        }
    }

    return $approved;
}

function get_average_rating(array $approvedReviews): float
{
    if (count($approvedReviews) === 0) {
        return 0.0;
    }

    $sum = 0;
    foreach ($approvedReviews as $review) {
        $sum += (int)($review['payload']['rating'] ?? 0);
    }

    return round($sum / count($approvedReviews), 1);
}
