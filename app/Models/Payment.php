<?php

namespace App\Models;

use Domain\Order\States\Payment\PaymentState;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\ModelStates\HasStates;

class Payment extends Model
{
    use HasFactory;
    use HasUuids;
    use HasStates;

    protected $fillable = [
        'payment_gateway',
        'payment_id',
        'meta',
    ];

    protected $casts = [
        'meta' => 'collection',
        'state' => PaymentState::class,
    ];

    public function uniqueIds()
    {
        return ['payment_id'];
    }
}
