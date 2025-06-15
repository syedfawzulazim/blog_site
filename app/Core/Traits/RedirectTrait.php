<?php
declare(strict_types=1);

namespace App\Core\Traits;

trait RedirectTrait
{
    protected function redirect(string $url): never
    {
        header("Location: $url");
        exit;
    }
}