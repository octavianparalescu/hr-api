<?php
declare(strict_types=1);

namespace App\Models\Department;


use App\Entities\Department\Department;
use App\Entities\Department\DepartmentKey;
use App\Entities\Department\DepartmentWithMaxSalary;
use App\Models\Contract\DatabaseConverter;

class DepartmentDatabaseConverter implements DatabaseConverter
{
    public function fromDbToEntity(array $dbObject)
    {
        return new Department(new DepartmentKey($dbObject['id']), $dbObject['name']);
    }

    public function fromDbToEntityWithMaxSalary(array $dbObject)
    {
        return new DepartmentWithMaxSalary(
            new DepartmentKey($dbObject['id']), $dbObject['name'], $dbObject['max_salary'] ?? 0
        );
    }

    /**
     * @param Department $entity
     *
     * @return array
     */
    public function fromEntityToDb($entity): array
    {
        return [
            'id' => $entity->getId(),
            'name' => $entity->getName(),
        ];
    }
}