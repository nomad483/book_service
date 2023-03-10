<?php

namespace App\Tests\Repository;

use App\Entity\Book;
use App\Entity\BookCategory;
use App\Repository\BookRepository;
use App\Tests\AbstractRepositoryTest;
use Doctrine\Common\Collections\ArrayCollection;

class BookRepositoryTest extends AbstractRepositoryTest
{
    private BookRepository $bookRepository;

    protected function setUp(): void
    {
        parent::setUp();

        $this->bookRepository = $this->getRepositoryForEntity(Book::class);
    }

    public function testFindBooksByCategoryId()
    {
        $devicesCategory = (new BookCategory())->setTitle('Devices')->setSlug('devices');
        $this->em->persist($devicesCategory);

        for ($i = 0; $i < 10; ++$i) {
            $book = $this->createBook("device{$i}", $devicesCategory);
            $this->em->persist($book);
        }

        $this->em->flush();

        $this->assertCount(10, $this->bookRepository->findBooksByCategoryId($devicesCategory->getId()));
    }

    private function createBook(string $title, BookCategory $category): Book
    {
        return (new Book())
            ->setTitle($title)
            ->setSlug($title)
            ->setPublicationDate(new \DateTimeImmutable())
            ->setDescription('test description')
            ->setIsbn('123456')
            ->setCategories(new ArrayCollection([$category]))
            ->setMeep(false)
            ->setAuthors(['author'])
            ->setImage("http://localhost/{$title}.png");
    }
}
