<?php

namespace App\Http\Controllers\Admin;

use App\Events\EnrollmentCreated;
use App\Http\Controllers\Controller;
use App\Models\Enrollment;
use App\Models\Student;
use App\Models\TrainingCourse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;

class EnrollmentController extends Controller
{
    public function index()
    {
        $enrollments = Enrollment::with(['student', 'trainingCourse'])
            ->latest()
            ->paginate(10);
        return view('admin.enrollments.index', compact('enrollments'));
    }

    public function create()
    {
        $students = Student::all();
        $trainingCourses = TrainingCourse::with('course')->get();
        return view('admin.enrollments.create', compact('students', 'trainingCourses'));
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'student_id' => 'required|exists:students,id',
            'training_course_id' => 'required|exists:training_courses,id',
            'status' => 'required|in:pending,approved,rejected,cancelled'
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        try {
            // التحقق من عدم وجود تسجيل مسبق
            $existingEnrollment = Enrollment::where('student_id', $request->student_id)
                ->where('training_course_id', $request->training_course_id)
                ->first();

            if ($existingEnrollment) {
                return redirect()->back()
                    ->with('error', '⚠️ هذا الطالب مسجل بالفعل في هذه الدورة')
                    ->withInput();
            }

            // التحقق من عدد المقاعد المتاحة
            $trainingCourse = TrainingCourse::find($request->training_course_id);
            $enrolledCount = Enrollment::where('training_course_id', $request->training_course_id)
                ->whereIn('status', ['pending', 'approved'])
                ->count();

            if ($enrolledCount >= $trainingCourse->seats) {
                return redirect()->back()
                    ->with('error', '⚠️ لا توجد مقاعد متاحة في هذه الدورة (المتاح: ' . ($trainingCourse->seats - $enrolledCount) . ')')
                    ->withInput();
            }

            // إنشاء التسجيل مع تخزينه في متغير لتمريره للحدث
            $enrollment = Enrollment::create([
                'student_id' => $request->student_id,
                'training_course_id' => $request->training_course_id,
                'enrollment_date' => Carbon::now(),
                'status' => $request->status
            ]);

            // 🚀 إطلاق الحدث لإرسال البريد إلكترونياً تلقائياً عبر الـ Listener
            event(new EnrollmentCreated($enrollment));

            return redirect()->route('admin.enrollments.index')
                ->with('success', '✅ تم تسجيل الطالب في الدورة التدريبية بنجاح وتم إرسال إشعار البريد الإلكتروني');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', '❌ حدث خطأ: ' . $e->getMessage());
        }
    }

    public function edit(Enrollment $enrollment)
    {
        $students = Student::all();
        $trainingCourses = TrainingCourse::with('course')->get();
        return view('admin.enrollments.edit', compact('enrollment', 'students', 'trainingCourses'));
    }

    public function update(Request $request, Enrollment $enrollment)
    {
        $validator = Validator::make($request->all(), [
            'student_id' => 'required|exists:students,id',
            'training_course_id' => 'required|exists:training_courses,id',
            'status' => 'required|in:pending,approved,rejected,cancelled'
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        try {
            $enrollment->update($request->all());
            return redirect()->route('admin.enrollments.index')
                ->with('success', '✅ تم تحديث حالة التسجيل بنجاح');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', '❌ حدث خطأ: ' . $e->getMessage());
        }
    }

    public function destroy(Enrollment $enrollment)
    {
        try {
            $enrollment->delete();
            return redirect()->route('admin.enrollments.index')
                ->with('success', '✅ تم إلغاء تسجيل الطالب بنجاح');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', '❌ حدث خطأ: ' . $e->getMessage());
        }
    }

    // عرض الطلاب المسجلين في دورة معينة
    public function showStudents(TrainingCourse $trainingCourse)
    {
        $students = $trainingCourse->students()->withPivot('status', 'enrollment_date')->get();
        return view('admin.enrollments.show-students', compact('trainingCourse', 'students'));
    }
}