<?php
declare(strict_types=1);

namespace App\Models\Auth;


use App\Entities\Auth\AuthToken;
use App\Entities\Auth\UserKey;
use App\Entities\Time\TimeInterface;
use Exception;
use Illuminate\Support\Facades\DB;

class AuthTokenDAO
{
    const TABLE = 'auth_token';
    private AuthTokenDatabaseConverter $converter;
    private TimeInterface $time;

    public function __construct(AuthTokenDatabaseConverter $converter, TimeInterface $time)
    {
        $this->converter = $converter;
        $this->time = $time;
    }

    /**
     * @throws Exception
     */
    public function fetch(string $token)
    {
        $object = DB::selectOne(
            'SELECT id, user_id, token, created_at, used_at
                   FROM auth_token
                   WHERE token = ?',
            [$token]
        );

        if (!$object) {
            return false;
        }

        return $this->converter->fromDbToEntity((array) $object);
    }

    public function create(UserKey $userKey, string $token): AuthToken
    {
        $currentTime = $this->time->getTimeSqlFormat();
        DB::insert(
            'INSERT INTO auth_token(`user_id`, `token`, `used_at`, `created_at`)
                   VALUES(?, ?, ?, ?)',
            [$userKey->getId(), $token, $currentTime, $currentTime]
        );

        return $this->fetch($token);
    }
}