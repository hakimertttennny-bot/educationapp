<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TestimonialSeeder extends Seeder
{
    public function run(): void
    {
        $testimonials = [
            [
                'name' => 'Sarah Johnson',
                'role' => 'Web Developer',
                'company' => 'TechCorp',
                'avatar' => 'https://images.unsplash.com/photo-1494790108755-2616b612b786?ixlib=rb-4.0.3&auto=format&fit=crop&w=687&q=80',
                'content' => 'EduWeb transformed my career! The web development course was comprehensive and practical. I landed my dream job within 3 months of completing the course.',
                'rating' => 5,
                'course_id' => 1,
                'is_featured' => true,
                'is_verified' => true
            ],
            [
                'name' => 'Michael Chen',
                'role' => 'Data Scientist',
                'company' => 'DataFlow Inc',
                'avatar' => 'https://images.unsplash.com/photo-1472099645785-5658abf4ff4e?ixlib=rb-4.0.3&auto=format&fit=crop&w=1170&q=80',
                'content' => 'The Python for Data Science course exceeded my expectations. The instructors are experts in their field and the hands-on projects were invaluable.',
                'rating' => 5,
                'course_id' => 2,
                'is_featured' => true,
                'is_verified' => true
            ],
            [
                'name' => 'Emily Rodriguez',
                'role' => 'UI/UX Designer',
                'company' => 'Design Studio',
                'avatar' => 'https://images.unsplash.com/photo-1438761681033-6461ffad8d80?ixlib=rb-4.0.3&auto=format&fit=crop&w=1170&q=80',
                'content' => 'As someone with no design background, the UI/UX course was perfect. I learned everything from basic principles to advanced prototyping techniques.',
                'rating' => 4,
                'course_id' => 4,
                'is_featured' => false,
                'is_verified' => true
            ],
            [
                'name' => 'David Thompson',
                'role' => 'Mobile Developer',
                'company' => 'AppWorks',
                'avatar' => 'https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?ixlib=rb-4.0.3&auto=format&fit=crop&w=687&q=80',
                'content' => 'The Flutter course was exactly what I needed to transition into mobile development. The instructor explained complex concepts clearly.',
                'rating' => 5,
                'course_id' => 3,
                'is_featured' => false,
                'is_verified' => true
            ],
            [
                'name' => 'Lisa Wang',
                'role' => 'Digital Marketing Manager',
                'company' => 'Growth Marketing',
                'avatar' => 'https://images.unsplash.com/photo-1544005313-94ddf0286df2?ixlib=rb-4.0.3&auto=format&fit=crop&w=688&q=80',
                'content' => 'The digital marketing fundamentals course gave me the skills I needed to advance in my career. Highly recommend for anyone in marketing.',
                'rating' => 4,
                'course_id' => 5,
                'is_featured' => false,
                'is_verified' => true
            ],
            [
                'name' => 'Alex Kumar',
                'role' => 'Frontend Developer',
                'company' => 'Web Solutions',
                'avatar' => 'https://images.unsplash.com/photo-1500648767791-00dcc994a43e?ixlib=rb-4.0.3&auto=format&fit=crop&w=687&q=80',
                'content' => 'The React.js course was comprehensive and up-to-date with the latest features. I use the skills I learned every day at work.',
                'rating' => 5,
                'course_id' => 6,
                'is_featured' => true,
                'is_verified' => true
            ],
            [
                'name' => 'Maria Garcia',
                'role' => 'Cybersecurity Analyst',
                'company' => 'SecureNet',
                'avatar' => 'https://images.unsplash.com/photo-1534528741775-53994a69daeb?ixlib=rb-4.0.3&auto=format&fit=crop&w=764&q=80',
                'content' => 'The cybersecurity course provided practical knowledge that I immediately applied in my new role. The instructor is a true expert.',
                'rating' => 5,
                'course_id' => 7,
                'is_featured' => false,
                'is_verified' => true
            ],
            [
                'name' => 'James Wilson',
                'role' => 'Machine Learning Engineer',
                'company' => 'AI Innovations',
                'avatar' => 'https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?ixlib=rb-4.0.3&auto=format&fit=crop&w=687&q=80',
                'content' => 'The machine learning course was challenging but rewarding. The projects were real-world applicable and helped me build a strong portfolio.',
                'rating' => 4,
                'course_id' => 8,
                'is_featured' => false,
                'is_verified' => true
            ],
            [
                'name' => 'Sophie Brown',
                'role' => 'Cloud Architect',
                'company' => 'CloudTech',
                'avatar' => 'https://images.unsplash.com/photo-1494790108755-2616b612b786?ixlib=rb-4.0.3&auto=format&fit=crop&w=687&q=80',
                'content' => 'The AWS course prepared me perfectly for the certification exam. The hands-on labs were crucial for understanding cloud concepts.',
                'rating' => 5,
                'course_id' => 9,
                'is_featured' => false,
                'is_verified' => true
            ],
            [
                'name' => 'Robert Lee',
                'role' => 'JavaScript Developer',
                'company' => 'CodeCraft',
                'avatar' => 'https://images.unsplash.com/photo-1472099645785-5658abf4ff4e?ixlib=rb-4.0.3&auto=format&fit=crop&w=1170&q=80',
                'content' => 'The JavaScript fundamentals course was perfect for beginners. Clear explanations and practical examples made learning enjoyable.',
                'rating' => 4,
                'course_id' => 10,
                'is_featured' => false,
                'is_verified' => true
            ]
        ];

        foreach ($testimonials as $testimonial) {
            DB::table('testimonials')->insert($testimonial);
        }
    }
}
