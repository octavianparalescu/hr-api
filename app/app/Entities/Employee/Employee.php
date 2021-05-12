<?php
declare(strict_types=1);

namespace App\Entities\Employee;


use App\Entities\Contract\HasKey;

class Employee implements HasKey
{
    private EmployeeKey $key;
    private string $firstName;
    private string $lastName;
    private float $salary;

    public function __construct(EmployeeKey $key, string $firstName, string $lastName, float $salary)
    {
        $this->key = $key;
        $this->firstName = $firstName;
        $this->lastName = $lastName;
        $this->salary = $salary;
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
}