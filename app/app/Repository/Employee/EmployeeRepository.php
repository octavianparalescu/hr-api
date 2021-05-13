<?php
declare(strict_types=1);

namespace App\Repository\Employee;


use App\Entities\Department\DepartmentKey;
use App\Entities\Employee\Employee;
use App\Entities\Employee\EmployeeList;
use App\Models\Employee\EmployeeDAO;

class EmployeeRepository
{
    private EmployeeDAO $DAO;

    public function __construct(EmployeeDAO $DAO)
    {
        $this->DAO = $DAO;
    }

    public function fetchAll(
        string $orderColumn = 'salary',
        string $orderDirection = 'DESC'
    ): EmployeeList {
        return $this->DAO->fetchAll($orderColumn, $orderDirection);
    }

    public function fetchFromDepartment(
        DepartmentKey $departmentKey,
        string $orderColumn = 'salary',
        string $orderDirection = 'DESC'
    ): EmployeeList {
        return $this->DAO->fetchFromDepartment($departmentKey, $orderColumn, $orderDirection);
    }

    public function create(array $data): Employee
    {
        return $this->DAO->create($data);
    }
}