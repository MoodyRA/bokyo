<?php

namespace App\Domain\Currency\Entity;

class Cryptocurrency extends Currency
{
    /** @var int */
    protected int $circulating_supply = 0;
    /** @var int */
    protected int $total_supply = 0;
    /** @var int */
    protected int $rank = 0;

    /**
     * @return int
     */
    public function getCirculatingSupply(): int
    {
        return $this->circulating_supply;
    }

    /**
     * @param int $circulating_supply
     * @return Cryptocurrency
     */
    public function setCirculatingSupply(int $circulating_supply): Cryptocurrency
    {
        $this->circulating_supply = $circulating_supply;
        return $this;
    }

    /**
     * @return int
     */
    public function getTotalSupply(): int
    {
        return $this->total_supply;
    }

    /**
     * @param int $total_supply
     * @return Cryptocurrency
     */
    public function setTotalSupply(int $total_supply): Cryptocurrency
    {
        $this->total_supply = $total_supply;
        return $this;
    }

    /**
     * @return int
     */
    public function getRank(): int
    {
        return $this->rank;
    }

    /**
     * @param int $rank
     * @return Cryptocurrency
     */
    public function setRank(int $rank): Cryptocurrency
    {
        $this->rank = $rank;
        return $this;
    }
}