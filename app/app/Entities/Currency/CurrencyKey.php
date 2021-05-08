<?php
declare(strict_types=1);

namespace App\Entities\Currency;


use App\Entities\Contract\Key;

class CurrencyKey implements Key
{
    private int $currencyId;

    public function __construct(int $currencyId)
    {
        $this->currencyId = $currencyId;
    }

    public function __toString()
    {
        return (string) $this->getCurrencyId();
    }

    /**
     * @return int
     */
    public function getCurrencyId(): int
    {
        return $this->currencyId;
    }
}