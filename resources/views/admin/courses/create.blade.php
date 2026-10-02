@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">➕ {{ __('إضافة كورس جديد') }}</h5>
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

                    <form action="{{ route('admin.courses.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf

                        <div class="mb-3">
                            <label for="name" class="form-label">{{ __('اسم الكورس') }} <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('name') is-invalid @enderror" 
                                   id="name" name="name" value="{{ old('name') }}" required>
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="description" class="form-label">{{ __('الوصف') }}</label>
                            <textarea class="form-control @error('description') is-invalid @enderror" 
                                      id="description" name="description" rows="3">{{ old('description') }}</textarea>
                            @error('description')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="hours" class="form-label">{{ __('عدد الساعات') }} <span class="text-danger">*</span></label>
                            <input type="number" class="form-control @error('hours') is-invalid @enderror" 
                                   id="hours" name="hours" value="{{ old('hours', 1) }}" min="1" required>
                            @error('hours')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- حقل رفع منهج الكورس (PDF) -->
                        <div class="mb-3">
                            <label for="syllabus" class="form-label">{{ __('ملف منهج الكورس (PDF)') }}</label>
                            <input type="file" class="form-control @error('syllabus') is-invalid @enderror" 
                                   id="syllabus" name="syllabus" accept="application/pdf">
                            <small class="form-text text-muted">{{ __('ملف PDF فقط - الحد الأقصى 10 ميجابايت') }}</small>
                            @error('syllabus')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="status" class="form-label">{{ __('الحالة') }} <span class="text-danger">*</span></label>
                            <select class="form-control @error('status') is-invalid @enderror" 
                                    id="status" name="status" required>
                                <option value="active" {{ old('status') == 'active' ? 'selected' : '' }}>✅ {{ __('فعال') }}</option>
                                <option value="inactive" {{ old('status') == 'inactive' ? 'selected' : '' }}>❌ {{ __('غير فعال') }}</option>
                            </select>
                            @error('status')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="d-flex justify-content-between">
                            <a href="{{ route('admin.courses.index') }}" class="btn btn-secondary">{{ __('إلغاء') }}</a>
                            <button type="submit" class="btn btn-primary">💾 {{ __('حفظ الكورس') }}</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection