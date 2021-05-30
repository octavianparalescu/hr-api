<?php
declare(strict_types=1);

namespace App\Models\Department;


use App\Entities\Department\Department;
use App\Entities\Department\DepartmentList;
use App\Entities\Time\TimeInterface;
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
        $objects = DB::select('SELECT id, name FROM department');

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
        $objects = DB::select(
            'SELECT name, count(employee.id), department.id as id 
                   FROM department
                   LEFT JOIN employee ON employee.department_id = department.id
                   WHERE employee.salary > ?
                   GROUP BY department.id, name
                   HAVING count(employee.id) > ?',
            [$havingMinSalary, $minNoOfEmployees]
        );

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
        $objects = DB::select(
            'SELECT id, name,
                       (SELECT MAX(salary) FROM employee WHERE employee.department_id=department.id) as max_salary
                   FROM department'
        );

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
        $object = DB::selectOne('SELECT id, name FROM department where id = ?', [$id]);

        if (!$object) {
            return false;
        }

        return $this->converter->fromDbToEntity((array) $object);
    }

    public function create(array $data): Department
    {
        $currentTime = $this->time->getTimeSqlFormat();
        DB::insert(
            'INSERT INTO department(`name`, `updated_at`, `created_at`) VALUES(?, ?, ?)',
            [$data['name'], $currentTime, $currentTime]
        );

        $id = DB::getPdo()
                ->lastInsertId();

        return $this->fetch((int) $id);
    }
}