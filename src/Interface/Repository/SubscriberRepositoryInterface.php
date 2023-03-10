<?php

namespace App\Interface\Repository;

interface SubscriberRepositoryInterface
{
    public function existsByEmail(string $email): bool;
}
