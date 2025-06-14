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

    public function findByEmail(string $email): ?UserEntity
    {
        return $this->entityManager->getRepository(UserEntity::class)
            ->findOneBy(['email' => $email]);
    }

    public function findById(int $id): ?UserEntity
    {
        return $this->entityManager->find(UserEntity::class, $id);
    }

    public function update(int $id, array $data): bool
    {
        try {
            $user = $this->findById($id);
            if (!$user) {
                return false;
            }

            if (isset($data['name'])) {
                $user->setName($data['name']);
            }
            if (isset($data['email'])) {
                $user->setEmail($data['email']);
            }
            if (isset($data['password'])) {
                $user->setPassword(password_hash($data['password'], PASSWORD_DEFAULT));
            }

            $this->entityManager->flush();
            return true;
        } catch (\Exception $e) {
            error_log($e->getMessage());
            return false;
        }
    }

    public function delete(int $id): bool
    {
        try {
            $user = $this->findById($id);
            if (!$user) {
                return false;
            }

            $this->entityManager->remove($user);
            $this->entityManager->flush();
            return true;
        } catch (\Exception $e) {
            error_log($e->getMessage());
            return false;
        }
    }
} 