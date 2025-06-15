<?php
declare(strict_types=1);

namespace App\Middleware;

use App\Helpers\CommonHelper;

class AuthMiddleware
{
    public function handle(): void
    {
        if (!CommonHelper::isAuthenticated()) {
            CommonHelper::redirect('/signin');
        }
    }
} 