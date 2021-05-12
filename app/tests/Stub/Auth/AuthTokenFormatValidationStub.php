<?php
declare(strict_types=1);

namespace Tests\Stub\Auth;


use App\Validation\Auth\AuthTokenFormatValidationInterface;

class AuthTokenFormatValidationStub implements AuthTokenFormatValidationInterface
{
    const TEST_TOKEN = 'test-token';

    public function generate(): string
    {
        return self::TEST_TOKEN;
    }
}