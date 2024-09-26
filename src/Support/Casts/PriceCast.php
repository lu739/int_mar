<?php

namespace Support\Casts;

use Illuminate\Contracts\Database\Eloquent\CastsAttributes;
use Support\ValueObjects\Price;

class PriceCast implements CastsAttributes
{

    public function get($model, $key, $value, $attributes)
    {
        return new Price($value);
    }


    public function set($model, $key, $value, $attributes)
    {
        if (!($value instanceof Price)) {
            $value = new Price($value);
        }

        return $value->raw();
    }
}
