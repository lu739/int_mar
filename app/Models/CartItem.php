<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Support\Casts\PriceCast;
use Support\ValueObjects\Price;

class CartItem extends Model
{
    use HasFactory;

    protected $primaryKey = 'id';
    protected $fillable = [
        'cart_id',
        'product_id',
        'quantity',
        'price'
    ];

    protected $casts = [
        'price' => PriceCast::class
    ];

    public function amount(): Attribute
    {
        return Attribute::make(
            get: fn () => new Price($this->price->raw() * $this->quantity)
        );
    }

    public function cart()
    {
        return $this->belongsTo(Cart::class);
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
