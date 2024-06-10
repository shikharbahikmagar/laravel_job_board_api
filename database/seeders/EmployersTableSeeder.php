<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class EmployersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $employersRecord = [
            ['id'=>1, 'name'=> 'shikhar', 'email'=> 'shikhar@gmail.com', 'phone_number'=> '123', 'address'=> 'pokhara',
            'company_name'=> 'abc', 'company_address'=> 'pokhara', 'password'=> '123'],
            ['id'=>2, 'name'=> 'abc', 'email'=> 'abc@gmail.com', 'phone_number'=> '123', 'address'=> 'pokhara',
            'company_name'=> 'abc', 'company_address'=> 'pokhara', 'password'=> '123']
        ];
        
        DB::table('employers')->insert($employersRecord);
    }
}
