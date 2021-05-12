<?php
declare(strict_types=1);

namespace App\Models\Auth;


use App\Entities\Auth\User;
use App\Entities\Time\Time;
use Illuminate\Support\Facades\DB;

class UserDAO
{
    const TABLE = 'user';
    const COLUMNS = ['id', 'first_name', 'last_name', 'email'];
    private UserDatabaseConverter $converter;
    private Time $time;

    public function __construct(UserDatabaseConverter $converter, Time $time)
    {
        $this->converter = $converter;
        $this->time = $time;
    }

    public function fetch(int $id): ?User
    {
        $object = DB::table(self::TABLE)
                    ->select(self::COLUMNS)
                    ->where('id', $id)
                    ->first();

        if (!$object) {
            return null;
        }

        return $this->converter->fromDbToEntity((array) $object);
    }

    public function isEmailRegistered(string $email): bool
    {
        $object = DB::table(self::TABLE)
                    ->select(['id'])
                    ->where('email', $email)
                    ->first();

        if (!$object) {
            return false;
        }

        return true;
    }

    public function create(array $inputData): User
    {
        $currentTime = $this->time->getTimeSqlFormat();
        $userId = DB::table(self::TABLE)
                    ->insertGetId(array_merge($inputData, ['created_at' => $currentTime, 'updated_at' => $currentTime]));

        return $this->fetch($userId);
    }

    public function getPasswordForEmail(string $email)
    {
        $object = DB::table(self::TABLE)
                    ->select(['password'])
                    ->where('email', $email)
                    ->first();

        if (!$object) {
            return false;
        }

        return $object->password;
    }

    public function fetchByEmail(string $email): ?User
    {
        $object = DB::table(self::TABLE)
                    ->select(self::COLUMNS)
                    ->where('email', $email)
                    ->first();

        if (!$object) {
            return null;
        }

        return $this->converter->fromDbToEntity((array) $object);
    }
}