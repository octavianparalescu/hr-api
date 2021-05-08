<?php
declare(strict_types=1);

namespace App\Models\Auth;


class UserDAO
{
    private UserDatabaseConverter $converter;

    public function __construct(UserDatabaseConverter $converter)
    {
        $this->converter = $converter;
    }
}