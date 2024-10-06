<?php

namespace App\Http\Requests;

use Domain\Order\Rules\PhoneRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Password;

class OrderFormRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    protected function prepareForValidation()
    {
        $this->merge([
            'create_account' => $this->boolean('create_account'),
        ]);
    }

    public function rules(): array
    {
        return [
            'customer.first_name' => 'required',
            'customer.last_name' => 'required',
            'customer.phone' => [new PhoneRule()],
            'customer.email' => 'required|email:dns',
            'customer.address' => 'nullable|required_if:delivery_type_id,2',
            'customer.city' => 'nullable|required_if:delivery_type_id,2',
            'create_account' => 'boolean',
            // 'customer.password' => request()->boolean('create_account')
            //     ? 'required|confirmed|min:8'
            //     : 'nullable',
            'delivery_type_id' => 'required|exists:delivery_types,id',
            'payment_method_id' => 'required|exists:payment_methods,id',
        ];
    }

    public function messages(): array
    {
        return [
            'customer.password.required' => 'Поле «Пароль» обязательно для заполнения',
            'customer.password.confirmed' => 'Пароли не совпадают',
            'customer.password.min' => 'Пароль должен содержать не менее 8 символов',
        ];
    }
}
