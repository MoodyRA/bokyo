<?php

namespace App\Domain\Currency\Collection;

use App\Domain\Currency\Entity\Pair;
use Ramsey\Collection\AbstractCollection;

/**
 * @extends AbstractCollection<Pair>
 */
class PairCollection extends AbstractCollection
{
    /**
     * @return string
     */
    public function getType(): string
    {
        return Pair::class;
    }

    /**
     * @return array
     */
    public function toArrayByBaseCurrencySymbol(): array
    {
        $byBaseCurrency = [];
        /** @var Pair $pair */
        foreach ($this as $pair) {
            $byBaseCurrency[$pair->getBaseCurrency()->getSymbol()][] = $pair;
        }
        return $byBaseCurrency;
    }
}