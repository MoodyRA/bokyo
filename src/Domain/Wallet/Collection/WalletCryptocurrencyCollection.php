<?php

namespace App\Domain\Wallet\Collection;

use App\Domain\Wallet\ValueObject\WalletCryptocurrency;
use Ramsey\Collection\AbstractCollection;

/**
 * @extends AbstractCollection<WalletCryptocurrency>
 */
class WalletCryptocurrencyCollection extends AbstractCollection
{
    /**
     * @return string
     */
    public function getType(): string
    {
        return WalletCryptocurrency::class;
    }
}