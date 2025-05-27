<?php
declare(strict_types=1);

namespace App\Core;

class ErrorHandler
{
    public static function handleError(\Throwable $e): void
    {
        $message = sprintf(
            "Error: %s\nFile: %s\nLine: %d",
            $e->getMessage(),
            $e->getFile(),
            $e->getLine()
        );
        error_log($message);
    }
}