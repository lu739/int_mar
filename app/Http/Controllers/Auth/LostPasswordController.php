<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\LostPasswordFormRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Password;

class LostPasswordController extends Controller
{

    public function page()
    {
        return view('auth.lost-password');
    }

    public function handle(LostPasswordFormRequest $request): RedirectResponse
    {
        $status = Password::sendResetLink(
            $request->only('email')
        );

        if ($status === Password::RESET_LINK_SENT) {
            flash()->info(__($status));
        }

        return back()->withErrors(['email' => __($status)]);
    }
}
