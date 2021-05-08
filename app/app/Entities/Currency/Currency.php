<?php
declare(strict_types=1);

namespace App\Entities\Currency;


use App\Entities\Contract\HasKey;

class Currency implements HasKey
{
    private CurrencyKey $key;
    private string $name;
    private string $code;

    public function __construct(CurrencyKey $key, string $code, string $name)
    {
        $this->key = $key;
        $this->name = $name;
        $this->code = $code;
    }

    /**
     * @return CurrencyKey
     */
    public function getKey(): CurrencyKey
    {
        return $this->key;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @return string
     */
    public function getCode(): string
    {
        return $this->code;
    }
}