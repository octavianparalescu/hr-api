<?php
declare(strict_types=1);

namespace App\Models\Auth;


use App\Models\Contract\Key;

class UserKey implements Key
{
    private int $id;

    public function __construct(int $id)
    {
        $this->id = $id;
    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    public function __toString()
    {
        return (string) $this->getId();
    }
}