<?php

class Flash
{
    public static function add(string $type, string $message): void
    {
        if (!isset($_SESSION)) {
            return;
        }
        $_SESSION['flash'] = $_SESSION['flash'] ?? [];
        $_SESSION['flash'][] = [
            'type' => $type,
            'message' => $message,
        ];
    }

    public static function consumeAll(): array
    {
        if (!isset($_SESSION['flash'])) {
            return [];
        }
        $messages = $_SESSION['flash'];
        unset($_SESSION['flash']);
        return $messages;
    }
}



