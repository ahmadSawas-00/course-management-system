@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">✏️ {{ __('تعديل الكورس') }}: {{ $course->name }}</h5>
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

                    <form action="{{ route('admin.courses.update', $course->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <div class="mb-3">
                            <label for="name" class="form-label">{{ __('اسم الكورس') }} <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('name') is-invalid @enderror" 
                                   id="name" name="name" value="{{ old('name', $course->name) }}" required>
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="description" class="form-label">{{ __('الوصف') }}</label>
                            <textarea class="form-control @error('description') is-invalid @enderror" 
                                      id="description" name="description" rows="3">{{ old('description', $course->description) }}</textarea>
                            @error('description')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="hours" class="form-label">{{ __('عدد الساعات') }} <span class="text-danger">*</span></label>
                            <input type="number" class="form-control @error('hours') is-invalid @enderror" 
                                   id="hours" name="hours" value="{{ old('hours', $course->hours) }}" min="1" required>
                            @error('hours')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- تعديل ملف المنهج -->
                        <div class="mb-3">
                            <label for="syllabus" class="form-label">{{ __('تحديث ملف المنهج (PDF)') }}</label>
                            @if($course->syllabus_path)
                                <div class="mb-2">
                                    <a href="{{ Storage::url($course->syllabus_path) }}" target="_blank" class="btn btn-sm btn-outline-danger">
                                        <i class="fas fa-file-pdf"></i> {{ __('عرض المنهج الحالي') }}
                                    </a>
                                </div>
                            @endif
                            <input type="file" class="form-control @error('syllabus') is-invalid @enderror" 
                                   id="syllabus" name="syllabus" accept="application/pdf">
                            <small class="form-text text-muted">{{ __('اتركه فارغاً إذا كنت لا تريد تغيير الملف الحالي') }}</small>
                            @error('syllabus')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="status" class="form-label">{{ __('الحالة') }} <span class="text-danger">*</span></label>
                            <select class="form-control @error('status') is-invalid @enderror" 
                                    id="status" name="status" required>
                                <option value="active" {{ old('status', $course->status) == 'active' ? 'selected' : '' }}>✅ {{ __('فعال') }}</option>
                                <option value="inactive" {{ old('status', $course->status) == 'inactive' ? 'selected' : '' }}>❌ {{ __('غير فعال') }}</option>
                            </select>
                            @error('status')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="d-flex justify-content-between">
                            <a href="{{ route('admin.courses.index') }}" class="btn btn-secondary">{{ __('إلغاء') }}</a>
                            <button type="submit" class="btn btn-primary">💾 {{ __('تحديث الكورس') }}</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection