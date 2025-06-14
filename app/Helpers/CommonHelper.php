<?php
declare(strict_types=1);

namespace App\Helpers;

class CommonHelper
{
    public static function sanitizeInput(string $input): string
    {
        return htmlspecialchars(strip_tags(trim($input)));
    }

    public static function redirect(string $url): void
    {
        header("Location: $url");
        exit;
    }

    public static function isAuthenticated(): bool
    {
        return isset($_SESSION['user_id']);
    }

    public static function generateCsrfToken(): string
    {
        if (empty($_SESSION['csrf_token'])) {
            $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
        }
        return $_SESSION['csrf_token'];
    }

    public static function validateCsrfToken(string $token): bool
    {
        return isset($_SESSION['csrf_token']) && hash_equals($_SESSION['csrf_token'], $token);
    }
} 