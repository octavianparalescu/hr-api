<?php
declare(strict_types=1);

namespace App\Entities\Employee;


use App\Entities\Contract\ListEntity;

class EmployeeList extends ListEntity
{
    public function getEntitiesType(): string
    {
        return Employee::class;
    }
}