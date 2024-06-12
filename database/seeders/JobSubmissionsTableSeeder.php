<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class JobSubmissionsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $job_submissions = [
            ['id' => 1, 'user_id' => 1, 'employer_id' => 3, 'job_post_id' => 1, 'resume'=>'resume.pdf', 'cover_letter'=>'test', 'approval_status' => 'pending'],

            ['id' => 2, 'user_id' => 2, 'employer_id' => 3, 'job_post_id' => 3, 'resume'=>'resume.pdf', 'cover_letter'=>'test', 'approval_status' => 'pending']
        ];

        DB::table('job_submissions')->insert($job_submissions);
    }
}
