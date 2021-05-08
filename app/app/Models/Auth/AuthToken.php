<?php
declare(strict_types=1);

namespace App\Models\Auth;


class AuthToken
{
    private UserKey $userKey;
    private string $token;
    private \DateTime $dateCreated;
    private \DateTime $dateUsed;

    public function __construct(UserKey $userKey, string $token, \DateTime $dateCreated, \DateTime $dateUsed)
    {
        $this->userKey = $userKey;
        $this->token = $token;
        $this->dateCreated = $dateCreated;
        $this->dateUsed = $dateUsed;
    }

    /**
     * @return UserKey
     */
    public function getUserKey(): UserKey
    {
        return $this->userKey;
    }

    /**
     * @return string
     */
    public function getToken(): string
    {
        return $this->token;
    }

    /**
     * @return \DateTime
     */
    public function getDateCreated(): \DateTime
    {
        return $this->dateCreated;
    }

    /**
     * @return \DateTime
     */
    public function getDateUsed(): \DateTime
    {
        return $this->dateUsed;
    }


}