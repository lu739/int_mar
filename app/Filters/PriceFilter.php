<?php

namespace App\Filters;

use App\Models\Product;
use Domain\Catalog\Filters\AbstractFilter;
use Illuminate\Contracts\Database\Eloquent\Builder;

class PriceFilter extends AbstractFilter
{

    public function title(): string
    {
        return 'Цена';
    }

    public function key(): string
    {
        return 'price';
    }

    public function apply(Builder $query): Builder
    {
        return $query->when($this->requestValue(), function (Builder $q) {
            $q->whereBetween($this->key(), [
                (int) $this->requestValue('from') ?? $this->values()['from'],
                (int) $this->requestValue('to') ?? $this->values()['to'],
            ]);
        });
    }

    public function values(): array
    {
        return [
            'from' => 0,
            'to' => Product::query()->max('price'),
        ];
    }

    public function view(): string
    {
        return 'catalog.filters.price';
    }
}
