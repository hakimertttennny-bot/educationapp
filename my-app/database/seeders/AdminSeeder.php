<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create default admin user
        User::create([
            'name' => 'Admin',
            'email' => 'admin@gmail.com',
            'password' => Hash::make('adminRR123#'),
            'role' => 'admin',
            'email_verified_at' => now(),
        ]);

        $this->command->info('Default admin user created successfully!');
        $this->command->info('Email: admin@gmail.com');
        $this->command->info('Password: adminRR123#');
    }
}
