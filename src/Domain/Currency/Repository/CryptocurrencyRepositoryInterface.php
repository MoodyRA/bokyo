<?php

namespace App\Domain\Currency\Repository;

use App\Domain\Currency\Collection\CryptocurrencyCollection;
use App\Domain\Shared\Exception\RepositoryException;

interface CryptocurrencyRepositoryInterface
{
    /**
     * @return CryptocurrencyCollection
     * @throws RepositoryException
     */
    public function findAll(): CryptocurrencyCollection;
}