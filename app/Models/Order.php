<?php

namespace App\Models;

use Domain\Order\Enums\OrderStatusEnum;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Support\Casts\PriceCast;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'delivery_type_id',
        'payment_method_id',
        'amount',
        'status',
    ];

    protected $casts = [
        'amount' => PriceCast::class,
    ];

    protected $attributes = [
        'status' => 'new',
    ];

    public function status(): Attribute
    {
        return Attribute::make(
            get: fn (string $value) => OrderStatusEnum::from($value)->createState($this),
        );
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function deliveryType()
    {
        return $this->belongsTo(DeliveryType::class);
    }

    public function paymentMethod()
    {
        return $this->belongsTo(PaymentMethod::class);
    }

    public function orderCustomer()
    {
        return $this->hasMany(OrderCustomer::class);
    }

    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }
}
