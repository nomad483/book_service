<?php

namespace App\Service\ExceptionHandler;

use App\Interface\Service\ExceptionHandler\ExceptionMappingInterface;

readonly class ExceptionMapping implements ExceptionMappingInterface
{
    public function __construct(private int $code, private bool $hidden, private bool $loggable)
    {
    }

    public static function fromCode(int $code): self
    {
        return new self($code, true, false);
    }

    public function getCode(): int
    {
        return $this->code;
    }

    public function isHidden(): bool
    {
        return $this->hidden;
    }

    public function isLoggable(): bool
    {
        return $this->loggable;
    }
}
