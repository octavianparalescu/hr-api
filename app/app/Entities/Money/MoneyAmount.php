<?php
declare(strict_types=1);

namespace App\Entities\Money;


use App\Entities\Currency\CurrencyKey;

class MoneyAmount
{
    private float $amount;
    private CurrencyKey $currencyKey;

    public function __construct(float $amount, CurrencyKey $currencyKey)
    {
        $this->amount = $amount;
        $this->currencyKey = $currencyKey;
    }

    /**
     * @return float
     */
    public function getAmount(): float
    {
        return $this->amount;
    }

    /**
     * @return CurrencyKey
     */
    public function getCurrencyKey(): CurrencyKey
    {
        return $this->currencyKey;
    }
}