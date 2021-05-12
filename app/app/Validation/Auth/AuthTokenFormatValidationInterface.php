<?php
declare(strict_types=1);

namespace App\Validation\Auth;


interface AuthTokenFormatValidationInterface
{
    public function generate(): string;
}