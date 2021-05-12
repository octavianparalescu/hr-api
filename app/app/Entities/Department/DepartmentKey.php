<?php
declare(strict_types=1);

namespace App\Entities\Department;


use App\Entities\Contract\Key;

class DepartmentKey implements Key
{
    private int $id;

    public function __construct(int $id)
    {
        $this->id = $id;
    }

    public function __toString()
    {
        return (string) $this->getId();
    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }
}