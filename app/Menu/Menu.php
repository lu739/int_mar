<?php

namespace App\Menu;

use Illuminate\Database\Eloquent\Collection;

class Menu
{
    protected array $items = [];

    public function __construct(MenuItem ...$items)
    {
        $this->items = $items;
    }

    public function all(): Collection
    {
        return Collection::make($this->items);
    }

    public function add(MenuItem $item): self
    {
        $this->items[] = $item;

        return $this;
    }
    public function addIf(bool|callable $condition, MenuItem $item): self
    {
        if (is_callable($condition) ? $condition() : $condition) {
            return $this->add($item);
        }

        return $this;
    }

    public function remove(MenuItem $item): self
    {
        $this->items = array_filter($this->items, function ($i) use ($item) {
            return $i !== $item;
        });

        return $this;
    }
}
