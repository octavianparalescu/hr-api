<?php
declare(strict_types=1);

namespace App\Models\Employee;


use App\Entities\Department\DepartmentKey;
use App\Entities\Employee\EmployeeList;
use Illuminate\Support\Facades\DB;

class EmployeeDAO
{
    const TABLE = 'employee';
    private EmployeeDatabaseConverter $converter;

    public function __construct(EmployeeDatabaseConverter $converter)
    {
        $this->converter = $converter;
    }

    public function fetchFromDepartment(
        DepartmentKey $departmentKey,
        string $orderColumn = 'salary',
        string $orderDirection = 'DESC'
    ): EmployeeList {
        $employeeList = new EmployeeList();
        $objects = DB::table(self::TABLE)
                     ->select(['id', 'first_name', 'last_name', 'salary', 'department_id'])
                     ->orderBy($orderColumn, $orderDirection)
                     ->where('department_id', '=', $departmentKey->getId())
                     ->get();

        if (!$objects) {
            return $employeeList;
        }

        foreach ($objects as $object) {
            $employeeList->add($this->converter->fromDbToEntity((array) $object));
        }

        return $employeeList;
    }

    public function fetchAll(
        string $orderColumn = 'salary',
        string $orderDirection = 'DESC'
    ): EmployeeList {
        $employeeList = new EmployeeList();
        $objects = DB::table(self::TABLE)
                     ->select(['id', 'first_name', 'last_name', 'salary'])
                     ->orderBy($orderColumn, $orderDirection)
                     ->get();

        if (!$objects) {
            return $employeeList;
        }

        foreach ($objects as $object) {
            $employeeList->add($this->converter->fromDbToEntity((array) $object));
        }

        return $employeeList;
    }
}