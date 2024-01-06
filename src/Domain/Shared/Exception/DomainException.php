<?php

namespace App\Domain\Shared\Exception;

use Throwable;

abstract class DomainException extends \Exception
{
    /**
     * @param string         $message
     * @param int            $code
     * @param array          $options
     * @param Throwable|null $previous
     */
    public function __construct(
        string $message = "",
        int $code = 0,
        protected array $options = [],
        ?Throwable $previous = null
    ) {
        parent::__construct($message, $code, $previous);
    }

    /**
     * @return array
     */
    public function getOptions(): array
    {
        return $this->options;
    }

    /**
     * @param array $options
     * @return $this
     */
    public function setOptions(array $options): DomainException
    {
        $this->options = $options;
        return $this;
    }

    /**
     * @param string $key
     * @param mixed  $value
     * @return $this
     */
    public function addOption(string $key, mixed $value): DomainException
    {
        $this->options[$key] = $value;
        return $this;
    }
}