<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Course;
use App\Models\UserCourse;
use App\Models\Instructor;
use App\Models\Category;

class StudentController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('student');
    }

    public function dashboard()
    {
        $user = Auth::user();

        $stats = [
            'enrolledCourses' => UserCourse::where('user_id', $user->id)->count(),
            'completedCourses' => UserCourse::where('user_id', $user->id)
                ->where('status', 'completed')->count(),
            'inProgressCourses' => UserCourse::where('user_id', $user->id)
                ->where('status', 'in_progress')->count(),
            'totalHours' => UserCourse::where('user_id', $user->id)
                ->join('courses', 'user_courses.course_id', '=', 'courses.id')
                ->sum('courses.duration_hours') ?? 0,
        ];

        $enrolledCourses = UserCourse::with(['course.instructor.user', 'course.category'])
            ->where('user_id', $user->id)
            ->latest()
            ->take(5)
            ->get();

        $recommendedCourses = Course::with(['instructor.user', 'category'])
            ->where('status', 'published')
            ->whereNotIn('id', UserCourse::where('user_id', $user->id)->pluck('course_id'))
            ->inRandomOrder()
            ->take(5)
            ->get();

        return response()->json([
            'success' => true,
            'stats' => $stats,
            'enrolledCourses' => $enrolledCourses,
            'recommendedCourses' => $recommendedCourses
        ]);
    }

    public function getCourses(Request $request)
    {
        $query = Course::with(['instructor.user', 'category'])
            ->where('status', 'published');

        if ($request->has('category_id')) {
            $query->where('category_id', $request->category_id);
        }

        if ($request->has('instructor_id')) {
            $query->where('instructor_id', $request->instructor_id);
        }

        if ($request->has('level')) {
            $query->where('level', $request->level);
        }

        if ($request->has('search')) {
            $query->where('title', 'like', '%' . $request->search . '%')
                  ->orWhere('description', 'like', '%' . $request->search . '%');
        }

        if ($request->has('price_range')) {
            switch ($request->price_range) {
                case 'free':
                    $query->where('price', 0);
                    break;
                case 'low':
                    $query->where('price', '>', 0)->where('price', '<=', 50);
                    break;
                case 'medium':
                    $query->where('price', '>', 50)->where('price', '<=', 100);
                    break;
                case 'high':
                    $query->where('price', '>', 100);
                    break;
            }
        }

        $courses = $query->paginate(12);

        return response()->json([
            'success' => true,
            'courses' => $courses
        ]);
    }

    public function getCourse($id)
    {
        $course = Course::with(['instructor.user', 'category', 'lessons'])
            ->where('status', 'published')
            ->findOrFail($id);

        $user = Auth::user();
        $enrollment = UserCourse::where('user_id', $user->id)
            ->where('course_id', $id)
            ->first();

        $relatedCourses = Course::with(['instructor.user', 'category'])
            ->where('status', 'published')
            ->where('category_id', $course->category_id)
            ->where('id', '!=', $id)
            ->take(4)
            ->get();

        return response()->json([
            'success' => true,
            'course' => $course,
            'enrollment' => $enrollment,
            'relatedCourses' => $relatedCourses
        ]);
    }

    public function enrollCourse(Request $request, $id)
    {
        $course = Course::where('status', 'published')->findOrFail($id);
        $user = Auth::user();

        // Check if already enrolled
        $existingEnrollment = UserCourse::where('user_id', $user->id)
            ->where('course_id', $id)
            ->first();

        if ($existingEnrollment) {
            return response()->json([
                'success' => false,
                'message' => 'You are already enrolled in this course'
            ], 400);
        }

        // Here you would typically handle payment processing
        // For now, we'll just create the enrollment
        $enrollment = UserCourse::create([
            'user_id' => $user->id,
            'course_id' => $id,
            'status' => 'enrolled',
            'progress' => 0,
            'enrolled_at' => now(),
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Successfully enrolled in course',
            'enrollment' => $enrollment
        ]);
    }

    public function getEnrolledCourses(Request $request)
    {
        $user = Auth::user();

        $query = UserCourse::with(['course.instructor.user', 'course.category'])
            ->where('user_id', $user->id);

        if ($request->has('status')) {
            $query->where('status', $request->status);
        }

        $enrollments = $query->paginate(15);

        return response()->json([
            'success' => true,
            'enrollments' => $enrollments
        ]);
    }

    public function updateProgress(Request $request, $courseId)
    {
        $user = Auth::user();
        
        $enrollment = UserCourse::where('user_id', $user->id)
            ->where('course_id', $courseId)
            ->firstOrFail();

        $request->validate([
            'progress' => 'required|integer|min:0|max:100',
            'status' => 'sometimes|in:enrolled,in_progress,completed'
        ]);

        $enrollment->update($request->only(['progress', 'status']));

        if ($request->has('status') && $request->status === 'completed') {
            $enrollment->update(['completed_at' => now()]);
        }

        return response()->json([
            'success' => true,
            'message' => 'Progress updated successfully',
            'enrollment' => $enrollment
        ]);
    }

    public function getInstructors(Request $request)
    {
        $query = Instructor::with(['user', 'courses'])
            ->where('is_verified', true);

        if ($request->has('specialization')) {
            $query->where('specialization', 'like', '%' . $request->specialization . '%');
        }

        if ($request->has('search')) {
            $query->whereHas('user', function($q) use ($request) {
                $q->where('name', 'like', '%' . $request->search . '%');
            });
        }

        $instructors = $query->paginate(12);

        return response()->json([
            'success' => true,
            'instructors' => $instructors
        ]);
    }

    public function getInstructor($id)
    {
        $instructor = Instructor::with(['user', 'courses.category'])
            ->where('is_verified', true)
            ->findOrFail($id);

        $courses = Course::with(['category'])
            ->where('instructor_id', $id)
            ->where('status', 'published')
            ->get();

        return response()->json([
            'success' => true,
            'instructor' => $instructor,
            'courses' => $courses
        ]);
    }

    public function followInstructor($id)
    {
        $user = Auth::user();
        $instructor = Instructor::findOrFail($id);

        // Check if already following
        $existingFollow = $user->followedInstructors()
            ->where('instructor_id', $id)
            ->first();

        if ($existingFollow) {
            return response()->json([
                'success' => false,
                'message' => 'You are already following this instructor'
            ], 400);
        }

        $user->followedInstructors()->attach($id);

        return response()->json([
            'success' => true,
            'message' => 'Successfully followed instructor'
        ]);
    }

    public function unfollowInstructor($id)
    {
        $user = Auth::user();
        $user->followedInstructors()->detach($id);

        return response()->json([
            'success' => true,
            'message' => 'Successfully unfollowed instructor'
        ]);
    }

    public function getCategories()
    {
        $categories = Category::withCount('courses')->get();

        return response()->json([
            'success' => true,
            'categories' => $categories
        ]);
    }

    public function getWishlist()
    {
        $user = Auth::user();
        $wishlist = $user->wishlist()->with(['instructor.user', 'category'])->get();

        return response()->json([
            'success' => true,
            'wishlist' => $wishlist
        ]);
    }

    public function addToWishlist($courseId)
    {
        $user = Auth::user();
        $course = Course::findOrFail($courseId);

        $user->wishlist()->attach($courseId);

        return response()->json([
            'success' => true,
            'message' => 'Course added to wishlist'
        ]);
    }

    public function removeFromWishlist($courseId)
    {
        $user = Auth::user();
        $user->wishlist()->detach($courseId);

        return response()->json([
            'success' => true,
            'message' => 'Course removed from wishlist'
        ]);
    }
}


