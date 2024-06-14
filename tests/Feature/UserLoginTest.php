<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class UserLoginTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    public function test_user_can_log_in(): void
    {
        $response = $this->post('/api/user/login',
        [
            
            "email"=> "shikharbhk69@gmail.com",
            "password"=> "123456789",            
    ]);

        $response->assertStatus(200);
    }
}
