<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class TestUserSeeder extends Seeder
{
    public function run(): void
    {
        $users = [
            [
                'name' => 'John Doe',
                'email' => 'john@example.com',
                'password' => Hash::make('password123'),
                'phone' => '+1 (555) 123-4567',
                'role' => 'student',
                'bio' => 'Passionate learner and technology enthusiast',
                'website' => 'https://johndoe.dev',
                'is_active' => true
            ],
            [
                'name' => 'Jane Smith',
                'email' => 'jane@example.com',
                'password' => Hash::make('password123'),
                'phone' => '+1 (555) 987-6543',
                'role' => 'student',
                'bio' => 'Web developer and design enthusiast',
                'website' => 'https://janesmith.dev',
                'is_active' => true
            ],
            [
                'name' => 'Admin User',
                'email' => 'admin@eduweb.com',
                'password' => Hash::make('admin123'),
                'phone' => '+1 (555) 000-0000',
                'role' => 'admin',
                'bio' => 'System administrator',
                'website' => null,
                'is_active' => true
            ]
        ];

        foreach ($users as $user) {
            DB::table('users')->insert($user);
        }
    }
}
