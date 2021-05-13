<?php
declare(strict_types=1);

namespace App\Models\Department;


use App\Entities\Department\Department;
use App\Entities\Department\DepartmentList;
use App\Entities\Time\TimeInterface;
use App\Models\Employee\EmployeeDAO;
use Exception;
use Illuminate\Support\Facades\DB;

class DepartmentDAO
{
    const TABLE = 'department';
    private DepartmentDatabaseConverter $converter;
    private TimeInterface $time;

    public function __construct(DepartmentDatabaseConverter $databaseConverter, TimeInterface $time)
    {
        $this->converter = $databaseConverter;
        $this->time = $time;
    }

    public function fetchAll(): DepartmentList
    {
        $departmentList = new DepartmentList();
        $objects = DB::table(self::TABLE)
            ->select(['id', 'name'])
            ->get();

        if (!$objects) {
            return $departmentList;
        }

        foreach ($objects as $object) {
            $departmentList->add($this->converter->fromDbToEntity((array) $object));
        }

        return $departmentList;
    }

    public function fetchWithEmployeeSalariesHigherCondition(int $minNoOfEmployees, float $havingMinSalary): DepartmentList
    {
        $departmentList = new DepartmentList();
        $objects = DB::table(self::TABLE)
            ->select(['id', 'name', 'count(employee.id)'])
            ->join(EmployeeDAO::TABLE, EmployeeDAO::TABLE . '.department_id', self::TABLE . '.id')
            ->where(EmployeeDAO::TABLE . '.salary > ' . $havingMinSalary)
            ->having('count(employee.id)', '>', $minNoOfEmployees)
            ->get();

        if (!$objects) {
            return $departmentList;
        }

        foreach ($objects as $object) {
            $departmentList->add($this->converter->fromDbToEntity((array) $object));
        }

        return $departmentList;
    }

    public function fetchAllWithMaxSalaries(): DepartmentList
    {
        $departmentList = new DepartmentList();
        $objects = DB::table(self::TABLE)
                     ->select(['name'])
                     ->addSelect(DB::raw('MAX(' . EmployeeDAO::TABLE . '.salary) as max_salary'))
                     ->addSelect(DB::raw(self::TABLE . '.id as id'))
                     ->leftJoin(EmployeeDAO::TABLE, EmployeeDAO::TABLE . '.department_id', '=', self::TABLE . '.id')
                     ->get();

        if (!$objects) {
            return $departmentList;
        }

        foreach ($objects as $object) {
            $departmentList->add($this->converter->fromDbToEntityWithMaxSalary((array) $object));
        }

        return $departmentList;
    }

    /**
     * @throws Exception
     */
    public function fetch(int $id)
    {
        $object = DB::table(self::TABLE)
                    ->select(['id', 'name'])
                    ->where('id', $id)
                    ->first();

        if (!$object) {
            return false;
        }

        return $this->converter->fromDbToEntity((array) $object);
    }

    public function create(array $data): Department
    {
        $currentTime = $this->time->getTimeSqlFormat();
        $id = DB::table(self::TABLE)
                ->insertGetId(['name' => $data['name'], 'updated_at' => $currentTime, 'created_at' => $currentTime]);

        return $this->fetch($id);
    }
}