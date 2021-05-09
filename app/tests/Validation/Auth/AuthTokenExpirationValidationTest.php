<?php
declare(strict_types=1);

namespace Tests\Validation\Auth;

use App\Entities\Auth\AuthToken;
use App\Entities\Auth\UserKey;
use App\Validation\Auth\AuthTokenExpirationValidation;
use DateTime;
use PHPUnit\Framework\TestCase;
use Tests\Stub\Time\TimeStub;

class AuthTokenExpirationValidationTest extends TestCase
{
    public function testValidateGoodToken()
    {
        $currentTime = new DateTime('2020-02-02 14:00:00');
        $dateUsed = new DateTime('2020-02-02 15:00:00');
        $token = new AuthToken(new UserKey(1), 'test-token', new DateTime(), $dateUsed);
        $validator = new AuthTokenExpirationValidation(new TimeStub($currentTime));
        $this->assertTrue($validator->verifyToken($token));
    }

    public function testInValidateExpiredToken()
    {
        $currentTime = new DateTime('2020-02-02 14:00:00');
        $dateUsed = new DateTime('2020-02-03 15:00:00');
        $token = new AuthToken(new UserKey(1), 'test-token', new DateTime(), $dateUsed);
        $validator = new AuthTokenExpirationValidation(new TimeStub($currentTime));
        $this->assertTrue($validator->verifyToken($token));
    }
}
