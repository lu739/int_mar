<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class LostPasswordFormRequest extends FormRequest
{
    public function authorize(): bool
    {
        return auth()->guest();
    }

    public function rules(): array
    {
        return [
            'email' => ['required', 'email:dns', 'exists:users,email'],
        ];
    }
}
