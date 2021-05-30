<?php
declare(strict_types=1);

namespace App\Models\Employee;


use App\Entities\Department\DepartmentKey;
use App\Entities\Employee\Employee;
use App\Entities\Employee\EmployeeList;
use App\Entities\Time\TimeInterface;
use Exception;
use Illuminate\Support\Facades\DB;

class EmployeeDAO
{
    const TABLE = 'employee';
    private EmployeeDatabaseConverter $converter;
    private TimeInterface $time;

    public function __construct(EmployeeDatabaseConverter $converter, TimeInterface $time)
    {
        $this->converter = $converter;
        $this->time = $time;
    }

    public function fetchFromDepartment(
        DepartmentKey $departmentKey,
        string $orderColumn = 'salary',
        string $orderDirection = 'DESC'
    ): EmployeeList {
        $employeeList = new EmployeeList();
        $objects = DB::select(
            "SELECT id, first_name, last_name, salary, department_id
                   FROM employee
                   WHERE department_id = ?
                   ORDER BY $orderColumn $orderDirection",
            [$departmentKey->getId()]
        );

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
        $objects = DB::select(
            "SELECT id, first_name, last_name, salary, department_id
                   FROM employee
                   ORDER BY $orderColumn $orderDirection",
        );

        if (!$objects) {
            return $employeeList;
        }

        foreach ($objects as $object) {
            $employeeList->add($this->converter->fromDbToEntity((array) $object));
        }

        return $employeeList;
    }

    /**
     * @throws Exception
     */
    public function fetch(int $id)
    {
        $object = DB::selectOne(
            'SELECT id, first_name, last_name, salary, department_id
                   FROM employee
                   WHERE id = ?',
            [$id]
        );

        if (!$object) {
            return false;
        }

        return $this->converter->fromDbToEntity((array) $object);
    }

    public function create(array $data): Employee
    {
        $currentTime = $this->time->getTimeSqlFormat();
        DB::insert(
            'INSERT INTO employee(`department_id`, `first_name`, `last_name`, `salary`, `updated_at`, `created_at`)
                   VALUES(?, ?, ?, ?, ?, ?)',
            [$data['department_id'], $data['first_name'], $data['last_name'], $data['salary'], $currentTime, $currentTime]
        );

        $id = DB::getPdo()
                ->lastInsertId();

        return $this->fetch((int) $id);
    }
}