<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class EmployerRegisterTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    public function test_employer_can_register(): void
    {
        $response = $this->post('/api/employer/register',
        [
            
            "name"=> "shikhar",
            "email"=> "shikharbhk69@gmail.com",
            "phone_number"=> "9864894584",
            "address"=> "pokhara",
            "company_name"=> "abcd",
            "company_address"=> "bijaypur",
            "password"=> "123456789"            
    ]);

        $response->assertStatus(200);
    }
}
