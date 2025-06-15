<?php
declare(strict_types=1);

namespace App\Middleware;

use App\Core\Traits\RedirectTrait;
use App\Core\View;

class AuthMiddleware
{
    use RedirectTrait;

    public function handle(): ?string
    {
        if (!isset($_SESSION['user_id'])) {
            $_SESSION['error'] = 'Please login to access this page';
            $this->redirect('/signin');
        }
        return null;
    }
} 