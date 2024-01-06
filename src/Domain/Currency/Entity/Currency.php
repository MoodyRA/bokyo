<?php

namespace App\Domain\Currency\Entity;

use App\Domain\Shared\Entity;
use Moody\ValueObject\Identity\Uuid;

class Currency extends Entity
{
    public function __construct(Uuid $uuid, protected string $name, protected string $symbol)
    {
        parent::__construct($uuid);
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @param string $name
     * @return Currency
     */
    public function setName(string $name): Currency
    {
        $this->name = $name;
        return $this;
    }

    /**
     * @return string
     */
    public function getSymbol(): string
    {
        return $this->symbol;
    }

    /**
     * @param string $symbol
     * @return Currency
     */
    public function setSymbol(string $symbol): Currency
    {
        $this->symbol = $symbol;
        return $this;
    }
}