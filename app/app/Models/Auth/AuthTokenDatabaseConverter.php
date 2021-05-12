<?php
declare(strict_types=1);

namespace App\Models\Auth;


use App\Entities\Auth\AuthToken;
use App\Entities\Auth\UserKey;
use App\Models\Contract\DatabaseConverter;
use DateTime;
use Exception;

class AuthTokenDatabaseConverter implements DatabaseConverter
{
    /**
     * @throws Exception
     */
    public function fromDbToEntity(array $dbObject)
    {
        return new AuthToken(
            new UserKey((int) $dbObject['user_id']),
            $dbObject['token'],
            new DateTime($dbObject['created_at']),
            new DateTime($dbObject['used_at'])
        );
    }

    /**
     * @param AuthToken $entity
     *
     * @return array
     */
    public function fromEntityToDb($entity): array
    {
        return [
            'user_id' => $entity->getUserKey()
                                ->getId(),
            'token' => $entity->getToken(),
        ];
    }
}