<?php
declare(strict_types=1);

namespace Tests\Validation\Auth;

use App\Validation\Auth\AuthTokenFormatValidation;
use PHPUnit\Framework\TestCase;

class AuthTokenFormatValidationTest extends TestCase
{
    public function testGenerate()
    {
        $validator = new AuthTokenFormatValidation();
        $generatedToken = $validator->generate();

        $this->assertIsString($generatedToken);
        $this->assertEquals(120, strlen($generatedToken));
    }
}
