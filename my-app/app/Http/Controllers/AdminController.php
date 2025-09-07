<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use App\Models\User;
use App\Models\Course;
use App\Models\Category;
use Illuminate\Support\Facades\DB;

class AdminController extends Controller
{
    public function dashboard()
    {
        try {
            // Get platform statistics
            $stats = [
                'totalStudents' => User::where('role', 'student')->count(),
                'totalInstructors' => User::where('role', 'instructor')->count(),
                'totalCourses' => Course::count(),
                'totalRevenue' => Course::sum('price')
            ];

            // Get recent users
            $recentUsers = User::with('courses')
                ->orderBy('created_at', 'desc')
                ->limit(10)
                ->get();

            // Get all courses with instructor info
            $courses = Course::with(['instructor', 'category'])
                ->withCount('students')
                ->orderBy('created_at', 'desc')
                ->get();

            return response()->json([
                'success' => true,
                'stats' => $stats,
                'recentUsers' => $recentUsers,
                'courses' => $courses
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error loading admin dashboard data: ' . $e->getMessage()
            ], 500);
        }
    }

    public function createUser(Request $request)
    {
        try {
            $request->validate([
                'name' => 'required|string|max:255',
                'email' => 'required|email|unique:users,email',
                'role' => 'required|in:student,instructor,admin',
                'password' => 'required|string|min:8',
                'phone' => 'nullable|string|max:20',
                'bio' => 'nullable|string|max:1000',
                'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:5120'
            ]);

            $userData = [
                'name' => $request->name,
                'email' => $request->email,
                'role' => $request->role,
                'password' => Hash::make($request->password),
                'phone' => $request->phone,
                'bio' => $request->bio
            ];

            // Handle image upload
            if ($request->hasFile('image')) {
                $imagePath = $request->file('image')->store('users', 'public');
                $userData['avatar'] = $imagePath;
            }

            $user = User::create($userData);

            return response()->json([
                'success' => true,
                'message' => 'User created successfully',
                'user' => $user
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error creating user: ' . $e->getMessage()
            ], 500);
        }
    }

    public function updateUser(Request $request, $id)
    {
        try {
            $user = User::findOrFail($id);

            $request->validate([
                'name' => 'required|string|max:255',
                'email' => 'required|email|unique:users,email,' . $id,
                'role' => 'required|in:student,instructor,admin',
                'phone' => 'nullable|string|max:20',
                'bio' => 'nullable|string|max:1000',
                'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:5120'
            ]);

            $userData = [
                'name' => $request->name,
                'email' => $request->email,
                'role' => $request->role,
                'phone' => $request->phone,
                'bio' => $request->bio
            ];

            // Handle image upload
            if ($request->hasFile('image')) {
                // Delete old image if exists
                if ($user->avatar && !str_starts_with($user->avatar, 'http')) {
                    Storage::disk('public')->delete($user->avatar);
                }
                
                $imagePath = $request->file('image')->store('users', 'public');
                $userData['avatar'] = $imagePath;
            }

            $user->update($userData);

            return response()->json([
                'success' => true,
                'message' => 'User updated successfully',
                'user' => $user
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error updating user: ' . $e->getMessage()
            ], 500);
        }
    }

    public function deleteUser($id)
    {
        try {
            $user = User::findOrFail($id);

            // Prevent admin from deleting themselves
            if ($user->id === auth()->id()) {
                return response()->json([
                    'success' => false,
                    'message' => 'You cannot delete your own account'
                ], 400);
            }

            // Delete user's avatar if exists
            if ($user->avatar && !str_starts_with($user->avatar, 'http')) {
                Storage::disk('public')->delete($user->avatar);
            }

            $user->delete();

            return response()->json([
                'success' => true,
                'message' => 'User deleted successfully'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error deleting user: ' . $e->getMessage()
            ], 500);
        }
    }

    public function getAllUsers(Request $request)
    {
        try {
            $query = User::query();

            // Apply role filter
            if ($request->has('role') && $request->role) {
                $query->where('role', $request->role);
            }

            // Apply search filter
            if ($request->has('search') && $request->search) {
                $search = $request->search;
                $query->where(function($q) use ($search) {
                    $q->where('name', 'like', "%{$search}%")
                      ->orWhere('email', 'like', "%{$search}%");
                });
            }

            $users = $query->with('courses')
                ->orderBy('created_at', 'desc')
                ->paginate(20);

            return response()->json([
                'success' => true,
                'users' => $users
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error fetching users: ' . $e->getMessage()
            ], 500);
        }
    }

    public function getUser($id)
    {
        try {
            $user = User::with(['courses', 'enrollments'])->findOrFail($id);

            return response()->json([
                'success' => true,
                'user' => $user
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error fetching user: ' . $e->getMessage()
            ], 500);
        }
    }

    public function deleteCourse($id)
    {
        try {
            $course = Course::findOrFail($id);

            // Delete course image if exists
            if ($course->image && !str_starts_with($course->image, 'http')) {
                Storage::disk('public')->delete($course->image);
            }

            $course->delete();

            return response()->json([
                'success' => true,
                'message' => 'Course deleted successfully'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error deleting course: ' . $e->getMessage()
            ], 500);
        }
    }

    public function getPlatformSettings()
    {
        try {
            // You can store these in a settings table or config file
            $settings = [
                'name' => config('app.name', 'EduWeb Platform'),
                'supportEmail' => config('mail.from.address', 'support@eduweb.com'),
                'maxFileSize' => config('filesystems.max_file_size', 10),
                'maintenanceMode' => config('app.maintenance_mode', false)
            ];

            return response()->json([
                'success' => true,
                'settings' => $settings
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error fetching platform settings: ' . $e->getMessage()
            ], 500);
        }
    }

    public function savePlatformSettings(Request $request)
    {
        try {
            $request->validate([
                'name' => 'required|string|max:255',
                'supportEmail' => 'required|email',
                'maxFileSize' => 'required|integer|min:1|max:100',
                'maintenanceMode' => 'required|boolean'
            ]);

            // In a real application, you would save these to a database or config file
            // For now, we'll just return success
            // You can implement actual saving logic here

            return response()->json([
                'success' => true,
                'message' => 'Platform settings saved successfully'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error saving platform settings: ' . $e->getMessage()
            ], 500);
        }
    }

    public function getCategories()
    {
        try {
            $categories = Category::all();

            return response()->json([
                'success' => true,
                'categories' => $categories
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error fetching categories: ' . $e->getMessage()
            ], 500);
        }
    }
}
