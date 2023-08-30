<?php

namespace App\Repositories;

use Illuminate\Pagination\LengthAwarePaginator;
use stdClass;

class PaginationPresenter implements PaginationInterface
{
    /**
     * @var stdClass[]
     */
    private array $items;

    public function __construct(
        protected LengthAwarePaginator $paginator
    )
    {
        $this->resolveItems();
    }

    /**
     * @return stdClass[]
     */
    public function items(): array
    {
        return $this->items;
    }

    public function total(): int
    {
        return $this->paginator->total() ?? 0;
    }

    public function isFirstPage(): bool
    {
        return $this->paginator->onFirstPage();
    }

    public function isLastPage(): bool
    {
        return $this->paginator->onLastPage();
    }

    public function currentPage(): int
    {
        return $this->paginator->currentPage() ?? 1;
    }

    public function getNumberNextPage(): int
    {
        $currentPage = $this->paginator->currentPage(); 

        return $this->paginator->onLastPage() ? $currentPage : $currentPage + 1;
    }

    public function getNumberPreviousPage(): int
    {
        $currentPage = $this->paginator->currentPage();

        return $this->paginator->onFirstPage() ? 1 : $currentPage - 1;
    }

    private function resolveItems()
    {
        $response = [];

        foreach ($this->paginator->items() as $item) {
            $stdClassObject = new stdClass;
            foreach ($item->toArray() as $property => $value) {
                $stdClassObject->{$property} = $value;
            }

            $response[] = $stdClassObject;
        }

        $this->items = $response;
    }
}