<?php

declare(strict_types=1);

require_once __DIR__ . '/../repositories/notification_repository.php';

function pending_reviews(): array
{
    return get_pending_review_notifications();
}

function approve_review(int $notificationId): bool
{
    return update_review_status($notificationId, 'approved');
}

function reject_review(int $notificationId): bool
{
    return update_review_status($notificationId, 'rejected');
}
