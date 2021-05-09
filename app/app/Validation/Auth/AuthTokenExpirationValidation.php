<?php
declare(strict_types=1);

namespace App\Validation\Auth;


use App\Entities\Auth\AuthToken;
use App\Entities\Time\TimeInterface;
use DateInterval;

class AuthTokenExpirationValidation
{
    const TOKEN_VALIDITY_IN_SECS = 60 * 60 * 24; // 24 hours
    private TimeInterface $time;

    public function __construct(TimeInterface $time)
    {
        $this->time = $time;
    }

    public function verifyToken(AuthToken $authToken): bool
    {
        return $authToken->getDateUsed() > $this->time->getDateTime()
                                                      ->sub(new DateInterval('PT' . self::TOKEN_VALIDITY_IN_SECS . 'S'));
    }
}