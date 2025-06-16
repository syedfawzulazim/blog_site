<?php
declare(strict_types=1);

namespace App\Controllers;

use App\Core\ErrorHandler;
use App\Core\View;
use App\Models\BlogPost;

class HomeController
{
    private BlogPost $blogPost;
    private View $view;

    public function __construct(BlogPost $blogPost,  View $view)
    {
        $this->blogPost = $blogPost;
        $this->view = $view;

    }

    public function index(): string
    {
        try {
            $posts = [];
            if (isset($_SESSION['user_id'])) {
                $posts = $this->blogPost->getAllPostsByUserId((int)$_SESSION['user_id']);
            }

            return $this->view->render('home', [
                'posts' => $posts
            ]);
        } catch (\Throwable $e) {
            ErrorHandler::getInstance()->handleError($e);
            return $this->view->render('home', [
                'errors' => ['An error occurred while fetching posts'],
                'posts' => []
            ]);
        }
    }
}