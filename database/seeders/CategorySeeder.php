<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            [
                'name' => 'Web Development',
                'slug' => 'web-development',
                'description' => 'Learn modern web development with the latest technologies like React, Vue, and Node.js.',
                'icon' => 'code-slash-outline',
                'color' => '#3B82F6',
                'courses_count' => 15,
                'sort_order' => 1
            ],
            [
                'name' => 'Mobile Development',
                'slug' => 'mobile-development',
                'description' => 'Build mobile apps for iOS and Android platforms using Flutter, React Native, and Swift.',
                'icon' => 'phone-portrait-outline',
                'color' => '#10B981',
                'courses_count' => 12,
                'sort_order' => 2
            ],
            [
                'name' => 'UI/UX Design',
                'slug' => 'ui-ux-design',
                'description' => 'Create beautiful and functional user interfaces with modern design tools and principles.',
                'icon' => 'color-palette-outline',
                'color' => '#F59E0B',
                'courses_count' => 8,
                'sort_order' => 3
            ],
            [
                'name' => 'Data Science',
                'slug' => 'data-science',
                'description' => 'Master data analysis and machine learning with Python, R, and advanced analytics tools.',
                'icon' => 'analytics-outline',
                'color' => '#8B5CF6',
                'courses_count' => 20,
                'sort_order' => 4
            ],
            [
                'name' => 'Business & Marketing',
                'slug' => 'business-marketing',
                'description' => 'Learn business strategies, digital marketing, and entrepreneurship skills.',
                'icon' => 'business-outline',
                'color' => '#EF4444',
                'courses_count' => 10,
                'sort_order' => 5
            ],
            [
                'name' => 'Digital Marketing',
                'slug' => 'digital-marketing',
                'description' => 'Master SEO, social media marketing, content marketing, and digital advertising.',
                'icon' => 'trending-up-outline',
                'color' => '#06B6D4',
                'courses_count' => 14,
                'sort_order' => 6
            ],
            [
                'name' => 'Programming Languages',
                'slug' => 'programming-languages',
                'description' => 'Learn Python, JavaScript, Java, C++, and other programming languages.',
                'icon' => 'code-outline',
                'color' => '#84CC16',
                'courses_count' => 18,
                'sort_order' => 7
            ],
            [
                'name' => 'Cloud Computing',
                'slug' => 'cloud-computing',
                'description' => 'Master AWS, Azure, Google Cloud, and cloud infrastructure management.',
                'icon' => 'cloud-outline',
                'color' => '#F97316',
                'courses_count' => 9,
                'sort_order' => 8
            ],
            [
                'name' => 'Cybersecurity',
                'slug' => 'cybersecurity',
                'description' => 'Learn ethical hacking, network security, and cybersecurity best practices.',
                'icon' => 'shield-checkmark-outline',
                'color' => '#DC2626',
                'courses_count' => 7,
                'sort_order' => 9
            ],
            [
                'name' => 'Artificial Intelligence',
                'slug' => 'artificial-intelligence',
                'description' => 'Explore machine learning, deep learning, and AI applications.',
                'icon' => 'brain-outline',
                'color' => '#7C3AED',
                'courses_count' => 11,
                'sort_order' => 10
            ]
        ];

        foreach ($categories as $category) {
            DB::table('categories')->insert($category);
        }
    }
}
