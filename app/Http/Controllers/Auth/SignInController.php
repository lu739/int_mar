<?php

namespace App\Http\Controllers\Auth;

use App\Events\AfterSessionRegeneratedEvent;
use App\Http\Controllers\Controller;
use App\Http\Requests\SignInFormRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Support\SessionRegenerator;

class SignInController extends Controller
{
    public function page()
    {
        return view('auth.login');
    }

    public function handle(SignInFormRequest $request): RedirectResponse
    {
        $credentials = $request->only('email', 'password');

        $currentSessionId = session()->getId();

        if (!Auth::attempt($credentials)) {
            return back()->withErrors([
                'email' => 'The provided credentials do not match our records.',
            ])->onlyInput('email');
        }

        SessionRegenerator::run($currentSessionId);

        return redirect()->intended('/');
    }

    public function logout()
    {
        SessionRegenerator::run(session()->getId(), function () {
            // request()->session()->invalidate();
            auth()->logout();
        });

        return redirect()->route('home');
    }
}
