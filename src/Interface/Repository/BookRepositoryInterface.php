<?php

namespace App\Interface\Repository;

use App\Entity\Book;

interface BookRepositoryInterface
{

    /**
     *  @return Book[] Returns an array of Book objects
     */
    public function findBooksByCategoryId(int $id): array;

    public function getById(int $id): Book;
}
