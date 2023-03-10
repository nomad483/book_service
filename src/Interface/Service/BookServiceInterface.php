<?php

namespace App\Interface\Service;

use App\Model\BookDetails;
use App\Model\BookListResponse;
use App\Repository\BookCategoryRepository;
use App\Repository\BookRepository;
use App\Repository\ReviewRepository;

interface BookServiceInterface
{
    public function __construct(BookRepository $bookRepository, BookCategoryRepository $bookCategoryRepository, ReviewRepository $reviewRepository);

    public function getBookByCategory(int $categoryId): BookListResponse;

    public function getBookById(int $id): BookDetails;


}
