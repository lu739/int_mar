<?php

namespace Domain\Order\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class PhoneRule implements ValidationRule
{
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        if (!preg_match('/^(\+7|7|8)?[\s-]?\(?[489][0-9]{2}\)?[\s-]?[0-9]{3}[\s-]?[0-9]{2}[\s-]?[0-9]{2}$/', $value)) {
            $fail('Некорректный номер телефона');
        }
    }
}
