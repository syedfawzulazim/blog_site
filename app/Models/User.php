<?php
declare(strict_types=1);

namespace App\Models;

use App\Core\Db\DatabaseORM;
use App\Core\ErrorHandler;
use App\Models\Entities\User as UserEntity;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Exception\ORMException;

class User
{
    private EntityManager $entityManager;

    public function __construct()
    {
        try {
            $this->entityManager = DatabaseORM::create();
        } catch (\Throwable $e) {
            ErrorHandler::getInstance()->handleError($e);
            throw $e;
        }
    }

    public function create(array $data): bool
    {
        try {
            $user = new UserEntity();
            $user->setName($data['name']);
            $user->setEmail($data['email']);
            $user->setPassword(password_hash($data['password'], PASSWORD_DEFAULT));

            $this->entityManager->persist($user);
            $this->entityManager->flush();
            return true;
        } catch (\Throwable $e) {
            ErrorHandler::getInstance()->handleError($e);
            return false;
        }
    }

    public function login(string $email, string $password): ?UserEntity
    {
        try {
            $user = $this->findByEmail($email);
            if ($user && password_verify($password, $user->getPassword())) {
                return $user;
            }
            return null;
        } catch (\Throwable $e) {
            ErrorHandler::getInstance()->handleError($e);
            return null;
        }
    }

    public function findByEmail(string $email): ?UserEntity
    {
        try {
            return $this->entityManager->getRepository(UserEntity::class)
                ->findOneBy(['email' => $email]);
        } catch (\Throwable $e) {
            ErrorHandler::getInstance()->handleError($e);
            return null;
        }
    }

    public function findById(int $id): ?UserEntity
    {
        try {
            return $this->entityManager->find(UserEntity::class, $id);
        } catch (\Throwable $e) {
            ErrorHandler::getInstance()->handleError($e);
            return null;
        }
    }
} 