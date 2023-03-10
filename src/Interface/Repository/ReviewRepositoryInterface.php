<?php

namespace App\Interface\Repository;

use Doctrine\ORM\Tools\Pagination\Paginator;

interface ReviewRepositoryInterface
{
    public function countByBookId(int $id): int;
    public function getBookTotalRatingSum(int $id): int;
    public function getPageByBookId(int $id, int $offset, int $limit): Paginator;
}
