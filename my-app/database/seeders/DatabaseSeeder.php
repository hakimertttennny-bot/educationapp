<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            CategorySeeder::class,
            InstructorSeeder::class,
            CourseSeeder::class,
            TestimonialSeeder::class,
            BlogSeeder::class,
            TestUserSeeder::class,
            RoleBasedUserSeeder::class,
            AdminSeeder::class,
        ]);
    }
}
