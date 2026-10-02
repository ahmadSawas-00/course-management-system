@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">✏️ {{ __('تعديل بيانات الطالب') }}: {{ $student->full_name }}</h5>
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

                    <form action="{{ route('admin.students.update', $student->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <div class="mb-3">
                            <label for="full_name" class="form-label">{{ __('الاسم الكامل') }} <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('full_name') is-invalid @enderror" 
                                   id="full_name" name="full_name" value="{{ old('full_name', $student->full_name) }}" required>
                            @error('full_name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="email" class="form-label">{{ __('البريد الإلكتروني') }} <span class="text-danger">*</span></label>
                            <input type="email" class="form-control @error('email') is-invalid @enderror" 
                                   id="email" name="email" value="{{ old('email', $student->email) }}" required>
                            @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="phone" class="form-label">{{ __('رقم الهاتف') }}</label>
                            <input type="text" class="form-control @error('phone') is-invalid @enderror" 
                                   id="phone" name="phone" value="{{ old('phone', $student->phone) }}">
                            @error('phone')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="profile_image" class="form-label">{{ __('الصورة الشخصية') }}</label>
                            @if($student->profile_image)
                                <div class="mb-2">
                                    <img src="{{ asset('storage/students/profile_images/' . $student->profile_image) }}" 
                                         alt="{{ $student->full_name }}" 
                                         style="width: 100px; height: 100px; object-fit: cover; border-radius: 50%;">
                                    <span class="badge bg-info">{{ __('الصورة الحالية') }}</span>
                                </div>
                            @endif
                            <input type="file" class="form-control @error('profile_image') is-invalid @enderror" 
                                   id="profile_image" name="profile_image" accept="image/*">
                            <small class="text-muted">📸 {{ __('اتركه فارغاً للحفاظ على الصورة الحالية') }}</small>
                            @error('profile_image')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="documents" class="form-label">{{ __('الملفات المرفقة') }}</label>
                            @if($student->documents)
                                <div class="mb-2">
                                    <a href="{{ asset('storage/students/documents/' . $student->documents) }}" 
                                       target="_blank" class="btn btn-info btn-sm">
                                        <i class="fas fa-file"></i> {{ __('عرض الملف الحالي') }}
                                    </a>
                                </div>
                            @endif
                            <input type="file" class="form-control @error('documents') is-invalid @enderror" 
                                   id="documents" name="documents" accept=".pdf,.doc,.docx">
                            <small class="text-muted">📄 {{ __('اتركه فارغاً للحفاظ على الملف الحالي') }}</small>
                            @error('documents')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="d-flex justify-content-between">
                            <a href="{{ route('admin.students.index') }}" class="btn btn-secondary">{{ __('إلغاء') }}</a>
                            <button type="submit" class="btn btn-primary">💾 {{ __('تحديث البيانات') }}</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection