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
        $object = DB::selectOne('SELECT id, first_name, last_name, email FROM user WHERE id = ?', [$id]);

        if (!$object) {
            return null;
        }

        return $this->converter->fromDbToEntity((array) $object);
    }

    public function isEmailRegistered(string $email): bool
    {
        $object = DB::selectOne('SELECT id FROM user WHERE email = ?', [$email]);

        if (!$object) {
            return false;
        }

        return true;
    }

    public function create(array $inputData): User
    {
        $currentTime = $this->time->getTimeSqlFormat();
        DB::insert(
            'INSERT INTO user(`first_name`, `last_name`, `email`, `password`, `created_at`, `updated_at`)
                   VALUES(?, ?, ?, ?, ?, ?)',
            [
                $inputData['first_name'],
                $inputData['last_name'],
                $inputData['email'],
                $inputData['password'],
                $currentTime,
                $currentTime,
            ]
        );

        $userId = DB::getPdo()
                    ->lastInsertId();

        return $this->fetch((int) $userId);
    }

    public function getPasswordForEmail(string $email)
    {
        $object = DB::selectOne('SELECT password FROM user WHERE email = ?', [$email]);

        if (!$object) {
            return false;
        }

        return $object->password;
    }

    public function fetchByEmail(string $email): ?User
    {
        $object = DB::selectOne('SELECT id, first_name, last_name, email FROM user WHERE email = ?', [$email]);

        if (!$object) {
            return null;
        }

        return $this->converter->fromDbToEntity((array) $object);
    }
}