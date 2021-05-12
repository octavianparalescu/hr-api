<?php
declare(strict_types=1);

namespace App\Models\Auth;


use Illuminate\Auth\AuthenticationException;

class PasswordAuthentication
{
    const FIELD_EMAIL = 'email';
    const FIELD_PASSWORD = 'password';
    const ALGO = PASSWORD_BCRYPT;

    public function verify(array $credentials, $existingPassword): bool
    {
        if (!array_key_exists(self::FIELD_PASSWORD, $credentials)) {
            throw new AuthenticationException('Authenticate with password expects an email and a password.');
        }

        return password_verify($credentials[self::FIELD_PASSWORD], $existingPassword);
    }

    public function hash(string $password): string
    {
        return password_hash($password, self::ALGO);
    }
}