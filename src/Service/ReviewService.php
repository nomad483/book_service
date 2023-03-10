<?php

namespace App\Service;

use App\Entity\Review;
use App\Interface\Service\ReviewServiceInterface;
use App\Model\Review as ReviewModel;
use App\Model\ReviewPage;
use App\Repository\ReviewRepository;

class ReviewService implements ReviewServiceInterface
{
    private const PAGE_LIMIT = 5;

    public function __construct(private readonly ReviewRepository $reviewRepository)
    {
    }

    public function getReviewPageByBookId(int $id, int $page): ReviewPage
    {
        $offset = max($page - 1, 0) * self::PAGE_LIMIT;

        $paginator = $this->reviewRepository->getPageByBookId($id, $offset, self::PAGE_LIMIT);
        $rating = 0;
        $total = count($paginator);

        if ($total > 0) {
            $rating = $this->reviewRepository->getBookTotalRatingSum($id) / $total;
        }


        return (new ReviewPage())
            ->setPage($page)
            ->setTotal($total)
            ->setRating($rating)
            ->setPerPage(self::PAGE_LIMIT)
            ->setPages(ceil($total / self::PAGE_LIMIT))
            ->setItems(array_map([$this, 'map'], $paginator->getIterator()->getArrayCopy()));
    }

    private function map(Review $review): ReviewModel
    {
        return (new ReviewModel())
            ->setId($review->getId())
            ->setContent($review->getContent())
            ->setAuthor($review->getAuthor())
            ->setCreatedAt($review->getCreatedAt()->getTimestamp())
            ->setRating($review->getRating());
    }
}
