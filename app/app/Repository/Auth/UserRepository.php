<?php
declare(strict_types=1);

namespace App\Repository\Auth;


use App\Entities\Auth\User;
use App\Entities\Auth\UserKey;
use App\Models\Auth\UserDAO;

class UserRepository
{
    private UserDAO $DAO;

    public function __construct(UserDAO $DAO)
    {
        $this->DAO = $DAO;
    }

    public function fetch(int $id)
    {
        return $this->DAO->fetch($id);
    }

    public function fetchByKey(UserKey $userKey)
    {
        return $this->fetch($userKey->getId());
    }

    public function isEmailRegistered(string $email): bool
    {
        return $this->DAO->isEmailRegistered($email);
    }

    public function create(array $inputData): User
    {
        return $this->DAO->create($inputData);
    }

    public function getPasswordForEmail(string $email)
    {
        return $this->DAO->getPasswordForEmail($email);
    }

    public function fetchByEmail(string $email)
    {
        return $this->DAO->fetchByEmail($email);
    }
}