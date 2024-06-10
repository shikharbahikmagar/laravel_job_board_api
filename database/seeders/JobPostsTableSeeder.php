<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class JobPostsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $job_posts = [
            ['id' => 1, 'employer_id' => 3, 'job_title' => 'laravel developer', 'company_name' => 'abc', 'location' => 'bijaypur', 'skills' => 'laravel', 
            'experience' => '3 years', 'salary' => '20000', 'description' => 'only for senior developers', 'status'=> 1],

            ['id' => 2, 'employer_id' => 4, 'job_title' => 'react developer', 'company_name' => 'abc', 'location' => 'newroad, pokhara', 'skills' => 'react', 
            'experience' => '2 years', 'salary' => '20000', 'description' => 'only for senior developers', 'status'=> 1]
        ];

        DB::table('job_posts')->insert($job_posts);
    }
}
