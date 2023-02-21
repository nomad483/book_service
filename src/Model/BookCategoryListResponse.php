<?php

namespace App\Model;

readonly class BookCategoryListResponse
{
    /**
     * @var BookCategoryListItem[]
     */
    private array $items;

    /**
     * @param BookCategoryListItem[] $items
     */
    public function __construct(array $items)
    {
        $this->items = $items;
    }


    /**
     * @return BookCategoryListItem[]
     */
    public function getItems(): array
    {
        return $this->items;
    }

}
