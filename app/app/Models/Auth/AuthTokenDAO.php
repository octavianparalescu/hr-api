<?php
declare(strict_types=1);

namespace App\Models\Auth;


use Exception;
use Illuminate\Support\Facades\DB;

class AuthTokenDAO
{
    const TABLE = 'auth_token';
    private AuthTokenDatabaseConverter $converter;

    public function __construct(AuthTokenDatabaseConverter $converter)
    {
        $this->converter = $converter;
    }

    /**
     * @throws Exception
     */
    public function fetch(string $token)
    {
        $object = DB::table(self::TABLE)
                    ->select('id, user_id, token, created_at, used_at')
                    ->where('token', $token)
                    ->first();

        if (!$object) {
            return false;
        }

        return $this->converter->fromDbToEntity($object->toArray());
    }
}