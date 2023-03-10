<?php

namespace App\Interface\Repository;

use App\Entity\BookCategory;

interface BookCategoryRepositoryInterface
{
    /**
     * @return BookCategory[]
     */
    public function findAllSortedByTitle(): array;
    public function existsById(int $id): bool;
}
