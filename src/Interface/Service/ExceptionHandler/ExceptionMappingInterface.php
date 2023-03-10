<?php

namespace App\Interface\Service\ExceptionHandler;

interface ExceptionMappingInterface
{
    public function __construct(int $code, bool $hidden, bool $loggable);

    public static function fromCode(int $code): self;

    public function getCode(): int;

    public function isHidden(): bool;

    public function isLoggable(): bool;
}
