<?php
declare(strict_types=1);

namespace App\Repository\Auth;


use App\Entities\Auth\AuthToken;
use App\Entities\Auth\UserKey;
use App\Models\Auth\AuthTokenDAO;

class AuthTokenRepository
{
    private AuthTokenDAO $DAO;

    public function __construct(AuthTokenDAO $DAO)
    {
        $this->DAO = $DAO;
    }

    public function fetch(string $token)
    {
        return $this->DAO->fetch($token);
    }

    public function create(UserKey $userKey, string $token): AuthToken
    {
        return $this->DAO->create($userKey, $token);
    }
}