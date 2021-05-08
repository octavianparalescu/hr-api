<?php

namespace App\Models\Auth;


use App\Models\Contract\HasKey;
use App\Models\Contract\Key;

class User implements HasKey
{
    private string $name;
    private string $email;
    private string $password;
    private UserKey $key;

    public function __construct(UserKey $key, string $name, string $email, string $password)
    {
        $this->name = $name;
        $this->email = $email;
        $this->password = $password;
        $this->key = $key;
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
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @return string
     */
    public function getEmail(): string
    {
        return $this->email;
    }

    /**
     * @return string
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    public function getKey(): Key
    {
        return $this->key;
    }
}
