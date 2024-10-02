<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Str;
use Laravel\Socialite\Facades\Socialite;
use Support\SessionRegenerator;
use Throwable;

class SocialiteController extends Controller
{
    public function redirect(string $driver)
    {
        try {
            return Socialite::driver($driver)->redirect();
        } catch (Throwable $e) {
            throw new \DomainException('Ошибка, драйвер не поддерживается');
        }
    }

    public function callback(string $driver) {
        $githubUser = Socialite::driver($driver)->user();

        $user = User::query()->updateOrCreate([
            $driver . '_id' => $githubUser->id,
        ], [
            'name' => $githubUser->name ?? $githubUser->nickname,
            'email' => $githubUser->email,
            'password' => bcrypt(Str::random(10)),
        ]);

        SessionRegenerator::run(session()->getId(), function () use ($user) {
            auth()->login($user);
        });

        return redirect()->intended('/');
    }
}
