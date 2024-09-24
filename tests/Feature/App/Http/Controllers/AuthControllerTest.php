<?php

namespace Tests\Feature\App\Http\Controllers;

use App\Http\Controllers\Auth\SignInController;
use App\Http\Controllers\Auth\SignUpController;
use App\Http\Requests\SignInFormRequest;
use App\Http\Requests\SignUpFormRequest;
use App\Listeners\SendEmailNewUserListener;
use App\Models\User;
use App\Notifications\NewUserNotification;
use Illuminate\Auth\Events\Registered;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Notification;
use Tests\TestCase;

class AuthControllerTest extends TestCase
{
    use refreshDatabase;

    public function test_is_register_page_success()
    {
        $response = $this->get(action([SignUpController::class, 'page']));

        $response->assertOk()
            ->assertViewIs('auth.register');
    }

    public function test_is_register_success()
    {
        Notification::fake();
        Event::fake();

        $request = SignUpFormRequest::factory()
            ->create([
                'email' => 'durov@vk.com',
                'password' => '123454321',
                'password_confirmation' => '123454321',
            ]);

        $this->assertDatabaseMissing('users', ['email' => $request['email']]);

        $response = $this->post(
            action([SignUpController::class, 'handle']),
            $request
        );
        $response->assertValid();

        $this->assertDatabaseHas('users', ['email' => $request['email']]);

        $response->assertRedirect('/');

        $user = User::where('email', $request['email'])->first();

        Event::assertDispatched(Registered::class);
        Event::assertListening(Registered::class, SendEmailNewUserListener::class);

        $event = new Registered($user);
        $listener = new SendEmailNewUserListener();
        $listener->handle($event);

        Notification::assertSentTo(
            $user,
            NewUserNotification::class
        );

        $this->assertAuthenticatedAs($user);
    }

    public function test_is_login_page_success()
    {
        $response = $this->get(action([SignInController::class, 'page']));

        $response->assertOk()
            ->assertViewIs('auth.login');
    }

    public function test_is_login_success()
    {
        $password = '123454321';
        $email = 'durov@vk.com';

        $user = User::factory()->create([
            'email' => $email,
            'name' => 'Durov Pavel',
            'password' => bcrypt($password),
        ]);

        $this->assertDatabaseHas('users', ['email' => $email]);

        $request = SignInFormRequest::factory()
            ->create([
                'email' => $email,
                'password' => $password,
            ]);

        $response = $this->post(
            action([SignInController::class, 'handle']),
            $request
        );
        $response->assertValid();

        $response->assertRedirect('/');

        $this->assertAuthenticatedAs($user);
    }

    public function test_is_logout_success()
    {
        $password = '123454321';
        $email = 'durov@vk.com';

        $user = User::factory()->create([
            'email' => $email,
            'name' => 'Durov Pavel',
            'password' => bcrypt($password),
        ]);

        $response = $this
            ->actingAs($user)
            ->delete(
            action([SignInController::class, 'logout']),
        );

        $response->assertRedirect(route('home'));

        $this->assertGuest();
    }
}
