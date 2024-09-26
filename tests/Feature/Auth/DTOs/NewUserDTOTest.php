<?php

namespace Tests\Feature\Auth\DTOs;

use App\Http\Requests\SignUpFormRequest;
use Domain\Auth\DTOs\NewUserDTO;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class NewUserDTOTest extends TestCase
{
    use RefreshDatabase;

    public function test_instance_created_from_request()
    {
        $dto = NewUserDTO::fromRequest(new SignUpFormRequest([
            'name' => 'test',
            'email' => 'durov@vk.com',
            'password' => '123454321',
        ]));

        $this->assertInstanceOf(NewUserDTO::class, $dto);
    }
}
