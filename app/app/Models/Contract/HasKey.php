<?php
declare(strict_types=1);

namespace App\Models\Contract;


interface HasKey
{
    public function getKey(): Key;
}