<?php
declare(strict_types=1);

namespace App\Repository\Auth;


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
}