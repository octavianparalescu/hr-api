<?php
declare(strict_types=1);

namespace App\Entities\Contract;


interface HasKey
{
    public function getKey(): Key;
}