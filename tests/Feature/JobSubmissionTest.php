<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class JobSubmissionTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    public function test_a_logged_in_user_can_apply_for_the_job(): void
    {
        $response = $this->post('/api/user/login',
        [
            
            "email"=> "shikharbhk69@gmail.com",
            "password"=> "123456789",            
    ]);

        $response->assertStatus(200);

        $response = $this->post('/api/user/add-job-submission/3',
        [
                "resume"=> "my_resume.pdf",
                "cover_letter"=> "test"
                     
    ]);

    //dd($response->json());

        $response->assertStatus(200);
    }
}
