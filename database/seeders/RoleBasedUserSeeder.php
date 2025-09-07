<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Instructor;
use Illuminate\Support\Facades\Hash;

class RoleBasedUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create Admin User
        $admin = User::create([
            'name' => 'Admin User',
            'email' => 'admin@example.com',
            'password' => Hash::make('password'),
            'role' => 'admin',
            'phone' => '+1234567890',
            'bio' => 'Platform administrator with full access to all features.',
            'website' => 'https://admin.example.com',
            'is_active' => true,
        ]);

        // Create Instructor User
        $instructor = User::create([
            'name' => 'Dr. Sarah Johnson',
            'email' => 'instructor@example.com',
            'password' => Hash::make('password'),
            'role' => 'instructor',
            'phone' => '+1234567891',
            'bio' => 'Experienced web development instructor with 10+ years of teaching experience.',
            'website' => 'https://sarahjohnson.dev',
            'is_active' => true,
        ]);

        // Create Instructor Profile
        Instructor::create([
            'user_id' => $instructor->id,
            'specialization' => 'Web Development',
            'experience_years' => 10,
            'is_verified' => true,
        ]);

        // Create Student User
        $student = User::create([
            'name' => 'John Student',
            'email' => 'student@example.com',
            'password' => Hash::make('password'),
            'role' => 'student',
            'phone' => '+1234567892',
            'bio' => 'Passionate learner interested in web development and programming.',
            'website' => null,
            'is_active' => true,
        ]);

        // Create Additional Instructor
        $instructor2 = User::create([
            'name' => 'Michael Chen',
            'email' => 'michael@example.com',
            'password' => Hash::make('password'),
            'role' => 'instructor',
            'phone' => '+1234567893',
            'bio' => 'Data science and machine learning expert with industry experience.',
            'website' => 'https://michaelchen.ai',
            'is_active' => true,
        ]);

        // Create Instructor Profile
        Instructor::create([
            'user_id' => $instructor2->id,
            'specialization' => 'Data Science & ML',
            'experience_years' => 8,
            'is_verified' => true,
        ]);

        // Create Additional Student
        $student2 = User::create([
            'name' => 'Emily Rodriguez',
            'email' => 'emily@example.com',
            'password' => Hash::make('password'),
            'role' => 'student',
            'phone' => '+1234567894',
            'bio' => 'Creative designer learning to code and build digital products.',
            'website' => null,
            'is_active' => true,
        ]);

        $this->command->info('Role-based users created successfully!');
        $this->command->info('Admin: admin@example.com / password');
        $this->command->info('Instructor: instructor@example.com / password');
        $this->command->info('Student: student@example.com / password');
    }
}


