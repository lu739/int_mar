<?php

namespace Domain\Catalog\Filters;

class FilterManager
{
    public function __construct(
        protected array $items = []
    )
    {
    }


    public function registerFilters(array $items): void
    {
        $this->items = $items;
    }

    public function filters(): array
    {
        return $this->items;
    }
}
