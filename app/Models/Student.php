<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    use HasFactory;

    protected $fillable = [
        'full_name',
        'email',
        'phone',
        'profile_image',
        'documents'
    ];

    public function trainingCourses()
    {
        return $this->belongsToMany(TrainingCourse::class, 'enrollments')
            ->withPivot('enrollment_date', 'status')
            ->withTimestamps();
    }
}
