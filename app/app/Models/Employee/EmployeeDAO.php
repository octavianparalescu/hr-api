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
                     ->select(['id', 'first_name', 'last_name', 'salary', 'department_id'])
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

    /**
     * @throws Exception
     */
    public function fetch(int $id)
    {
        $object = DB::table(self::TABLE)
                    ->select(['id', 'department_id', 'first_name', 'last_name', 'salary'])
                    ->where('id', $id)
                    ->first();

        if (!$object) {
            return false;
        }

        return $this->converter->fromDbToEntity((array) $object);
    }

    public function create(array $data): Employee
    {
        $currentTime = $this->time->getTimeSqlFormat();
        $id = DB::table(self::TABLE)
                ->insertGetId(
                    [
                        'department_id' => $data['department_id'],
                        'first_name' => $data['first_name'],
                        'last_name' => $data['last_name'],
                        'salary' => $data['salary'],
                        'updated_at' => $currentTime,
                        'created_at' => $currentTime,
                    ]
                );

        return $this->fetch($id);
    }
}