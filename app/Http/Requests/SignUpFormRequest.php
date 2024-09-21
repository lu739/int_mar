<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Password;

class SignUpFormRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'email' => ['required', 'email:dns', 'unique:users'],
            'password' => ['required', 'confirmed', Password::defaults()],
            'name' => ['required', 'min:1'],
        ];
    }

    protected function prepareForValidation()
    {
        $this->merge([
            'email' => str($this->email)
                ->squish()
                ->lower()
                ->value(),
        ]);
    }
}
