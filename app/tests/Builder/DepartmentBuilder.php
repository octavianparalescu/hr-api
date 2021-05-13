<?php
declare(strict_types=1);

namespace Tests\Builder;


use App\Entities\Department\Department;
use App\Entities\Department\DepartmentKey;

class DepartmentBuilder
{
    private DepartmentKey $key;
    private string $name;

    public function __construct()
    {
        $id = rand(1000, 9999);
        $this->key = new DepartmentKey($id);
        $this->name = 'Department ' . $id;
    }

    /**
     * @param DepartmentKey $key
     *
     * @return DepartmentBuilder
     */
    public function setKey(DepartmentKey $key): DepartmentBuilder
    {
        $this->key = $key;

        return $this;
    }

    /**
     * @param string $name
     *
     * @return DepartmentBuilder
     */
    public function setName(string $name): DepartmentBuilder
    {
        $this->name = $name;

        return $this;
    }

    public function build()
    {
        return new Department($this->key, $this->name);
    }
}