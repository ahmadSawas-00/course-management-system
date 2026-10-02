<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Course extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'hours',
        'capacity',
        'status',
        'syllabus_path'
    ];

    public function trainingCourses(): HasMany
    {
        return $this->hasMany(TrainingCourse::class);
    }

    /**
     * علاقة الكورس مع التسجيلات/الحجوزات
     */
    public function bookings()
    {
        return $this->hasManyThrough(Enrollment::class, TrainingCourse::class);
    }
}