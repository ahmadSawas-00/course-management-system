<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\TrainingCourse;
use App\Models\Course;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;

class TrainingCourseController extends Controller
{
    public function index()
    {
        $trainingCourses = TrainingCourse::with('course')->latest()->paginate(10);
        return view('admin.training-courses.index', compact('trainingCourses'));
    }

    public function create()
    {
        $courses = Course::where('status', 'active')->get();
        return view('admin.training-courses.create', compact('courses'));
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'start_date' => 'required|date|after_or_equal:today',
            'end_date' => 'required|date|after:start_date',
            'seats' => 'required|integer|min:1',
            'course_id' => 'required|exists:courses,id'
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        try {
            TrainingCourse::create($request->all());
            return redirect()->route('admin.training-courses.index')
                ->with('success', '✅ تم إضافة الدورة التدريبية بنجاح');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', '❌ حدث خطأ: ' . $e->getMessage());
        }
    }

    public function edit(TrainingCourse $trainingCourse)
    {
        $courses = Course::where('status', 'active')->get();
        return view('admin.training-courses.edit', compact('trainingCourse', 'courses'));
    }

    public function update(Request $request, TrainingCourse $trainingCourse)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after:start_date',
            'seats' => 'required|integer|min:1',
            'course_id' => 'required|exists:courses,id'
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        try {
            $trainingCourse->update($request->all());
            return redirect()->route('admin.training-courses.index')
                ->with('success', '✅ تم تعديل الدورة التدريبية بنجاح');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', '❌ حدث خطأ: ' . $e->getMessage());
        }
    }

    public function destroy(TrainingCourse $trainingCourse)
    {
        try {
            $trainingCourse->delete();
            return redirect()->route('admin.training-courses.index')
                ->with('success', '✅ تم حذف الدورة التدريبية بنجاح');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', '❌ حدث خطأ: ' . $e->getMessage());
        }
    }
}
