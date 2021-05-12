<?php
declare(strict_types=1);

namespace App\Validation\Auth;


class AuthTokenFormatValidation implements AuthTokenFormatValidationInterface
{
    const LENGTH = 120;

    public function generate(): string
    {
        return bin2hex(random_bytes(intval(self::LENGTH / 2)));
    }
}