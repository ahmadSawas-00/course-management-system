<?php

namespace App\Helpers;

use App\Models\Course;

class CourseHelper
{
    public static function remainingSeats(Course $course): int
    {
        // حساب مجموع التسجيلات المؤكدة عبر جميع الدورات التابعة لهذا الكورس
        $confirmedBookings = 0;

        if (method_exists($course, 'trainingCourses')) {
            foreach ($course->trainingCourses as $trainingCourse) {
                if (method_exists($trainingCourse, 'enrollments')) {
                    $confirmedBookings += $trainingCourse->enrollments()->where('status', 'confirmed')->count();
                }
            }
        } elseif (method_exists($course, 'bookings')) {
            // محاولة حساب مباشرة في حال وجود المفتاح
            try {
                $confirmedBookings = $course->bookings()->where('status', 'confirmed')->count();
            } catch (\Exception $e) {
                $confirmedBookings = 0;
            }
        }

        $capacity = $course->capacity ?? 0;

        return max(0, $capacity - $confirmedBookings);
    }

    public static function isAvailable(Course $course): bool
    {
        return self::remainingSeats($course) > 0 && $course->status === 'active';
    }
}