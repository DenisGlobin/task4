<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\User;

class LogoutTest extends TestCase
{
    public function testUserIsLoggedOutProperly()
    {
        $user = factory(User::class)->create(['email' => 'user@test.com']);
        $token = $user->generateToken();
        $headers = [
            'Authorization' => "Bearer $token",
            'Accept' => 'application/json',
            'Content-type' => 'application/json',
        ];

        $this->json('get', '/api/v1/document/page=1&perPage=20', [], $headers)->assertStatus(200);
        $this->json('post', '/api/logout', [], $headers)->assertStatus(200);

        $user = User::find($user->id);

        $this->assertEquals(null, $user->api_token);
    }

    public function testUserWithNullToken()
    {
        $user = factory(User::class)->create(['email' => 'user@test.com']);
        $token = $user->generateToken();
        $headers = [
            'Authorization' => "Bearer $token",
            'Accept' => 'application/json',
            'Content-type' => 'application/json',
        ];

        $user->api_token = null;
        $user->save();
//      ToDo: create GET route for registered users only
        $this->json('get', '/api/v1/document/page=1&perPage=20', [], $headers)->assertStatus(401);
    }
}
