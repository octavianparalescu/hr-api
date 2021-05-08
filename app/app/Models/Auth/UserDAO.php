<?php
declare(strict_types=1);

namespace App\Models\Auth;


use Illuminate\Support\Facades\DB;

class UserDAO
{
    const TABLE = 'user';
    private UserDatabaseConverter $converter;

    public function __construct(UserDatabaseConverter $converter)
    {
        $this->converter = $converter;
    }

    public function fetch(int $id)
    {
        $object = DB::table(self::TABLE)
                    ->select('id, first_name, last_name, email')
                    ->where('id', $id)
                    ->first();

        if (!$object) {
            return false;
        }

        return $this->converter->fromDbToEntity($object->toArray());
    }
}