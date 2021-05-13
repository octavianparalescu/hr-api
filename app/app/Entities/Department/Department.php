<?php
declare(strict_types=1);

namespace App\Entities\Department;


use App\Entities\Contract\HasKey;
use JsonSerializable;

class Department implements HasKey, JsonSerializable
{
    private DepartmentKey $key;
    private string $name;

    public function __construct(DepartmentKey $key, string $name)
    {
        $this->key = $key;
        $this->name = $name;
    }

    public function getKey(): DepartmentKey
    {
        return $this->key;
    }

    public function getId(): int
    {
        return $this->getKey()
                    ->getId();
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    public function jsonSerialize(): array
    {
        return ['id' => $this->getId(), 'name' => $this->getName()];
    }
}