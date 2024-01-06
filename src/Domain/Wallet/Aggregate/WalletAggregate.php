<?php

namespace App\Domain\Wallet\Aggregate;

use App\Domain\Wallet\Collection\WalletCryptocurrencyCollection;
use App\Domain\Wallet\Entity\Wallet;

class WalletAggregate
{
    /**
     * @param Wallet                              $wallet
     * @param WalletCryptocurrencyCollection|null $cryptocurrencies
     */
    public function __construct(
        protected Wallet $wallet,
        protected ?WalletCryptocurrencyCollection $cryptocurrencies = null
    ) {
        if ($this->cryptocurrencies === null) {
            $this->cryptocurrencies = new WalletCryptocurrencyCollection();
        }
    }
}