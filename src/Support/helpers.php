<?php

use App\Models\Category;
use Domain\Catalog\Filters\FilterManager;
use Domain\Catalog\Sorter\Sorter;
use Support\Flash\Flash;

if (!function_exists('flash')) {

    function flash(): Flash
    {
        return app(Flash::class);
    }
}

if (!function_exists('filters')) {

    function filters(): array
    {
        return app(FilterManager::class)->filters();
    }
}

if (!function_exists('sorter')) {

    function sorter(): Sorter
    {
        return app(Sorter::class);
    }
}

if (!function_exists('is_catalog_view')) {

    function is_catalog_view(string $view): bool
    {
        return session('view', 'grid') === $view;
    }
}

if (!function_exists('filter_url')) {

    function filter_url(?Category $category, array $params = []): string
    {
        return route('catalog', [
                    'category' => $category,
                    ...request()->only('filters', 'sort'),
                    ...$params
                ]
        );
    }
}
