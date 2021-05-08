<?php
declare(strict_types=1);

namespace App\Models\Contract;


interface DatabaseConverter
{
    public function fromDbToEntity(array $dbObject);

    public function fromEntityToDb($entity): array;
}