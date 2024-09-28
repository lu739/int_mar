<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Pipeline\Pipeline;
use Laravel\Scout\Searchable;
use Support\Casts\PriceCast;
use Support\Model\HasSlug;
use Laravel\Scout\Attributes\SearchUsingFullText;
use Laravel\Scout\Attributes\SearchUsingPrefix;


class Product extends Model
{
    use HasFactory;
    use HasSlug;
    use Searchable;

    protected $fillable = [
        'slug',
        'title',
        'thumbnail',
        'price',
        'brand_id',
        'on_home_page',
        'sorting',
        'text',
    ];

    protected $casts = [
        'price' => PriceCast::class
    ];

    #[SearchUsingPrefix(['id'])]
    #[SearchUsingFullText(['title', 'text'])]
    public function toSearchableArray()
    {
        return [
            'id' => (int) $this->id,
            'title' => $this->title,
            'text' => $this->text,
        ];
    }


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
        return app(Pipeline::class)
            ->send($query)
            ->through(filters())
            ->thenReturn();
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
