<?php
declare(strict_types=1);

namespace App\Repository\Department;


use App\Entities\Department\Department;
use App\Entities\Department\DepartmentList;
use App\Models\Department\DepartmentDAO;
use Exception;

class DepartmentRepository
{
    private DepartmentDAO $DAO;

    public function __construct(DepartmentDAO $DAO)
    {
        $this->DAO = $DAO;
    }

    /**
     * @throws Exception
     */
    public function fetch(int $id)
    {
        return $this->DAO->fetch($id);
    }

    public function fetchAll(): DepartmentList
    {
        return $this->DAO->fetchAll();
    }

    public function fetchAllWithMaxSalaries(): DepartmentList
    {
        return $this->DAO->fetchAllWithMaxSalaries();
    }

    public function fetchWithEmployeeSalariesHigherCondition(int $minNoOfEmployees, float $havingMinSalary): DepartmentList
    {
        return $this->DAO->fetchWithEmployeeSalariesHigherCondition($minNoOfEmployees, $havingMinSalary);
    }

    public function create(array $data): Department
    {
        return $this->DAO->create($data);
    }
}