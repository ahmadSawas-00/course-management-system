<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Course;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;

class CourseController extends Controller
{
    public function index()
    {
        $courses = Course::latest()->paginate(10);
        return view('admin.courses.index', compact('courses'));
    }

    public function create()
    {
        return view('admin.courses.create');
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255|unique:courses',
            'description' => 'nullable|string',
            'hours' => 'required|integer|min:1',
            'capacity' => 'nullable|integer|min:1',
            'status' => 'required|in:active,inactive',
            'syllabus' => 'nullable|file|mimes:pdf|max:10240', // المهمة 25: ملف PDF بحد أقصى 10MB
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        try {
            // إنشاء الكورس بالبيانات العادية
            $course = Course::create($request->only(['name', 'description', 'hours', 'capacity', 'status']));

            // رفع ملف المنهج وتخزينه في مجلد خاص بالكورس
            if ($request->hasFile('syllabus')) {
                $path = $request->file('syllabus')->storeAs(
                    "courses/{$course->id}",
                    'syllabus_' . time() . '.pdf',
                    'public'
                );
                $course->update(['syllabus_path' => $path]);
            }

            return redirect()->route('admin.courses.index')
                ->with('success', 'تم إضافة الكورس بنجاح ✅');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'حدث خطأ: ' . $e->getMessage())
                ->withInput();
        }
    }

    public function show(Course $course)
    {
        // المهمة 26: تعيين الكوكي لآخر كورس مزار لمدة 30 يوم
        $cookie = cookie('last_visited_course', $course->id, 60 * 24 * 30);

        if (view()->exists('admin.courses.show')) {
            return response()->view('admin.courses.show', compact('course'))->cookie($cookie);
        }

        return redirect()->route('admin.courses.index')->cookie($cookie);
    }

    public function edit(Course $course)
    {
        return view('admin.courses.edit', compact('course'));
    }

    public function update(Request $request, Course $course)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255|unique:courses,name,' . $course->id,
            'description' => 'nullable|string',
            'hours' => 'required|integer|min:1',
            'capacity' => 'nullable|integer|min:1',
            'status' => 'required|in:active,inactive',
            'syllabus' => 'nullable|file|mimes:pdf|max:10240',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        try {
            $course->update($request->only(['name', 'description', 'hours', 'capacity', 'status']));

            // تحديث ملف المنهج في حال رفع ملف جديد
            if ($request->hasFile('syllabus')) {
                // حذف الملف القديم إن وجد
                if ($course->syllabus_path && Storage::disk('public')->exists($course->syllabus_path)) {
                    Storage::disk('public')->delete($course->syllabus_path);
                }

                $path = $request->file('syllabus')->storeAs(
                    "courses/{$course->id}",
                    'syllabus_' . time() . '.pdf',
                    'public'
                );
                $course->update(['syllabus_path' => $path]);
            }

            return redirect()->route('admin.courses.index')
                ->with('success', 'تم تعديل الكورس بنجاح ✅');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'حدث خطأ: ' . $e->getMessage())
                ->withInput();
        }
    }

    public function destroy(Course $course)
    {
        try {
            // حذف ملف المنهج من السيرفر عند حذف الكورس
            if ($course->syllabus_path && Storage::disk('public')->exists($course->syllabus_path)) {
                Storage::disk('public')->delete($course->syllabus_path);
            }

            $course->delete();
            return redirect()->route('admin.courses.index')
                ->with('success', 'تم حذف الكورس بنجاح ✅');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'حدث خطأ: ' . $e->getMessage());
        }
    }
}