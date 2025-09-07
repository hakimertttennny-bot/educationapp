<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Instructor extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id',
        'bio',
        'specialization',
        'experience_years',
        'website',
        'linkedin',
        'twitter',
        'github',
        'hourly_rate',
        'is_verified',
        'status'
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'experience_years' => 'integer',
        'hourly_rate' => 'decimal:2',
        'is_verified' => 'boolean',
    ];

    /**
     * Get the user that owns the instructor profile.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the courses for this instructor.
     */
    public function courses()
    {
        return $this->hasMany(Course::class);
    }

    /**
     * Get the enrollments for this instructor's courses.
     */
    public function enrollments()
    {
        return $this->hasManyThrough(Enrollment::class, Course::class);
    }

    /**
     * Scope a query to only include verified instructors.
     */
    public function scopeVerified($query)
    {
        return $query->where('is_verified', true);
    }

    /**
     * Scope a query to only include active instructors.
     */
    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }
}
