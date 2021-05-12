<?php
declare(strict_types=1);

namespace Tests\Models\Auth;

use App\Models\Auth\PasswordAuthentication;
use PHPUnit\Framework\TestCase;

class PasswordAuthenticationTest extends TestCase
{
    public function testVerify()
    {
        $passwordAuthentication = new PasswordAuthentication();
        $cleartext = 'test-password';
        $hashed = $passwordAuthentication->hash($cleartext);
        $this->assertTrue($passwordAuthentication->verify(['password' => $cleartext], $hashed));
    }

    public function testThrowsIfNoPassword()
    {
        $passwordAuthentication = new PasswordAuthentication();
        $this->expectExceptionMessage('Authenticate with password expects an email and a password.');
        $cleartext = 'test-password';
        $hashed = $passwordAuthentication->hash($cleartext);
        $this->assertTrue($passwordAuthentication->verify(['password-bogus' => $cleartext], $hashed));
    }
}
