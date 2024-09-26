<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Support\Casts\PriceCast;
use Support\Model\HasSlug;

class Product extends Model
{
    use HasFactory;
    use HasSlug;

    protected $fillable = [
        'slug',
        'title',
        'thumbnail',
        'price',
        'brand_id',
        'on_home_page',
        'sorting',
    ];

    protected $casts = [
        'price' => PriceCast::class
    ];


    public function brand()
    {
        return $this->belongsTo(Brand::class);
    }

    public function categories()
    {
        return $this->belongsToMany(Category::class);
    }

    public function scopeHomePage(Builder $query)
    {
        $query
            ->where('on_home_page', true)
            ->orderBy('sorting', 'asc')
            ->limit(6);
    }
    public function scopeFiltered(Builder $query)
    {
        $query
            ->when(request('filters.brands'), function (Builder $query) {
                $query->whereIn('brand_id', request('filters.brands'));
            })
            ->when(request('filters.price'), function (Builder $query) {
                $query->whereBetween('price', [
                    request('filters.price.from', 0),
                    request('filters.price.to')
                ]);
            });
    }
    public function scopeSorted(Builder $query)
    {
        $query
            ->when(request('sort'), function (Builder $query) {
                $column = request()->str('sort');

                if ($column->contains(['price', 'title'])) {
                    $direction = $column->contains('-') ? 'desc' : 'asc';

                    $query->orderBy($column, $direction);
                }
            });
    }
}
