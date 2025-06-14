<?php
declare(strict_types=1);

namespace App\Core;

class ErrorHandler
{
    private static ?ErrorHandler $instance = null;

    private function __construct()
    {
    }

    public static function getInstance(): self
    {
        if (self::$instance === null) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    public function handleError(\Throwable $e): void
    {
        $this->logError($e);
    }

    private function logError(\Throwable $e): void
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