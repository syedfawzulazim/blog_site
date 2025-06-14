<?php
declare(strict_types=1);

namespace App\Models;

use App\Core\Db\DatabaseORM;
use App\Models\Entities\User as UserEntity;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Exception\ORMException;

class User
{
    private EntityManager $entityManager;

    public function __construct()
    {
        $this->entityManager = DatabaseORM::create();
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
        } catch (\Exception $e) {
            error_log($e->getMessage());
            return false;
        } catch (ORMException $e) {
            error_log($e->getMessage());
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
        } catch (\Exception $e) {
            error_log($e->getMessage());
            return null;
        }
    }

    public function findByEmail(string $email): ?UserEntity
    {
        return $this->entityManager->getRepository(UserEntity::class)
            ->findOneBy(['email' => $email]);
    }

    public function findById(int $id): ?UserEntity
    {
        return $this->entityManager->find(UserEntity::class, $id);
    }
} 