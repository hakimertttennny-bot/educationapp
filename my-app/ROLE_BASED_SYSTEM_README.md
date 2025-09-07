# Role-Based Authentication System

This Laravel application implements a comprehensive role-based authentication system with three user roles: **Admin**, **Instructor**, and **Student**.

## Features

### 🔐 Authentication & Authorization
- **Login/Signup**: Users can register and login with email/password
- **Role-based Access Control**: Different functionality based on user role
- **Middleware Protection**: Routes are protected by role-specific middleware

### 👨‍💼 Admin Role
- **Dashboard**: Overview of platform statistics (students, instructors, courses, revenue)
- **User Management**: Create, edit, delete users and manage roles
- **Course Management**: Review and manage all platform courses
- **Platform Oversight**: Monitor overall platform performance

### 👨‍🏫 Instructor Role
- **Dashboard**: Course and student statistics
- **Course Management**: Create, edit, delete, and publish courses
- **Student Tracking**: Monitor student enrollments and progress
- **Profile Management**: Update instructor-specific information

### 👨‍🎓 Student Role
- **Dashboard**: Learning progress and achievements
- **Course Discovery**: Browse and search available courses
- **Enrollment**: Enroll in courses (with payment integration ready)
- **Progress Tracking**: Track learning progress and completion
- **Instructor Following**: Follow favorite instructors
- **Wishlist**: Save courses for later

## API Endpoints

### Authentication
```
POST /api/login          - User login
POST /api/signup         - User registration
POST /api/logout         - User logout
GET  /api/user           - Get current user info
PUT  /api/profile        - Update user profile
PUT  /api/password      - Change password
```

### Admin Routes (Protected by admin middleware)
```
GET    /api/admin/dashboard           - Admin dashboard stats
GET    /api/admin/users              - List all users
POST   /api/admin/users              - Create new user
PUT    /api/admin/users/{id}         - Update user
DELETE /api/admin/users/{id}         - Delete user
GET    /api/admin/courses            - List all courses
PUT    /api/admin/courses/{id}       - Update course
DELETE /api/admin/courses/{id}       - Delete course
```

### Instructor Routes (Protected by instructor middleware)
```
GET    /api/instructor/dashboard     - Instructor dashboard stats
GET    /api/instructor/courses       - List instructor's courses
POST   /api/instructor/courses       - Create new course
PUT    /api/instructor/courses/{id}  - Update course
DELETE /api/instructor/courses/{id}  - Delete course
GET    /api/instructor/enrollments   - List student enrollments
GET    /api/instructor/categories    - List course categories
GET    /api/instructor/profile       - Get instructor profile
PUT    /api/instructor/profile       - Update instructor profile
```

### Student Routes (Protected by student middleware)
```
GET    /api/student/dashboard              - Student dashboard stats
GET    /api/student/courses                - Browse available courses
GET    /api/student/courses/{id}           - View course details
POST   /api/student/courses/{id}/enroll    - Enroll in course
GET    /api/student/enrolled-courses       - List enrolled courses
PUT    /api/student/courses/{courseId}/progress - Update learning progress
GET    /api/student/instructors            - Browse instructors
GET    /api/student/instructors/{id}       - View instructor profile
POST   /api/student/instructors/{id}/follow    - Follow instructor
DELETE /api/student/instructors/{id}/follow     - Unfollow instructor
GET    /api/student/categories             - List course categories
GET    /api/student/wishlist               - Get wishlist
POST   /api/student/wishlist/{courseId}    - Add course to wishlist
DELETE /api/student/wishlist/{courseId}    - Remove course from wishlist
```

## Database Structure

### Users Table
- `id`, `name`, `email`, `password`
- `role` (enum: 'student', 'instructor', 'admin')
- `phone`, `avatar`, `bio`, `website`, `linkedin`, `twitter`
- `is_active` (boolean)

### Instructors Table
- `id`, `user_id` (foreign key to users)
- `specialization`, `experience_years`
- `is_verified` (boolean)

### User-Course Relationships
- `user_courses` table for enrollments
- `user_instructor_follows` table for following instructors
- `user_wishlist` table for saved courses

## Setup Instructions

### 1. Install Dependencies
```bash
composer install
npm install
```

### 2. Environment Setup
```bash
cp .env.example .env
php artisan key:generate
```

### 3. Database Setup
```bash
php artisan migrate
php artisan db:seed
```

### 4. Create Test Users
```bash
php artisan db:seed --class=RoleBasedUserSeeder
```

### 5. Start Development Server
```bash
php artisan serve
npm run dev
```

## Test Accounts

After running the seeder, you can test the system with these accounts:

### Admin User
- **Email**: admin@example.com
- **Password**: password
- **Access**: Full platform management

### Instructor User
- **Email**: instructor@example.com
- **Password**: password
- **Access**: Course creation and management

### Student User
- **Email**: student@example.com
- **Password**: password
- **Access**: Course browsing and enrollment

## Frontend Integration

The Vue.js frontend automatically detects user roles and displays appropriate content:

- **Admin Dashboard**: Shows platform statistics and management actions
- **Instructor Dashboard**: Shows course statistics and management tools
- **Student Dashboard**: Shows learning progress and course recommendations

## Security Features

- **CSRF Protection**: All forms are protected against CSRF attacks
- **Role Validation**: Middleware ensures users can only access role-appropriate routes
- **Input Validation**: All API endpoints validate input data
- **Authentication Required**: Protected routes require valid authentication

## Customization

### Adding New Roles
1. Add the role to the `role` enum in the users migration
2. Create role-specific middleware
3. Add role-specific routes and controllers
4. Update the frontend to handle the new role

### Adding New Features
1. Create the necessary database migrations
2. Add API endpoints in the appropriate controller
3. Update the frontend components
4. Test with different user roles

## Payment Integration

The system is designed to support payment processing for course enrollments. The `enrollCourse` endpoint in the StudentController is ready for payment gateway integration.

## Future Enhancements

- **Email Notifications**: Course updates, enrollment confirmations
- **File Uploads**: Course materials, user avatars
- **Real-time Chat**: Student-instructor communication
- **Analytics Dashboard**: Detailed learning analytics
- **Mobile App**: React Native or Flutter mobile application

## Support

For questions or issues with the role-based system, please refer to the Laravel documentation or create an issue in the project repository.


