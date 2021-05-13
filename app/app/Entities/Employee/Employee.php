<?php
declare(strict_types=1);

namespace App\Entities\Employee;


use App\Entities\Contract\HasKey;
use App\Entities\Department\DepartmentKey;
use JsonSerializable;

class Employee implements HasKey, JsonSerializable
{
    private EmployeeKey $key;
    private string $firstName;
    private string $lastName;
    private float $salary;
    private DepartmentKey $departmentKey;

    public function __construct(
        EmployeeKey $key,
        DepartmentKey $departmentKey,
        string $firstName,
        string $lastName,
        float $salary
    ) {
        $this->key = $key;
        $this->firstName = $firstName;
        $this->lastName = $lastName;
        $this->salary = $salary;
        $this->departmentKey = $departmentKey;
    }

    public function getId(): int
    {
        return $this->getKey()
                    ->getId();
    }

    /**
     * @return string
     */
    public function getFirstName(): string
    {
        return $this->firstName;
    }

    /**
     * @return string
     */
    public function getLastName(): string
    {
        return $this->lastName;
    }

    public function getKey(): EmployeeKey
    {
        return $this->key;
    }

    /**
     * @return float
     */
    public function getSalary(): float
    {
        return $this->salary;
    }

    /**
     * @return DepartmentKey
     */
    public function getDepartmentKey(): DepartmentKey
    {
        return $this->departmentKey;
    }

    public function jsonSerialize(): array
    {
        return [
            'id' => $this->getId(),
            'first_name' => $this->getFirstName(),
            'last_name' => $this->getLastName(),
            'salary' => $this->getSalary(),
            'department_id' => $this->getDepartmentKey()
                                    ->getId(),
        ];
    }
}