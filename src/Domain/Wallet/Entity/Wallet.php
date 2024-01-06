<?php

namespace App\Domain\Wallet\Entity;

use App\Domain\Shared\Entity;
use Moody\ValueObject\Identity\Uuid;

class Wallet extends Entity
{
    /**
     * @param Uuid   $uuid
     * @param string $name
     */
    public function __construct(Uuid $uuid, protected string $name)
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
     * @return $this
     */
    public function setName(string $name): Wallet
    {
        $this->name = $name;
        return $this;
    }
}