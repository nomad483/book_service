<?php

namespace App\Interface\Service\ExceptionHandler;

interface ExceptionMappingResolverInterface
{
    public function __construct(array $mappings);

    public function resolve(string $throwableClass): ?ExceptionMappingInterface;
}
