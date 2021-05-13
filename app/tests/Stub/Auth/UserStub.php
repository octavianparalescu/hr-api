<?php
declare(strict_types=1);

namespace Tests\Stub\Auth;


use App\Entities\Auth\User;
use App\Entities\Auth\UserKey;

class UserStub extends User
{
    public function __construct()
    {
        parent::__construct(new UserKey(1), 'First', 'Last', 'test@example.com');
    }
}