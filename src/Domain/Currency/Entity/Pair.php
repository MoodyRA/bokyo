<?php

namespace App\Domain\Currency\Entity;

use App\Domain\Shared\Entity;

class Pair extends Entity
{
    /** @var string */
    protected string $name;
    /** @var Currency */
    protected Currency $baseCurrency;
    /** @var Currency */
    protected Currency $quoteCurrency;

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @param string $name
     * @return Pair
     */
    public function setName(string $name): Pair
    {
        $this->name = $name;
        return $this;
    }

    /**
     * @return Currency
     */
    public function getBaseCurrency(): Currency
    {
        return $this->baseCurrency;
    }

    /**
     * @param Currency $baseCurrency
     * @return Pair
     */
    public function setBaseCurrency(Currency $baseCurrency): Pair
    {
        $this->baseCurrency = $baseCurrency;
        return $this;
    }

    /**
     * @return Currency
     */
    public function getQuoteCurrency(): Currency
    {
        return $this->quoteCurrency;
    }

    /**
     * @param Currency $quoteCurrency
     * @return Pair
     */
    public function setQuoteCurrency(Currency $quoteCurrency): Pair
    {
        $this->quoteCurrency = $quoteCurrency;
        return $this;
    }
}