<?php
declare(strict_types=1);

namespace App\Entities\Department;


/**
 * Class DepartmentWithMaxSalary (Department Decorator)
 * @package App\Entities\Department
 */
class DepartmentWithMaxSalary extends Department
{
    /**
     * @var float
     */
    private float $maxSalary;

    public function __construct(DepartmentKey $key, string $name, float $maxSalary)
    {
        parent::__construct($key, $name);
        $this->maxSalary = $maxSalary;
    }

    /**
     * @return float
     */
    public function getMaxSalary(): float
    {
        return $this->maxSalary;
    }
}