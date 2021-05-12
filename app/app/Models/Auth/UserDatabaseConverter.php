<?php
declare(strict_types=1);

namespace App\Models\Auth;


use App\Entities\Auth\User;
use App\Entities\Auth\UserKey;
use App\Models\Contract\DatabaseConverter;

class UserDatabaseConverter implements DatabaseConverter
{
    public function fromDbToEntity(array $dbObject): User
    {
        return new User(
            new UserKey((int) $dbObject['id']), $dbObject['first_name'], $dbObject['last_name'], $dbObject['email']
        );
    }

    /**
     * @param User $entity
     *
     * @return array
     */
    public function fromEntityToDb($entity): array
    {
        return [
            'id' => $entity->getId(),
            'email' => $entity->getEmail(),
            'name' => $entity->getFirstName(),
        ];
    }
}