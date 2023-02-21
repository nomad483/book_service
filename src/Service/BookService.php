<?php

namespace App\Service;

use App\Entity\Book;
use App\Exception\BookCategoryNotFoundException;
use App\Model\BookListItem;
use App\Model\BookListResponse;
use App\Repository\BookCategoryRepository;
use App\Repository\BookRepository;

readonly class BookService
{
    public function __construct(
        private BookRepository $bookRepository,
        private BookCategoryRepository $bookCategoryRepository,
    ) {
    }

    public function getBookByCategory(int $categoryId): BookListResponse
    {
        if (!$this->bookCategoryRepository->existsById($categoryId)) {
            throw new BookCategoryNotFoundException();
        }

        return new BookListResponse(array_map(
            [$this, 'map'],
            $this->bookRepository->findBooksByCategoryId($categoryId)
        ));
    }

    private function map(Book $book): BookListItem
    {
        return (new BookListItem())
            ->setId($book->getId())
            ->setTitle($book->getTitle())
            ->setAuthors($book->getAuthors())
            ->setSlug($book->getSlug())
            ->setPublicationDate($book->getPublicationDate()->getTimestamp())
            ->setImage($book->getImage())
            ->setMeep($book->isMeep());
    }
}
