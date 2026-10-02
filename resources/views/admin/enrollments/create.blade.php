@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">➕ {{ __('تسجيل طالب في دورة تدريبية') }}</h5>
                </div>

                <div class="card-body">
                    @if($errors->any())
                        <div class="alert alert-danger">
                            <ul class="mb-0">
                                @foreach($errors->all() as $error)
                                    <li>❌ {{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form action="{{ route('admin.enrollments.store') }}" method="POST">
                        @csrf

                        <div class="mb-3">
                            <label for="student_id" class="form-label">{{ __('الطالب') }} <span class="text-danger">*</span></label>
                            <select class="form-control @error('student_id') is-invalid @enderror" 
                                    id="student_id" name="student_id" required>
                                <option value="">{{ __('اختر الطالب') }}</option>
                                @foreach($students as $student)
                                    <option value="{{ $student->id }}" {{ old('student_id') == $student->id ? 'selected' : '' }}>
                                        {{ $student->full_name }} ({{ $student->email }})
                                    </option>
                                @endforeach
                            </select>
                            @error('student_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="training_course_id" class="form-label">{{ __('الدورة التدريبية') }} <span class="text-danger">*</span></label>
                            <select class="form-control @error('training_course_id') is-invalid @enderror" 
                                    id="training_course_id" name="training_course_id" required>
                                <option value="">{{ __('اختر الدورة التدريبية') }}</option>
                                @foreach($trainingCourses as $course)
                                    @php
                                        $enrolledCount = $course->students()->whereIn('status', ['pending', 'approved'])->count();
                                        $available = $course->seats - $enrolledCount;
                                    @endphp
                                    <option value="{{ $course->id }}" {{ old('training_course_id') == $course->id ? 'selected' : '' }}>
                                        {{ $course->name }} ({{ $course->course->name ?? __('غير محدد') }}) - {{ __('متاح') }}: {{ $available }} {{ __('مقعد') }}
                                    </option>
                                @endforeach
                            </select>
                            @error('training_course_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="status" class="form-label">{{ __('الحالة') }} <span class="text-danger">*</span></label>
                            <select class="form-control @error('status') is-invalid @enderror" 
                                    id="status" name="status" required>
                                <option value="pending" {{ old('status') == 'pending' ? 'selected' : '' }}>⏳ {{ __('قيد الانتظار') }}</option>
                                <option value="approved" {{ old('status') == 'approved' ? 'selected' : '' }}>✅ {{ __('مقبول') }}</option>
                                <option value="rejected" {{ old('status') == 'rejected' ? 'selected' : '' }}>❌ {{ __('مرفوض') }}</option>
                                <option value="cancelled" {{ old('status') == 'cancelled' ? 'selected' : '' }}>🚫 {{ __('ملغي') }}</option>
                            </select>
                            @error('status')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="d-flex justify-content-between">
                            <a href="{{ route('admin.enrollments.index') }}" class="btn btn-secondary">{{ __('إلغاء') }}</a>
                            <button type="submit" class="btn btn-primary">💾 {{ __('تسجيل الطالب') }}</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection