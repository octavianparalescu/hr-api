<?php
declare(strict_types=1);

namespace App\Validation\Auth;


use App\Entities\Auth\AuthToken;
use DateTime;

class AuthTokenExpirationValidation
{
    const TOKEN_VALIDITY_IN_SECS = 60 * 60 * 24; // 24 hours

    public function verifyToken(AuthToken $authToken)
    {
        return $authToken->getDateCreated() < (new DateTime('-' . self::TOKEN_VALIDITY_IN_SECS . 'seconds'));
    }
}