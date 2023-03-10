<?php

namespace App\Interface\Service;

use App\Model\ReviewPage;

interface ReviewServiceInterface
{
    public function getReviewPageByBookId(int $id, int $page): ReviewPage;
}
