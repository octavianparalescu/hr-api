<?php
declare(strict_types=1);

namespace Tests\Builder;


use App\Entities\Department\DepartmentKey;
use App\Entities\Employee\Employee;
use App\Entities\Employee\EmployeeKey;

class EmployeeBuilder
{
    private EmployeeKey $key;
    private string $firstName;
    private string $lastName;
    private float $salary;
    private DepartmentKey $departmentKey;

    public function __construct()
    {
        $id = rand(1000, 9999);
        $this->key = new EmployeeKey($id);
        $this->firstName = 'First' . $id;
        $this->lastName = 'Second' . $id;
        $this->salary = rand(40000, 90000);
        $this->departmentKey = new DepartmentKey(1);
    }

    /**
     * @param EmployeeKey $key
     *
     * @return EmployeeBuilder
     */
    public function setKey(EmployeeKey $key): EmployeeBuilder
    {
        $this->key = $key;

        return $this;
    }

    /**
     * @param string $firstName
     *
     * @return EmployeeBuilder
     */
    public function setFirstName(string $firstName): EmployeeBuilder
    {
        $this->firstName = $firstName;

        return $this;
    }

    /**
     * @param string $lastName
     *
     * @return EmployeeBuilder
     */
    public function setLastName(string $lastName): EmployeeBuilder
    {
        $this->lastName = $lastName;

        return $this;
    }

    /**
     * @param float|int $salary
     *
     * @return EmployeeBuilder
     */
    public function setSalary($salary)
    {
        $this->salary = $salary;

        return $this;
    }

    /**
     * @param DepartmentKey $departmentKey
     *
     * @return EmployeeBuilder
     */
    public function setDepartmentKey(DepartmentKey $departmentKey): EmployeeBuilder
    {
        $this->departmentKey = $departmentKey;

        return $this;
    }

    public function build(): Employee
    {
        return new Employee($this->key, $this->departmentKey, $this->firstName, $this->lastName, $this->salary);
    }
}