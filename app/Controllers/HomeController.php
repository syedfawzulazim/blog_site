<?php
declare(strict_types=1);

namespace App\Controllers;

use App\Core\ErrorHandler;
use App\Core\View;
use App\Models\BlogPost;

class HomeController
{
    private BlogPost $blogPost;

    public function __construct()
    {
        $this->blogPost = new BlogPost();
    }

    public function index(): string
    {
        try {
            $posts = [];
            if (isset($_SESSION['user_id'])) {
                $posts = $this->blogPost->getAllPostsByUserId((int)$_SESSION['user_id']);
            }

            return View::render('home', [
                'posts' => $posts
            ]);
        } catch (\Throwable $e) {
            ErrorHandler::getInstance()->handleError($e);
            return View::render('home', [
                'errors' => ['An error occurred while fetching posts'],
                'posts' => []
            ]);
        }
    }
}