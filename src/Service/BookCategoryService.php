<?php

namespace App\Service;

use App\Entity\BookCategory;
use App\Interface\Service\BookCategoryServiceInterface;
use App\Model\BookCategory as BookCategoryModel;
use App\Model\BookCategoryListResponse;
use App\Repository\BookCategoryRepository;

readonly class BookCategoryService implements BookCategoryServiceInterface
{
    public function __construct(private BookCategoryRepository $bookCategoryRepository)
    {
    }

    public function getCategories(): BookCategoryListResponse
    {
        $categories = $this->bookCategoryRepository->findAllSortedByTitle();

        $items = array_map(
            fn (BookCategory $bookCategory) => new BookCategoryModel(
                $bookCategory->getId(),
                $bookCategory->getTitle(),
                $bookCategory->getSlug()
            ),
            $categories
        );

        return new BookCategoryListResponse($items);
    }
}
