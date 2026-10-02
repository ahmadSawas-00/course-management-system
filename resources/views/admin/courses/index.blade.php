@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">📚 {{ __('إدارة الكورسات') }}</h5>
                    <a href="{{ route('admin.courses.create') }}" class="btn btn-primary btn-sm">
                        <i class="fas fa-plus"></i> {{ __('إضافة كورس جديد') }}
                    </a>
                </div>

                <div class="card-body">
                    @if(session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif

                    @if(session('error'))
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            {{ session('error') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif

                    <div class="table-responsive">
                        <table class="table table-striped table-hover align-middle">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>{{ __('اسم الكورس') }}</th>
                                    <th>{{ __('الوصف') }}</th>
                                    <th>{{ __('المنهج (PDF)') }}</th>
                                    <th>{{ __('السعة الكلية') }}</th>
                                    <th>{{ __('المقاعد المتبقية') }}</th>
                                    <th>{{ __('إمكانية الحجز') }}</th>
                                    <th>{{ __('الحالة') }}</th>
                                    <th>{{ __('الإجراءات') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($courses as $course)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td><strong>{{ $course->name }}</strong></td>
                                    <td>{{ Str::limit($course->description, 40) ?: __('لا يوجد وصف') }}</td>
                                    
                                    <!-- عمود تنزيل المنهج -->
                                    <td>
                                        @if($course->syllabus_path)
                                            <a href="{{ Storage::url($course->syllabus_path) }}" target="_blank" class="btn btn-outline-danger btn-sm">
                                                <i class="fas fa-file-pdf"></i> {{ __('تحميل PDF') }}
                                            </a>
                                        @else
                                            <span class="text-muted small">{{ __('غير مرفوع') }}</span>
                                        @endif
                                    </td>

                                    <td>{{ $course->capacity ?? 0 }}</td>
                                    
                                    <td>
                                        <span class="badge bg-info text-dark">
                                            {{ course_remaining_seats($course) }}
                                        </span>
                                    </td>

                                    <td>
                                        @if(is_course_available($course))
                                            <span class="badge bg-success">{{ __('متاح للحجز') }}</span>
                                        @else
                                            <span class="badge bg-secondary">{{ __('غير متاح / مكتمل') }}</span>
                                        @endif
                                    </td>

                                    <td>
                                        <span class="badge bg-{{ $course->status == 'active' ? 'success' : 'danger' }}">
                                            {{ $course->status == 'active' ? '✅ ' . __('فعال') : '❌ ' . __('غير فعال') }}
                                        </span>
                                    </td>
                                    <td>
                                        <a href="{{ route('admin.courses.edit', $course->id) }}" class="btn btn-warning btn-sm" title="{{ __('تعديل') }}">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <form action="{{ route('admin.courses.destroy', $course->id) }}" method="POST" class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('{{ __('هل أنت متأكد من حذف هذا الكورس؟') }}')">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="9" class="text-center text-muted">⚠️ {{ __('لا توجد كورسات مسجلة') }}</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    {{ $courses->links() }}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection