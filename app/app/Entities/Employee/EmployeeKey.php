<?php
declare(strict_types=1);

namespace App\Entities\Employee;


use App\Entities\Contract\Key;

class EmployeeKey implements Key
{
    private int $id;

    /**
     * EmployeeKey constructor.
     *
     * @param int $id
     */
    public function __construct(int $id)
    {
        $this->id = $id;
    }

    public function __toString()
    {
        return (string) $this->id;
    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }
}