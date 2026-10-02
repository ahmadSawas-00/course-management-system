<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Enrollment extends Model
{
    use HasFactory;

    protected $fillable = [
        'student_id',
        'training_course_id',
        'enrollment_date',
        'status'
    ];

    protected $casts = [
        'enrollment_date' => 'date'
    ];

    public function student()
    {
        return $this->belongsTo(Student::class);
    }

    public function trainingCourse()
    {
        return $this->belongsTo(TrainingCourse::class);
    }
}
