<?php
declare(strict_types=1);

namespace Tests\Stub\Time;

use App\Entities\Time\TimeInterface;
use DateTime;

class TimeStub implements TimeInterface
{
    private DateTime $dateTime;

    public function __construct(?DateTime $dateTime = null)
    {
        if ($dateTime) {
            $this->dateTime = $dateTime;
        } else {
            $this->dateTime = new DateTime();
        }
    }

    public function getDateTime(): DateTime
    {
        return $this->dateTime;
    }
}