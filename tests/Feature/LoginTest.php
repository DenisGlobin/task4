<?php

namespace Tests\Feature\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\User;

class LoginTest extends TestCase
{
    protected $user;

    public function setUp(): void
    {
        parent::setUp();
        // Create a single App\User instance...
        $this->user = factory(User::class)->create([
            'password' => bcrypt('password'),
        ]);
    }

    public function testRequiresEmailAndLogin()
    {
        $this->json('POST', 'api/login')
            ->assertStatus(422)
            ->assertJson([
                'message' => 'The given data was invalid.',
                'errors' => [
                    'email' => ['The email field is required.'],
                    'password' => ['The password field is required.'],
                ],
            ]);
    }


    public function testUserLoginsSuccessfully()
    {
//        $user = factory(User::class)->create([
//            'email' => 'testlogin@user.com',
//            'password' => bcrypt('toptal123'),
//        ]);

//        $payload = ['email' => 'testlogin@user.com', 'password' => 'toptal123'];
        $payload = ['email' => $this->user->email, 'password' => 'password'];

        $this->json('POST', 'api/login', $payload)
            ->assertStatus(200)
            ->assertJsonStructure([
                'data' => [
                    'id',
                    'name',
                    'email',
                    'created_at',
                    'modify_at',
                    'api_token',
                ],
            ]);

    }
}
