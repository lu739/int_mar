<?php

namespace Tests\Feature\Auth\Actions;

use Domain\Auth\Actions\RegisterNewUserAction;
use Domain\Auth\DTOs\NewUserDTO;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class RegisterNewUserActionTest extends TestCase
{
    use RefreshDatabase;

    public function test_sucess_user_created()
    {
        $action = app(RegisterNewUserAction::class);
        $email = 'durov@vk.com';

        $this->assertDatabaseMissing('users', [
            'email' => $email,
        ]);

        $action(new NewUserDTO(
            $name = 'test',
            $email = $email,
            $password = '123454321',
        ));

        $this->assertDatabaseHas('users', [
            'name' => $name,
            'email' => $email,
        ]);
    }
}
