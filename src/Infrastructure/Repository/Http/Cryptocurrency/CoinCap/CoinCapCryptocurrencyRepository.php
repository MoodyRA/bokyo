<?php

namespace App\Infrastructure\Repository\Http\Cryptocurrency\CoinCap;

use App\Domain\Currency\Collection\CryptocurrencyCollection;
use App\Domain\Currency\Entity\Cryptocurrency;
use App\Domain\Currency\Repository\CryptocurrencyRepositoryInterface;
use App\Domain\Shared\Exception\RepositoryException;
use App\Infrastructure\Repository\Http\Cryptocurrency\CoinCap\Transformer\CryptocurrencyFromAssetContentTransformer;
use Moody\ValueObject\Identity\Uuid;
use Symfony\Contracts\HttpClient\Exception\ExceptionInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class CoinCapCryptocurrencyRepository implements CryptocurrencyRepositoryInterface
{
    private const string url = 'https://api.coincap.io/v2';

    public function __construct(private HttpClientInterface $api)
    {
    }

    public function findAll(): CryptocurrencyCollection
    {
        $cryptocurrencies = new CryptocurrencyCollection();
        try {
            $limit = 2000;
            $offset = 0;
            $continue = true;
            while ($continue) {
                $continue = false;
                $response = $this->api->request(
                    'GET',
                    $this::url . '/assets',
                    [
                        'query' => [
                            'offset' => $offset,
                            'limit' => $limit
                        ]
                    ]
                );
                $content = $response->toArray(false);
                if (!empty($content['data'])) {
                    foreach ($content['data'] as $row) {
                        $cryptocurrencies->add(CryptocurrencyFromAssetContentTransformer::transform($row));
                    }
                    $continue = true;
                }

                if ($response->getStatusCode() >= 400) {
                    throw new RepositoryException(
                        "Error finding Cryptocurrencies form CoinCap API",
                        ['response_content' => $response->getContent(false)]
                    );
                }
                $offset += $limit;
            }
        } catch (ExceptionInterface $e) {
            throw new RepositoryException(
                "Error finding Cryptocurrencies form CoinCap API",
                [],
                $e
            );
        }
        return $cryptocurrencies;
    }
}