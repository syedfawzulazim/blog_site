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

    public function __construct()
    {
        $this->entityManager = DatabaseORM::create();
    }

    public function create(array $data, int $userId): bool
    {
        try {
            $user = $this->entityManager->find(UserEntity::class, $userId);
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

    public function getAllPosts(): array
    {
        try {
            $posts = $this->entityManager->getRepository(BlogPostEntity::class)
                ->createQueryBuilder('p')
                ->select('p', 'u')
                ->leftJoin('p.user', 'u')
                ->orderBy('p.created_at', 'DESC')
                ->getQuery()
                ->getResult();

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

    public function getPostById(int $id): ?array
    {
        try {
            $post = $this->entityManager->find(BlogPostEntity::class, $id);
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

    public function update(int $id, array $data): bool
    {
        try {
            $post = $this->entityManager->find(BlogPostEntity::class, $id);
            if (!$post) {
                return false;
            }

            if (isset($data['title'])) {
                $post->setTitle($data['title']);
            }
            if (isset($data['content'])) {
                $post->setContent($data['content']);
            }

            $this->entityManager->flush();
            return true;
        } catch (\Throwable $e) {
            ErrorHandler::getInstance()->handleError($e);
            return false;
        }
    }

    public function delete(int $id): bool
    {
        try {
            $post = $this->entityManager->find(BlogPostEntity::class, $id);
            if (!$post) {
                return false;
            }

            $this->entityManager->remove($post);
            $this->entityManager->flush();
            return true;
        } catch (\Throwable $e) {
            ErrorHandler::getInstance()->handleError($e);
            return false;
        }
    }
} 