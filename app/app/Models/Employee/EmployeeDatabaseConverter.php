<?php
declare(strict_types=1);

namespace App\Models\Employee;


use App\Entities\Department\DepartmentKey;
use App\Entities\Employee\Employee;
use App\Entities\Employee\EmployeeKey;
use App\Models\Contract\DatabaseConverter;

class EmployeeDatabaseConverter implements DatabaseConverter
{
    public function fromDbToEntity(array $dbObject)
    {
        return new Employee(
            new EmployeeKey((int) $dbObject['id']),
            new DepartmentKey((int) $dbObject['department_id']),
            $dbObject['first_name'],
            $dbObject['last_name'],
            (float) $dbObject['salary']
        );
    }

    /**
     * @param Employee $entity
     *
     * @return array
     */
    public function fromEntityToDb($entity): array
    {
        return [
            'id' => $entity->getId(),
            'first_name' => $entity->getFirstName(),
            'last_name' => $entity->getLastName(),
            'salary' => $entity->getSalary(),
        ];
    }
}