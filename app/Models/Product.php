<?php

namespace App\Models;

use App\Traits\Model\HasSlug;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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
    ];


    public function brand()
    {
        return $this->belongsTo(Brand::class);
    }

    public function category()
    {
        return $this->belongsToMany(Category::class);
    }
}
