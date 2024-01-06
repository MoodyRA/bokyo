<?php

namespace App\Domain\Shared\Exception;

use Throwable;

class RepositoryException extends DomainException
{
    /**
     * @param string         $message
     * @param array          $options
     * @param Throwable|null $previous
     */
    public function __construct(string $message = "", array $options = [], ?Throwable $previous = null)
    {
        parent::__construct($message, 0, $options, $previous);
    }
}