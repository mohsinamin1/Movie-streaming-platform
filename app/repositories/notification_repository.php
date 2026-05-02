<?php

declare(strict_types=1);

require_once __DIR__ . '/../config/database.php';

function create_review_notification(int $userId, string $targetType, int $targetId, int $rating, string $text): int
{
    $payload = json_encode([
        'kind' => 'review',
        'target' => $targetType,
        'target_id' => $targetId,
        'rating' => $rating,
        'text' => $text,
        'status' => 'pending',
    ], JSON_UNESCAPED_SLASHES);

    $stmt = db()->prepare(
        'INSERT INTO notifications (user_id, type, message, is_read) VALUES (:user_id, :type, :message, :is_read)'
    );

    $stmt->execute([
        'user_id' => $userId,
        'type' => 'recommendation',
        'message' => $payload,
        'is_read' => 0,
    ]);

    return (int)db()->lastInsertId();
}

function get_review_notifications_by_target(string $targetType, int $targetId): array
{
    $stmt = db()->prepare(
        'SELECT n.*, u.username
         FROM notifications n
         JOIN users u ON u.id = n.user_id
         WHERE n.type = :type
         ORDER BY n.sent_at DESC'
    );
    $stmt->execute(['type' => 'recommendation']);
    $all = $stmt->fetchAll();

    $filtered = [];
    foreach ($all as $row) {
        $payload = json_decode((string)$row['message'], true);
        if (!is_array($payload)) {
            continue;
        }

        if (($payload['kind'] ?? '') !== 'review') {
            continue;
        }

        if (($payload['target'] ?? '') !== $targetType || (int)($payload['target_id'] ?? 0) !== $targetId) {
            continue;
        }

        $row['payload'] = $payload;
        $filtered[] = $row;
    }

    return $filtered;
}

function get_pending_review_notifications(): array
{
    $stmt = db()->prepare(
        'SELECT n.*, u.username
         FROM notifications n
         JOIN users u ON u.id = n.user_id
         WHERE n.type = :type
         ORDER BY n.sent_at DESC'
    );
    $stmt->execute(['type' => 'recommendation']);
    $all = $stmt->fetchAll();

    $pending = [];
    foreach ($all as $row) {
        $payload = json_decode((string)$row['message'], true);
        if (!is_array($payload)) {
            continue;
        }

        if (($payload['kind'] ?? '') === 'review' && ($payload['status'] ?? '') === 'pending') {
            $row['payload'] = $payload;
            $pending[] = $row;
        }
    }

    return $pending;
}

function update_review_status(int $notificationId, string $status): bool
{
    $stmt = db()->prepare('SELECT message FROM notifications WHERE id = :id LIMIT 1');
    $stmt->execute(['id' => $notificationId]);
    $row = $stmt->fetch();
    if (!$row) {
        return false;
    }

    $payload = json_decode((string)$row['message'], true);
    if (!is_array($payload) || ($payload['kind'] ?? '') !== 'review') {
        return false;
    }

    $payload['status'] = $status;

    $update = db()->prepare('UPDATE notifications SET message = :message WHERE id = :id');
    return $update->execute([
        'message' => json_encode($payload, JSON_UNESCAPED_SLASHES),
        'id' => $notificationId,
    ]);
}
