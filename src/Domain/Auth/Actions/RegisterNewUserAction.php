<?php

namespace Domain\Auth\Actions;

use App\Models\User;
use Domain\Auth\Contracts\RegisterNewUserContract;
use Illuminate\Auth\Events\Registered;

class RegisterNewUserAction implements RegisterNewUserContract
{
    public function __invoke(string $name, string $email, string $password): void
    {
        $user = User::query()->create([
            'name' => $name,
            'email' => $email,
            'password' => bcrypt($password),
        ]);

        event(new Registered($user));

        auth()->login($user);
    }
}