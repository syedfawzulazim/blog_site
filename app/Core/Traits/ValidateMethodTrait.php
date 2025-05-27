<?php
declare(strict_types=1);

namespace App\Core\Traits;

use App\Core\View;

trait ValidateMethodTrait
{
    protected function validateMethod(string $method, string $view): ?string
    {
        if ($_SERVER['REQUEST_METHOD'] !== $method) {
            http_response_code(405);
            return (new \App\Core\View)->render($view, [
                'errors' => ['Method not allowed']
            ]);
        }
        return null;
    }
} 