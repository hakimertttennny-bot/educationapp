<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Instructor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rules\Password;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
            'role' => 'required|in:student,instructor,admin'
        ]);

        if (Auth::attempt($request->only('email', 'password'))) {
            $user = Auth::user();
            
            // Check if user role matches the requested role
            if ($user->role !== $request->role) {
                Auth::logout();
                return response()->json([
                    'success' => false,
                    'message' => 'Invalid role for this account. Please select the correct role.'
                ], 401);
            }
            
            $token = $user->createToken('auth-token')->plainTextToken;

            return response()->json([
                'success' => true,
                'message' => 'Login successful',
                'user' => $user,
                'token' => $token
            ]);
        }

        return response()->json([
            'success' => false,
            'message' => 'Invalid credentials'
        ], 401);
    }

    public function signup(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'role' => 'required|in:student,instructor,admin',
            'password' => ['required', 'confirmed', Password::defaults()],
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:5120' // 5MB max
        ]);

        // Handle image upload
        $imagePath = null;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('profile-images', 'public');
        }

        // Create user
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => $request->role,
            'avatar' => $imagePath
        ]);

        // If user is instructor, create instructor profile
        if ($request->role === 'instructor') {
            Instructor::create([
                'user_id' => $user->id,
                'specialization' => 'General',
                'experience_years' => 0,
                'is_verified' => false
            ]);
        }

        // Generate token
        $token = $user->createToken('auth-token')->plainTextToken;

        return response()->json([
            'success' => true,
            'message' => 'Account created successfully',
            'user' => $user,
            'token' => $token
        ], 201);
    }

    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();

        return response()->json([
            'success' => true,
            'message' => 'Logged out successfully'
        ]);
    }

    public function user(Request $request)
    {
        $user = $request->user();
        
        return response()->json([
            'success' => true,
            'user' => $user
        ]);
    }

    public function updateProfile(Request $request)
    {
        $user = $request->user();

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
            'phone' => 'nullable|string|max:20',
            'bio' => 'nullable|string|max:1000',
            'website' => 'nullable|url|max:255',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:5120'
        ]);

        $data = $request->only(['name', 'email', 'phone', 'bio', 'website']);

        // Handle image upload
        if ($request->hasFile('image')) {
            // Delete old image if exists
            if ($user->avatar && Storage::disk('public')->exists($user->avatar)) {
                Storage::disk('public')->delete($user->avatar);
            }
            
            $imagePath = $request->file('image')->store('profile-images', 'public');
            $data['avatar'] = $imagePath;
        }

        $user->update($data);

        return response()->json([
            'success' => true,
            'message' => 'Profile updated successfully',
            'user' => $user
        ]);
    }

    public function changePassword(Request $request)
    {
        $request->validate([
            'current_password' => 'required|current_password',
            'new_password' => ['required', 'confirmed', Password::defaults()]
        ]);

        $user = $request->user();
        $user->update([
            'password' => Hash::make($request->new_password)
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Password changed successfully'
        ]);
    }
}
