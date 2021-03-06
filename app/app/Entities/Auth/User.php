<?php

namespace App\Entities\Auth;


use App\Entities\Contract\HasKey;
use Illuminate\Contracts\Auth\Authenticatable;
use JsonSerializable;

class User implements HasKey, JsonSerializable, Authenticatable
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
        return $this->getKey()
                    ->getId();
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

    public function jsonSerialize()
    {
        return [
            'id' => $this->getId(),
            'first_name' => $this->getFirstName(),
            'last_name' => $this->getLastName(),
            'email' => $this->getEmail(),
        ];
    }

    public function getAuthIdentifierName()
    {
        return null;
    }

    public function getAuthIdentifier()
    {
        return null;
    }

    public function getAuthPassword()
    {
        return null;
    }

    public function getRememberToken()
    {
        return null;
    }

    public function setRememberToken($value)
    {
        return null;
    }

    public function getRememberTokenName()
    {
        return null;
    }
}
