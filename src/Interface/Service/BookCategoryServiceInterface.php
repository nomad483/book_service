<?php

namespace App\Interface\Service;

use App\Model\BookCategoryListResponse;

interface BookCategoryServiceInterface
{
    public function getCategories(): BookCategoryListResponse;
}
