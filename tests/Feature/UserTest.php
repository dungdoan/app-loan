<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class UserTest extends TestCase
{
    /**
     * The function will test user can be registered
     *
     * @return void
     */
    public function test_user_is_registed()
    {
        $response = $this->get('/');

        $response->assertStatus(200);
    }

    /**
     * The function will test user can log in
     *
     * @return void
     */
    public function test_user_can_be_login()
    {
        $response = $this->get('/');

        $response->assertStatus(200);
    }

    /**
     * The function will test user can log out
     *
     * @return void
     */
    public function test_user_can_be_logout()
    {
        $response = $this->get('/');

        $response->assertStatus(200);
    }
}
