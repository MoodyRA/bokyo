<?php

namespace App\Domain\Wallet\ValueObject;

use App\Domain\Currency\Entity\Cryptocurrency;

class WalletCryptocurrency
{
    /**
     * @param Cryptocurrency $cryptocurrency
     * @param float          $quantity
     */
    public function __construct(protected Cryptocurrency $cryptocurrency, protected float $quantity)
    {
    }

    /**
     * @return Cryptocurrency
     */
    public function getCryptocurrency(): Cryptocurrency
    {
        return $this->cryptocurrency;
    }

    /**
     * @param Cryptocurrency $cryptocurrency
     * @return $this
     */
    public function setCryptocurrency(Cryptocurrency $cryptocurrency): WalletCryptocurrency
    {
        $this->cryptocurrency = $cryptocurrency;
        return $this;
    }

    /**
     * @return float
     */
    public function getQuantity(): float
    {
        return $this->quantity;
    }

    /**
     * @param float $quantity
     * @return $this
     */
    public function setQuantity(float $quantity): WalletCryptocurrency
    {
        $this->quantity = $quantity;
        return $this;
    }
}