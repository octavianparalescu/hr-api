<?php
declare(strict_types=1);

namespace App\Entities\Time;


use DateTime;

abstract class TimeInterface
{
    abstract public function getDateTime(): DateTime;

    public function getTimeSqlFormat(): string
    {
        return $this->getDateTime()
                    ->format('Y-m-d H:i:s');
    }
}