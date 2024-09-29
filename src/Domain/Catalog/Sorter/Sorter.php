<?php

namespace Domain\Catalog\Sorter;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Stringable;


class Sorter
{
    public const SORT_KEY = 'sort';

    public function __construct(protected array $columns = [])
    {
    }

    public function columns(): array
    {
       return $this->columns;
    }

    public function run(Builder $query): Builder
    {
        return $query->when($this->sortData()->contains($this->columns), function (Builder $query) {
            $column = $this->sortData();
            $direction = $column->contains('-') ? 'desc' : 'asc';

            $query->orderBy($column->remove('-'), $direction);
        });
    }

    public function sortData(): Stringable
    {
        return request()->str(self::SORT_KEY);
    }

    public function isActive($column, $direction = 'asc'): bool
    {
        $column = trim($column, '-');

        if (strtolower($direction) === 'desc') {
            $column = '-' . $column;
        }

        return request()->get(self::SORT_KEY) === $column;
    }
}
