<?php

namespace App\Entities\Auth;


use App\Entities\Contract\HasKey;

class User implements HasKey
{
    private string $firstName;
    private string $email;
    private UserKey $key;
    private string $lastName;

    public function __construct(UserKey $key, string $firstName, string $lastName, string $email)
    {
        $this->firstName = $firstName;
        $this->email = $email;
        $this->key = $key;
        $this->lastName = $lastName;
    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->getKey()->getId();
    }

    /**
     * @return string
     */
    public function getFirstName(): string
    {
        return $this->firstName;
    }

    /**
     * @return string
     */
    public function getEmail(): string
    {
        return $this->email;
    }

    public function getKey(): UserKey
    {
        return $this->key;
    }

    /**
     * @return string
     */
    public function getLastName(): string
    {
        return $this->lastName;
    }
}