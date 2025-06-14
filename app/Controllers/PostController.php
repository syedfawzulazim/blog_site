<?php
declare(strict_types=1);

namespace App\Controllers;

use App\Core\Application;
use App\Services\PostService;

class PostController
{
    private PostService $postService;

    public function __construct()
    {
        $this->postService = new PostService();
    }

    public function show(array $params): void
    {
        $postId = (int) $params['id'];
        $post = $this->postService->findById($postId);

        if (!$post) {
            http_response_code(404);
            echo Application::getInstance()->renderView('error/404');
            return;
        }

        echo Application::getInstance()->renderView('post/show', [
            'post' => $post,
            'title' => $post->getTitle()
        ]);
    }
} 