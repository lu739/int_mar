<?php

namespace App\Models;

use App\Jobs\ProductJsonPropertiesJob;
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
        'json_properties',
        'quantity',
    ];

    protected $casts = [
        'price' => PriceCast::class,
        'json_properties' => 'array'
    ];

    protected static function boot()
    {
        parent::boot();

        self::created(function (self $product) {
            ProductJsonPropertiesJob::dispatch($product)->delay(now()->addSeconds(10));
        });
    }

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

    public function properties()
    {
        return $this->belongsToMany(Property::class)
            ->withPivot('value');
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
        sorter()->run($query);
    }
}
