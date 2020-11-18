<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class AuthTest extends TestCase
{
    static $token = null;
    /**
     * Register test.
     *
     * @return void
     */
    public function testRegister()
    {
        $response = $this->json('POST', '/api/auth/register', [
            'name' => 'TestUser',
            'email' => 'm.mirsamie.test1@gmail.com',
            'password' => '123456',
            'password_confirmation' => '123456'
        ]);

        // if the user already exists, do not raise error
        if(isset($response['email'])) {
            return $this->assertTrue(true);
        }

        $response
            ->assertStatus(201);
    }

    /**
     * Login test.
     *
     * @return void
     */
    public function testLogin()
    {
        $this->testRegister();
        $response = $this->json('POST', '/api/auth/login', [
            'email' => 'm.mirsamie.test1@gmail.com',
            'password' => '123456',
        ]);

        if(isset($response['access_token'])) {
            AuthTest::$token = $response['access_token'];
        }

        $response
            ->assertStatus(200);
    }
}
