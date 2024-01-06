<?php

namespace App\Domain\Currency\Collection;

use App\Domain\Currency\Entity\Cryptocurrency;
use Ramsey\Collection\AbstractCollection;

/**
 * @extends AbstractCollection<Cryptocurrency>
 */
class CryptocurrencyCollection extends AbstractCollection
{
    /**
     * @return string
     */
    public function getType(): string
    {
        return Cryptocurrency::class;
    }
}