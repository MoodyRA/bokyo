<?php

namespace App\Domain\Shared;

use Moody\ValueObject\Identity\Uuid;

abstract class Entity
{
    /**
     * @param Uuid $uuid
     */
    public function __construct(protected Uuid $uuid)
    {
    }

    /**
     * @return Uuid
     */
    public function getUuid(): Uuid
    {
        return $this->uuid;
    }

    /**
     * @param Uuid $uuid
     * @return self
     */
    public function setUuid(Uuid $uuid): self
    {
        $this->uuid = $uuid;
        return $this;
    }
}