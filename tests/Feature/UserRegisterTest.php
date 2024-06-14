<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class UserRegisterTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    public function test_user_can_register(): void
    {
        $response = $this->post('/api/user/register',
        [
            
            "name"=> "Shikhar thapa magar",
            "email"=> "shikharbhk69@gmail.com",
            "password"=> "123456789",
            "confirm_password"=> "123456789"            
    ]);

        $response->assertStatus(200);
    }
}
