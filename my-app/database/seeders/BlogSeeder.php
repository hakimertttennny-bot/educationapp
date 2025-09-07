<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class BlogSeeder extends Seeder
{
    public function run(): void
    {
        $blogs = [
            [
                'title' => 'The Future of Web Development: What to Expect in 2024',
                'slug' => 'future-web-development-2024',
                'excerpt' => 'Explore the latest trends and technologies that will shape web development in 2024 and beyond.',
                'content' => 'Web development is constantly evolving, and 2024 promises to bring exciting new technologies and methodologies. From AI-powered development tools to advanced CSS features, developers need to stay ahead of the curve.

Key trends to watch:
- AI-assisted coding and debugging
- WebAssembly for performance-critical applications
- Advanced CSS features like container queries
- Improved developer experience with better tooling

The future is bright for web developers who embrace these changes and continuously learn new skills.',
                'image' => 'https://images.unsplash.com/photo-1461749280684-dccba630e2f6?ixlib=rb-4.0.3&auto=format&fit=crop&w=2069&q=80',
                'author_id' => 1,
                'category_id' => 1,
                'tags' => json_encode(['Web Development', 'Technology', 'Trends', '2024']),
                'is_featured' => true,
                'is_published' => true,
                'published_at' => now(),
                'views_count' => 1250,
                'read_time' => 5
            ],
            [
                'title' => 'Getting Started with Machine Learning: A Beginner\'s Guide',
                'slug' => 'getting-started-machine-learning-beginners-guide',
                'excerpt' => 'A comprehensive guide for beginners who want to start their journey in machine learning.',
                'content' => 'Machine learning can seem intimidating at first, but with the right approach, anyone can learn it. This guide will walk you through the fundamentals and help you get started.

What you\'ll learn:
- Basic concepts and terminology
- Popular algorithms and their applications
- Tools and frameworks to use
- Real-world project ideas

Start your ML journey today with practical examples and hands-on exercises.',
                'image' => 'https://images.unsplash.com/photo-1551288049-bebda4e38f71?ixlib=rb-4.0.3&auto=format&fit=crop&w=1170&q=80',
                'author_id' => 2,
                'category_id' => 4,
                'tags' => json_encode(['Machine Learning', 'AI', 'Python', 'Beginner']),
                'is_featured' => true,
                'is_published' => true,
                'published_at' => now()->subDays(2),
                'views_count' => 980,
                'read_time' => 8
            ],
            [
                'title' => 'Design Principles Every UI/UX Designer Should Know',
                'slug' => 'design-principles-ui-ux-designer',
                'excerpt' => 'Essential design principles that will help you create better user experiences and interfaces.',
                'content' => 'Good design is not just about aesthetics; it\'s about creating experiences that users love. Understanding fundamental design principles is crucial for any UI/UX designer.

Key principles covered:
- Visual hierarchy and layout
- Color theory and psychology
- Typography and readability
- User-centered design thinking

Apply these principles to create more effective and engaging designs.',
                'image' => 'https://images.unsplash.com/photo-1561070791-2526d30994b5?ixlib=rb-4.0.3&auto=format&fit=crop&w=764&q=80',
                'author_id' => 3,
                'category_id' => 3,
                'tags' => json_encode(['UI/UX Design', 'Design Principles', 'User Experience']),
                'is_featured' => false,
                'is_published' => true,
                'published_at' => now()->subDays(5),
                'views_count' => 720,
                'read_time' => 6
            ],
            [
                'title' => 'Mobile App Development: Flutter vs React Native',
                'slug' => 'mobile-app-development-flutter-vs-react-native',
                'excerpt' => 'Compare Flutter and React Native to choose the best framework for your mobile app development project.',
                'content' => 'Choosing the right framework for mobile app development is crucial for project success. Both Flutter and React Native offer cross-platform development capabilities, but they have different strengths.

Comparison points:
- Performance and speed
- Development experience
- Community and ecosystem
- Learning curve
- Use cases and examples

Make an informed decision based on your project requirements and team expertise.',
                'image' => 'https://images.unsplash.com/photo-1512941937669-90a1b58e7e9c?ixlib=rb-4.0.3&auto=format&fit=crop&w=2070&q=80',
                'author_id' => 8,
                'category_id' => 2,
                'tags' => json_encode(['Mobile Development', 'Flutter', 'React Native', 'Comparison']),
                'is_featured' => false,
                'is_published' => true,
                'published_at' => now()->subDays(8),
                'views_count' => 650,
                'read_time' => 7
            ],
            [
                'title' => 'Digital Marketing Strategies for 2024',
                'slug' => 'digital-marketing-strategies-2024',
                'excerpt' => 'Effective digital marketing strategies that will help your business grow in 2024.',
                'content' => 'Digital marketing continues to evolve with new platforms and technologies. Stay ahead of the competition with these proven strategies for 2024.

Strategy highlights:
- Content marketing and SEO
- Social media marketing trends
- Email marketing automation
- Video marketing and live streaming
- Data-driven decision making

Implement these strategies to boost your online presence and drive results.',
                'image' => 'https://images.unsplash.com/photo-1460925895917-afdab827c52f?ixlib=rb-4.0.3&auto=format&fit=crop&w=1115&q=80',
                'author_id' => 5,
                'category_id' => 6,
                'tags' => json_encode(['Digital Marketing', 'Strategy', '2024', 'Business']),
                'is_featured' => false,
                'is_published' => true,
                'published_at' => now()->subDays(12),
                'views_count' => 890,
                'read_time' => 6
            ],
            [
                'title' => 'React.js Best Practices for 2024',
                'slug' => 'react-js-best-practices-2024',
                'excerpt' => 'Learn the latest React.js best practices to write cleaner, more maintainable code.',
                'content' => 'React.js has evolved significantly over the years. Stay up-to-date with the latest best practices to write better React applications.

Best practices covered:
- Component structure and organization
- State management patterns
- Performance optimization
- Testing strategies
- Code splitting and lazy loading

Follow these practices to build scalable and maintainable React applications.',
                'image' => 'https://images.unsplash.com/photo-1633356122544-f134324a6cee?ixlib=rb-4.0.3&auto=format&fit=crop&w=1170&q=80',
                'author_id' => 6,
                'category_id' => 1,
                'tags' => json_encode(['React', 'JavaScript', 'Best Practices', 'Web Development']),
                'is_featured' => false,
                'is_published' => true,
                'published_at' => now()->subDays(15),
                'views_count' => 1100,
                'read_time' => 8
            ],
            [
                'title' => 'Cybersecurity Essentials for Developers',
                'slug' => 'cybersecurity-essentials-developers',
                'excerpt' => 'Essential cybersecurity practices that every developer should implement in their applications.',
                'content' => 'Security should be a top priority for every developer. Learn essential cybersecurity practices to protect your applications and users.

Security practices:
- Input validation and sanitization
- Authentication and authorization
- Data encryption
- Secure coding practices
- Regular security audits

Implement these practices to build more secure applications.',
                'image' => 'https://images.unsplash.com/photo-1550751827-4bd374c3f58b?ixlib=rb-4.0.3&auto=format&fit=crop&w=1170&q=80',
                'author_id' => 7,
                'category_id' => 9,
                'tags' => json_encode(['Cybersecurity', 'Security', 'Development', 'Best Practices']),
                'is_featured' => false,
                'is_published' => true,
                'published_at' => now()->subDays(18),
                'views_count' => 580,
                'read_time' => 7
            ],
            [
                'title' => 'Cloud Computing Trends for 2024',
                'slug' => 'cloud-computing-trends-2024',
                'excerpt' => 'Explore the latest trends in cloud computing and how they will impact businesses in 2024.',
                'content' => 'Cloud computing continues to transform how businesses operate. Stay informed about the latest trends and technologies in the cloud space.

Trend highlights:
- Multi-cloud and hybrid cloud strategies
- Serverless computing growth
- Edge computing expansion
- AI and ML integration
- Sustainability and green computing

Understand these trends to make better cloud decisions for your business.',
                'image' => 'https://images.unsplash.com/photo-1451187580459-43490279c0fa?ixlib=rb-4.0.3&auto=format&fit=crop&w=1172&q=80',
                'author_id' => 10,
                'category_id' => 8,
                'tags' => json_encode(['Cloud Computing', 'AWS', 'Azure', 'Trends', '2024']),
                'is_featured' => false,
                'is_published' => true,
                'published_at' => now()->subDays(22),
                'views_count' => 420,
                'read_time' => 5
            ],
            [
                'title' => 'JavaScript ES2024 Features You Should Know',
                'slug' => 'javascript-es2024-features',
                'excerpt' => 'Discover the new features and improvements coming to JavaScript in ES2024.',
                'content' => 'JavaScript continues to evolve with new features and improvements. Stay updated with the latest ES2024 features to write better code.

New features:
- Array grouping methods
- Pipeline operator
- Record and tuple types
- Pattern matching
- Improved error handling

Learn these features to write more modern and efficient JavaScript code.',
                'image' => 'https://images.unsplash.com/photo-1627398242454-45a1465c2479?ixlib=rb-4.0.3&auto=format&fit=crop&w=1174&q=80',
                'author_id' => 4,
                'category_id' => 7,
                'tags' => json_encode(['JavaScript', 'ES2024', 'Web Development', 'Programming']),
                'is_featured' => false,
                'is_published' => true,
                'published_at' => now()->subDays(25),
                'views_count' => 950,
                'read_time' => 6
            ],
            [
                'title' => 'Building a Career in Tech: A Complete Guide',
                'slug' => 'building-career-tech-complete-guide',
                'excerpt' => 'A comprehensive guide to building a successful career in the technology industry.',
                'content' => 'The tech industry offers incredible opportunities for growth and success. Learn how to build a rewarding career in technology.

Career building tips:
- Choosing the right specialization
- Building a strong portfolio
- Networking and community involvement
- Continuous learning strategies
- Job search and interview preparation

Follow this guide to accelerate your tech career growth.',
                'image' => 'https://images.unsplash.com/photo-1522202176988-66273c2fd55f?ixlib=rb-4.0.3&auto=format&fit=crop&w=1171&q=80',
                'author_id' => 1,
                'category_id' => 5,
                'tags' => json_encode(['Career', 'Technology', 'Professional Development', 'Guide']),
                'is_featured' => false,
                'is_published' => true,
                'published_at' => now()->subDays(30),
                'views_count' => 780,
                'read_time' => 9
            ]
        ];

        foreach ($blogs as $blog) {
            DB::table('blogs')->insert($blog);
        }
    }
}
