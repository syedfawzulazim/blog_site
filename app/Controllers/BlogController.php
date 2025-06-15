<?php
declare(strict_types=1);

namespace App\Controllers;

use App\Core\ErrorHandler;
use App\Core\Traits\RedirectTrait;
use App\Core\Traits\ValidateMethodTrait;
use App\Core\View;
use App\Models\BlogPost;

class BlogController
{
    use RedirectTrait, ValidateMethodTrait;

    private BlogPost $blogPost;

    public function __construct(BlogPost $blogPost)
    {
        $this->blogPost = $blogPost;
    }

    public function index(): string
    {
        if (!isset($_SESSION['user_id'])) {
            $this->redirect('/signin');
        }
        return View::render('blog/create');
    }

    public function create(): string
    {
        try {
            if ($error = $this->validateMethod('POST', 'blog/create', ['old' => $_POST])) {
                return $error;
            }

            $errors = $this->validatePost($_POST);
            if (!empty($errors)) {
                return View::render('blog/create', [
                    'errors' => $errors,
                    'old' => $_POST
                ]);
            }

            if ($this->blogPost->create($_POST, $_SESSION['user_id'])) {
                $_SESSION['success'] = 'Blog post created successfully!';
                $this->redirect('/');
            }

            return View::render('blog/create', [
                'errors' => ['Failed to create blog post'],
                'old' => $_POST
            ]);
        } catch (\Throwable $e) {
            ErrorHandler::getInstance()->handleError($e);
            return View::render('blog/create', [
                'errors' => ['An error occurred while creating the post'],
                'old' => $_POST
            ]);
        }
    }

    public function edit(string $id): string
    {
        try {
            $post = $this->blogPost->getPostById($id);
            if (!$post || $post['user_id'] !== $_SESSION['user_id']) {
                $this->redirect('/');
            }

            return View::render('blog/edit', [
                'post' => $post
            ]);
        } catch (\Throwable $e) {
            ErrorHandler::getInstance()->handleError($e);
            $_SESSION['error'] = 'An error occurred while fetching the post';
            $this->redirect('/');
        }
    }

    public function update(string $id): string
    {
        try {
            if ($error = $this->validateMethod('POST', 'blog/update')) {
                return $error;
            }

            $post = $this->blogPost->getPostById($id);
            if (!$post || $post['user_id'] !== $_SESSION['user_id']) {
                $this->redirect('/');
            }

            $errors = $this->validatePost($_POST);
            if (!empty($errors)) {
                return View::render('blog/edit', [
                    'errors' => $errors,
                    'post' => $post
                ]);
            }

            if ($this->blogPost->update($id, $_POST)) {
                $_SESSION['success'] = 'Blog post updated successfully!';
                $this->redirect('/');
            }

            return View::render('blog/edit', [
                'errors' => ['Failed to update blog post'],
                'post' => $post
            ]);
        } catch (\Throwable $e) {
            ErrorHandler::getInstance()->handleError($e);
            return View::render('blog/edit', [
                'errors' => ['An error occurred while updating the post'],
                'post' => $post ?? null
            ]);
        }
    }

    public function delete(string $id): string
    {
        try {
            $result = $this->blogPost->delete($id, $_SESSION['user_id']);
            
            if ($result === true) {
                $_SESSION['success'] = 'Blog post deleted successfully!';
            } else {
                $_SESSION['error'] = $result;
            }
            
            $this->redirect('/');
        } catch (\Throwable $e) {
            ErrorHandler::getInstance()->handleError($e);
            $_SESSION['error'] = 'An error occurred while deleting the post';
            $this->redirect('/');
        }
    }

    private function validatePost(array $data): array
    {
        $errors = [];

        if (empty($data['title'])) {
            $errors['title'] = 'Title is required';
        } elseif (strlen($data['title']) > 255) {
            $errors['title'] = 'Title must be less than 255 characters';
        }

        if (empty($data['content'])) {
            $errors['content'] = 'Content is required';
        }  elseif (strlen($data['content']) < 5) {
            $errors['content'] = 'content must be more than 5 characters';
        }

        return $errors;
    }
} 