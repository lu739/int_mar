<?php

namespace Domain\Auth\DTOs;

use Illuminate\Http\Request;

class NewUserDTO
{
    public function __construct(
        public readonly string $name,
        public readonly string $email,
        public readonly string $password
    )
    {
    }

    public static function fromRequest(Request $request): self
    {
        return new self(
            name: $request->input('name'),
            email: $request->input('email'),
            password: $request->input('password'),
        );
    }
}
