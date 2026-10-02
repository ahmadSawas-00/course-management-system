<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Course;
use App\Models\Student;
use App\Models\TrainingCourse;
use App\Models\Enrollment;
use Carbon\Carbon;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // إنشاء كورسات تجريبية
        Course::create([
            'name' => 'PHP Laravel',
            'description' => 'دورة تطوير تطبيقات الويب باستخدام Laravel',
            'hours' => 40,
            'status' => 'active'
        ]);

        Course::create([
            'name' => 'JavaScript',
            'description' => 'دورة JavaScript المتقدمة',
            'hours' => 30,
            'status' => 'active'
        ]);

        // إنشاء طلاب تجريبيين
        Student::create([
            'full_name' => 'أحمد محمد',
            'email' => 'ahmed@example.com',
            'phone' => '0501234567',
        ]);

        Student::create([
            'full_name' => 'سارة أحمد',
            'email' => 'sara@example.com',
            'phone' => '0507654321',
        ]);

        // إنشاء دورات تدريبية تجريبية
        $course = Course::first();
        TrainingCourse::create([
            'name' => 'دورة Laravel الأساسية',
            'description' => 'تعلم أساسيات Laravel',
            'start_date' => Carbon::now()->addDays(7),
            'end_date' => Carbon::now()->addDays(21),
            'seats' => 20,
            'course_id' => $course->id
        ]);

        // إنشاء تسجيلات تجريبية
        $student = Student::first();
        $trainingCourse = TrainingCourse::first();
        Enrollment::create([
            'student_id' => $student->id,
            'training_course_id' => $trainingCourse->id,
            'enrollment_date' => Carbon::now(),
            'status' => 'pending'
        ]);
    }
}
