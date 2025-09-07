<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable, HasApiTokens;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'phone',
        'avatar',
        'role',
        'bio',
        'website',
        'linkedin',
        'twitter',
        'is_active',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function enrolledCourses()
    {
        return $this->hasMany(UserCourse::class);
    }

    public function courses()
    {
        return $this->belongsToMany(Course::class, 'user_courses')
                    ->withPivot('status', 'progress', 'enrolled_at', 'completed_at', 'rating', 'review')
                    ->withTimestamps();
    }

    public function instructor()
    {
        return $this->hasOne(Instructor::class);
    }

    public function followedInstructors()
    {
        return $this->belongsToMany(Instructor::class, 'user_instructor_follows', 'user_id', 'instructor_id')
                    ->withTimestamps();
    }

    public function wishlist()
    {
        return $this->belongsToMany(Course::class, 'user_wishlist', 'user_id', 'course_id')
                    ->withTimestamps();
    }

    public function isAdmin()
    {
        return $this->role === 'admin';
    }

    public function isInstructor()
    {
        return $this->role === 'instructor';
    }

    public function isStudent()
    {
        return $this->role === 'student';
    }
}
