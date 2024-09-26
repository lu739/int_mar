<?php

namespace Tests\Feature\App\Http\Controllers\Auth;

use App\Http\Controllers\Auth\ResetPasswordController;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Password;
use Tests\TestCase;

class ResetPasswordControllerTest extends TestCase
{
    use refreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        $this->token = '123456';
    }

    public function test_is_password_reset_page_success()
    {
        $response = $this->get(action([ResetPasswordController::class, 'page'], $this->token));

        $response->assertOk()
            ->assertViewIs('auth.reset-password');
    }

    public function test_is_reset_password_success()
    {
        $password = '123454321';
        $password_confirmation = '123454321';

        Password::shouldReceive('reset')
            ->once()
            ->withSomeOfArgs([
                'email' => 'durov@vk.com',
                'password' => $password,
                'password_confirmation' => $password_confirmation,
                'token' => $this->token,
            ])
            ->andReturn(Password::PASSWORD_RESET);

        $response = $this->post(
            action([ResetPasswordController::class, 'handle']),
            [
                'email' => 'durov@vk.com',
                'password' => $password,
                'password_confirmation' => $password_confirmation,
                'token' => $this->token
            ]
        );

        $response->assertRedirect('/');
    }
}
