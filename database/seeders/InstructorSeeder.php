<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class InstructorSeeder extends Seeder
{
    public function run(): void
    {
        $instructors = [
            [
                'name' => 'Dr. Sarah Johnson',
                'email' => 'sarah.johnson@eduweb.com',
                'bio' => 'Education expert with 15+ years in online learning and curriculum development. Former professor at Stanford University.',
                'avatar' => 'https://images.unsplash.com/photo-1494790108755-2616b612b786?ixlib=rb-4.0.3&auto=format&fit=crop&w=687&q=80',
                'title' => 'Senior Education Specialist',
                'company' => 'EduWeb',
                'expertise' => 'Web Development, JavaScript, React, Node.js',
                'website' => 'https://sarahjohnson.dev',
                'linkedin' => 'https://linkedin.com/in/sarahjohnson',
                'twitter' => 'https://twitter.com/sarahjohnson',
                'courses_count' => 8,
                'students_count' => 2500,
                'rating' => 4.9,
                'is_featured' => true
            ],
            [
                'name' => 'Michael Chen',
                'email' => 'michael.chen@eduweb.com',
                'bio' => 'Technology leader passionate about creating innovative learning platforms. Previously led engineering teams at Google and Microsoft.',
                'avatar' => 'https://images.unsplash.com/photo-1472099645785-5658abf4ff4e?ixlib=rb-4.0.3&auto=format&fit=crop&w=1170&q=80',
                'title' => 'CTO & Lead Instructor',
                'company' => 'EduWeb',
                'expertise' => 'Python, Data Science, Machine Learning',
                'website' => 'https://michaelchen.dev',
                'linkedin' => 'https://linkedin.com/in/michaelchen',
                'twitter' => 'https://twitter.com/michaelchen',
                'courses_count' => 12,
                'students_count' => 3800,
                'rating' => 4.8,
                'is_featured' => true
            ],
            [
                'name' => 'Emily Rodriguez',
                'email' => 'emily.rodriguez@eduweb.com',
                'bio' => 'Curriculum specialist dedicated to creating engaging educational experiences. Expert in instructional design and learning psychology.',
                'avatar' => 'https://images.unsplash.com/photo-1438761681033-6461ffad8d80?ixlib=rb-4.0.3&auto=format&fit=crop&w=1170&q=80',
                'title' => 'Head of Content',
                'company' => 'EduWeb',
                'expertise' => 'UI/UX Design, Figma, Adobe Creative Suite',
                'website' => 'https://emilyrodriguez.design',
                'linkedin' => 'https://linkedin.com/in/emilyrodriguez',
                'twitter' => 'https://twitter.com/emilyrodriguez',
                'courses_count' => 6,
                'students_count' => 1800,
                'rating' => 4.7,
                'is_featured' => false
            ],
            [
                'name' => 'David Thompson',
                'email' => 'david.thompson@eduweb.com',
                'bio' => 'Experienced educator with expertise in multiple programming languages. Has helped thousands of students transition into tech careers.',
                'avatar' => 'https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?ixlib=rb-4.0.3&auto=format&fit=crop&w=687&q=80',
                'title' => 'Lead Instructor',
                'company' => 'EduWeb',
                'expertise' => 'Java, C++, Software Engineering',
                'website' => 'https://davidthompson.dev',
                'linkedin' => 'https://linkedin.com/in/davidthompson',
                'twitter' => 'https://twitter.com/davidthompson',
                'courses_count' => 10,
                'students_count' => 3200,
                'rating' => 4.6,
                'is_featured' => false
            ],
            [
                'name' => 'Lisa Wang',
                'email' => 'lisa.wang@eduweb.com',
                'bio' => 'Digital marketing expert with 10+ years of experience in SEO, social media, and content marketing strategies.',
                'avatar' => 'https://images.unsplash.com/photo-1544005313-94ddf0286df2?ixlib=rb-4.0.3&auto=format&fit=crop&w=688&q=80',
                'title' => 'Marketing Specialist',
                'company' => 'EduWeb',
                'expertise' => 'Digital Marketing, SEO, Social Media',
                'website' => 'https://lisawang.marketing',
                'linkedin' => 'https://linkedin.com/in/lisawang',
                'twitter' => 'https://twitter.com/lisawang',
                'courses_count' => 5,
                'students_count' => 1500,
                'rating' => 4.5,
                'is_featured' => false
            ],
            [
                'name' => 'Alex Kumar',
                'email' => 'alex.kumar@eduweb.com',
                'bio' => 'Full-stack developer and instructor specializing in modern web technologies and cloud computing.',
                'avatar' => 'https://images.unsplash.com/photo-1500648767791-00dcc994a43e?ixlib=rb-4.0.3&auto=format&fit=crop&w=687&q=80',
                'title' => 'Senior Developer',
                'company' => 'EduWeb',
                'expertise' => 'React, Node.js, AWS, Docker',
                'website' => 'https://alexkumar.dev',
                'linkedin' => 'https://linkedin.com/in/alexkumar',
                'twitter' => 'https://twitter.com/alexkumar',
                'courses_count' => 7,
                'students_count' => 2100,
                'rating' => 4.8,
                'is_featured' => false
            ],
            [
                'name' => 'Maria Garcia',
                'email' => 'maria.garcia@eduweb.com',
                'bio' => 'Cybersecurity expert with extensive experience in ethical hacking and network security.',
                'avatar' => 'https://images.unsplash.com/photo-1534528741775-53994a69daeb?ixlib=rb-4.0.3&auto=format&fit=crop&w=764&q=80',
                'title' => 'Security Specialist',
                'company' => 'EduWeb',
                'expertise' => 'Cybersecurity, Ethical Hacking, Network Security',
                'website' => 'https://mariagarcia.security',
                'linkedin' => 'https://linkedin.com/in/mariagarcia',
                'twitter' => 'https://twitter.com/mariagarcia',
                'courses_count' => 4,
                'students_count' => 1200,
                'rating' => 4.9,
                'is_featured' => true
            ],
            [
                'name' => 'James Wilson',
                'email' => 'james.wilson@eduweb.com',
                'bio' => 'Mobile development expert specializing in iOS and Android app development with Flutter and React Native.',
                'avatar' => 'https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?ixlib=rb-4.0.3&auto=format&fit=crop&w=687&q=80',
                'title' => 'Mobile Developer',
                'company' => 'EduWeb',
                'expertise' => 'Flutter, React Native, iOS, Android',
                'website' => 'https://jameswilson.dev',
                'linkedin' => 'https://linkedin.com/in/jameswilson',
                'twitter' => 'https://twitter.com/jameswilson',
                'courses_count' => 6,
                'students_count' => 1800,
                'rating' => 4.7,
                'is_featured' => false
            ],
            [
                'name' => 'Sophie Brown',
                'email' => 'sophie.brown@eduweb.com',
                'bio' => 'AI and machine learning specialist with a focus on practical applications and real-world projects.',
                'avatar' => 'https://images.unsplash.com/photo-1494790108755-2616b612b786?ixlib=rb-4.0.3&auto=format&fit=crop&w=687&q=80',
                'title' => 'AI Researcher',
                'company' => 'EduWeb',
                'expertise' => 'Machine Learning, Deep Learning, TensorFlow, PyTorch',
                'website' => 'https://sophiebrown.ai',
                'linkedin' => 'https://linkedin.com/in/sophiebrown',
                'twitter' => 'https://twitter.com/sophiebrown',
                'courses_count' => 8,
                'students_count' => 2200,
                'rating' => 4.8,
                'is_featured' => true
            ],
            [
                'name' => 'Robert Lee',
                'email' => 'robert.lee@eduweb.com',
                'bio' => 'Cloud computing expert with certifications in AWS, Azure, and Google Cloud Platform.',
                'avatar' => 'https://images.unsplash.com/photo-1472099645785-5658abf4ff4e?ixlib=rb-4.0.3&auto=format&fit=crop&w=1170&q=80',
                'title' => 'Cloud Architect',
                'company' => 'EduWeb',
                'expertise' => 'AWS, Azure, Google Cloud, DevOps',
                'website' => 'https://robertlee.cloud',
                'linkedin' => 'https://linkedin.com/in/robertlee',
                'twitter' => 'https://twitter.com/robertlee',
                'courses_count' => 5,
                'students_count' => 1400,
                'rating' => 4.6,
                'is_featured' => false
            ]
        ];

        foreach ($instructors as $instructor) {
            DB::table('instructors')->insert($instructor);
        }
    }
}
