<?php
declare(strict_types=1);

namespace App\Entities\Department;


use App\Entities\Contract\ListEntity;

class DepartmentList extends ListEntity
{
    public function getEntitiesType(): string
    {
        return Department::class;
    }
}