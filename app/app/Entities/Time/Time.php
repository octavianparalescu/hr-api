<?php
declare(strict_types=1);

namespace App\Entities\Time;


use DateTime;

class Time extends TimeInterface
{
    public function getDateTime(): DateTime
    {
        // returns a fresh date time so the time is the actual time instead
        // of the moment of starting the script in case of long-running worker threads
        return new DateTime();
    }
}