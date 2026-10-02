<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;

class StudentController extends Controller
{
    public function index()
    {
        $students = Student::latest()->paginate(10);
        return view('admin.students.index', compact('students'));
    }

    public function create()
    {
        return view('admin.students.create');
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'full_name' => 'required|string|max:255',
            'email' => 'required|email|unique:students',
            'phone' => 'nullable|string|max:20',
            'profile_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'documents' => 'nullable|file|mimes:pdf,doc,docx|max:5120'
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        try {
            $data = $request->all();

            // رفع الصورة الشخصية
            if ($request->hasFile('profile_image')) {
                $image = $request->file('profile_image');
                $imageName = time() . '_' . $image->getClientOriginalName();
                $image->storeAs('students/profile_images', $imageName, 'public');
                $data['profile_image'] = $imageName;
            }

            // رفع الملفات المرفقة
            if ($request->hasFile('documents')) {
                $document = $request->file('documents');
                $documentName = time() . '_' . $document->getClientOriginalName();
                $document->storeAs('students/documents', $documentName, 'public');
                $data['documents'] = $documentName;
            }

            Student::create($data);

            return redirect()->route('admin.students.index')
                ->with('success', '✅ تم إضافة الطالب بنجاح');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', '❌ حدث خطأ: ' . $e->getMessage());
        }
    }

    public function edit(Student $student)
    {
        return view('admin.students.edit', compact('student'));
    }

    public function update(Request $request, Student $student)
    {
        $validator = Validator::make($request->all(), [
            'full_name' => 'required|string|max:255',
            'email' => 'required|email|unique:students,email,' . $student->id,
            'phone' => 'nullable|string|max:20',
            'profile_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'documents' => 'nullable|file|mimes:pdf,doc,docx|max:5120'
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        try {
            $data = $request->all();

            // تحديث الصورة الشخصية
            if ($request->hasFile('profile_image')) {
                // حذف الصورة القديمة
                if ($student->profile_image) {
                    Storage::disk('public')->delete('students/profile_images/' . $student->profile_image);
                }

                $image = $request->file('profile_image');
                $imageName = time() . '_' . $image->getClientOriginalName();
                $image->storeAs('students/profile_images', $imageName, 'public');
                $data['profile_image'] = $imageName;
            }

            // تحديث الملفات المرفقة
            if ($request->hasFile('documents')) {
                // حذف الملف القديم
                if ($student->documents) {
                    Storage::disk('public')->delete('students/documents/' . $student->documents);
                }

                $document = $request->file('documents');
                $documentName = time() . '_' . $document->getClientOriginalName();
                $document->storeAs('students/documents', $documentName, 'public');
                $data['documents'] = $documentName;
            }

            $student->update($data);

            return redirect()->route('admin.students.index')
                ->with('success', '✅ تم تعديل بيانات الطالب بنجاح');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', '❌ حدث خطأ: ' . $e->getMessage());
        }
    }

    public function destroy(Student $student)
    {
        try {
            // حذف الصورة والملفات المرتبطة
            if ($student->profile_image) {
                Storage::disk('public')->delete('students/profile_images/' . $student->profile_image);
            }
            if ($student->documents) {
                Storage::disk('public')->delete('students/documents/' . $student->documents);
            }

            $student->delete();

            return redirect()->route('admin.students.index')
                ->with('success', '✅ تم حذف الطالب بنجاح');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', '❌ حدث خطأ: ' . $e->getMessage());
        }
    }
}
