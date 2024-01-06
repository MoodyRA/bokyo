<?php

namespace App\Infrastructure\Repository\Http\Cryptocurrency\CoinCap\Transformer;

use App\Domain\Currency\Entity\Cryptocurrency;
use Moody\ValueObject\Identity\Uuid;

class CryptocurrencyFromAssetContentTransformer
{
    /**
     * @param array $data
     * @return Cryptocurrency
     */
    public static function transform(array $data): Cryptocurrency
    {
        $cryptocurrency = new Cryptocurrency(Uuid::generate(), $data['name'], $data['symbol']);
        $cryptocurrency->setRank($data['rank']);
        if (is_numeric($data['supply'])) {
            $cryptocurrency->setCirculatingSupply((int)$data['supply']);
            $cryptocurrency->setTotalSupply((int)$data['supply']);
        }
        if (is_numeric($data['maxSupply'])) {
            $cryptocurrency->setTotalSupply((int)$data['maxSupply']);
        }
        return $cryptocurrency;
    }
}