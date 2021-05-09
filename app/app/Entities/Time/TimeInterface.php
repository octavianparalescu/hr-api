<?php
declare(strict_types=1);

namespace App\Entities\Time;


use DateTime;

interface TimeInterface
{
    public function getDateTime(): DateTime;
}