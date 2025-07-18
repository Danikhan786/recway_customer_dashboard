<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Seed specific user
        // User::create([
        //     'name' => 'Saqlain',
        //     'company' => 'My Company',
        //     'cost_place' => 'Main Office',
        //     'email' => 'msaqlain955@gmail.com',
        //     'phone' => '123-456-7890',
        //     'password' => Hash::make('123'), // Hashed password
        //     'statuses' => 'active',
        //     'send_security_report' => 1,
        //     'report_delete_duration' => 7,
        //     'groups' => 'admin,staff',
        //     'reg_email' => 'msaqlain955@gmail.com',
        //     'parent_id' => null,
        //     'dep_id' => 1,
        //     'interview_template' => 1,
        //     'interviewed' => 0,
        //     'remainder_email' => 'msaqlain955@gmail.com',
        //     'remainder_email_template' => 'Default Template',
        //     'sent_email' => 1,
        // ]);

        // Seed another specific user
        User::create([
            'name' => 'Shayan Haider',
            'company' => 'My Company',
            'cost_place' => 'Main Office',
            'email' => 'shayanhaider7777@gmail.com',
            'phone' => '123-456-7890',
            'password' => Hash::make('123'), // Hashed password
            'statuses' => 'active',
            'send_security_report' => 1,
            'report_delete_duration' => 7,
            'groups' => 'admin,staff',
            'reg_email' => 'shayanhaider7777@gmail.com',
            'parent_id' => null,
            'dep_id' => 1,
            'interview_template' => 1,
            'interviewed' => 0,
            'remainder_email' => 'shayanhaider7777@gmail.com',
            'remainder_email_template' => 'Default Template',
            'sent_email' => 1,
        ]);

        // Seed random users
        User::factory()->count(10)->create();  // Generate 10 random users
    }
}
