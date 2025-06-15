<?php
declare(strict_types=1);

namespace App\Models;

use App\Core\Db\DatabaseORM;
use App\Core\ErrorHandler;
use App\Models\Entities\BlogPost as BlogPostEntity;
use App\Models\Entities\User as UserEntity;
use Doctrine\ORM\EntityManager;

class BlogPost
{
    private EntityManager $entityManager;

    public function __construct(EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function create(array $data, int $userId): bool
    {
        try {
            $user = $this->entityManager->getRepository(UserEntity::class)->find($userId);
            if (!$user) {
                return false;
            }

            $post = new BlogPostEntity();
            $post->setTitle($data['title']);
            $post->setContent($data['content']);
            $post->setUser($user);

            $this->entityManager->persist($post);
            $this->entityManager->flush();
            return true;
        } catch (\Throwable $e) {
            ErrorHandler::getInstance()->handleError($e);
            return false;
        }
    }

    public function getAllPostsByUserId(int $userId): array
    {
        try {
            $posts = $this->entityManager->getRepository(BlogPostEntity::class)
                ->findBy(['user' => $userId], ['created_at' => 'DESC']);

            return array_map(function (BlogPostEntity $post) {
                return [
                    'id' => $post->getId(),
                    'title' => $post->getTitle(),
                    'content' => $post->getContent(),
                    'created_at' => $post->getCreatedAt()->format('Y-m-d H:i:s'),
                    'user_id' => $post->getUser()->getId(),
                    'author_name' => $post->getUser()->getName()
                ];
            }, $posts);
        } catch (\Throwable $e) {
            ErrorHandler::getInstance()->handleError($e);
            return [];
        }
    }

    public function getPostById(string $id): ?array
    {
        try {
            $post = $this->entityManager->getRepository(BlogPostEntity::class)->find($id);
            if (!$post) {
                return null;
            }

            return [
                'id' => $post->getId(),
                'title' => $post->getTitle(),
                'content' => $post->getContent(),
                'created_at' => $post->getCreatedAt()->format('Y-m-d H:i:s'),
                'user_id' => $post->getUser()->getId(),
                'author_name' => $post->getUser()->getName()
            ];
        } catch (\Throwable $e) {
            ErrorHandler::getInstance()->handleError($e);
            return null;
        }
    }

    public function update(string $id, array $data): bool
    {
        try {
            $post = $this->entityManager->getRepository(BlogPostEntity::class)->find($id);
            if (!$post) {
                return false;
            }

            $post->setTitle($data['title']);
            $post->setContent($data['content']);

            $this->entityManager->flush();
            return true;
        } catch (\Throwable $e) {
            ErrorHandler::getInstance()->handleError($e);
            return false;
        }
    }

    public function delete(string $id, int $userId): bool|string
    {
        try {
            $post = $this->entityManager->getRepository(BlogPostEntity::class)->find($id);
            
            if (!$post) {
                return 'Post not found';
            }

            if ($post->getUser()->getId() !== $userId) {
                return 'You are not authorized to delete this post';
            }

            $this->entityManager->remove($post);
            $this->entityManager->flush();
            return true;
        } catch (\Throwable $e) {
            ErrorHandler::getInstance()->handleError($e);
            return 'An error occurred while deleting the post';
        }
    }
} 