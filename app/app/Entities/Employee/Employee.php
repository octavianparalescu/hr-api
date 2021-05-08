<?php
declare(strict_types=1);

namespace App\Entities\Employee;


use App\Entities\Contract\HasKey;
use App\Entities\Money\MoneyAmount;

class Employee implements HasKey
{
    private EmployeeKey $key;
    private string $firstName;
    private string $lastName;
    private MoneyAmount $salary;

    public function __construct(EmployeeKey $key, string $firstName, string $lastName, MoneyAmount $salary)
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
     * @return MoneyAmount
     */
    public function getSalary(): MoneyAmount
    {
        return $this->salary;
    }
}