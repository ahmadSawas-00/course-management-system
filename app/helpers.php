<?php

use App\Helpers\CourseHelper;
use App\Models\Course;

if (!function_exists('course_remaining_seats')) {
    function course_remaining_seats(Course $course): int
    {
        return CourseHelper::remainingSeats($course);
    }
}

if (!function_exists('is_course_available')) {
    function is_course_available(Course $course): bool
    {
        return CourseHelper::isAvailable($course);
    }
}