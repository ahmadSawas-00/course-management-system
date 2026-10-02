@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">📖 {{ __('إدارة الدورات التدريبية') }}</h5>
                    <div>
                        <a href="{{ route('admin.training-courses.create') }}" class="btn btn-success btn-sm">
                            <i class="fas fa-plus"></i> {{ __('إضافة دورة جديدة') }}
                        </a>
                        <a href="{{ route('admin.courses.index') }}" class="btn btn-info btn-sm">
                            <i class="fas fa-book"></i> {{ __('الكورسات') }}
                        </a>
                    </div>
                </div>

                <div class="card-body">
                    <!-- Flash Messages -->
                    @if(session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            <i class="fas fa-check-circle me-2"></i>
                            {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif

                    @if(session('error'))
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <i class="fas fa-exclamation-circle me-2"></i>
                            {{ session('error') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif

                    <!-- Search and Filter -->
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <form action="{{ route('admin.training-courses.index') }}" method="GET" class="d-flex">
                                <input type="text" name="search" class="form-control me-2" placeholder="🔍 {{ __('بحث عن دورة...') }}" value="{{ request('search') }}">
                                <button type="submit" class="btn btn-primary">{{ __('بحث') }}</button>
                                @if(request('search'))
                                    <a href="{{ route('admin.training-courses.index') }}" class="btn btn-secondary ms-2">{{ __('إلغاء') }}</a>
                                @endif
                            </form>
                        </div>
                        <div class="col-md-6 text-end">
                            <span class="badge bg-primary fs-6">
                                {{ __('إجمالي الدورات:') }} {{ $trainingCourses->total() }}
                            </span>
                        </div>
                    </div>

                    <div class="table-responsive">
                        <table class="table table-striped table-hover">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>{{ __('اسم الدورة') }}</th>
                                    <th>{{ __('الكورس المرتبط') }}</th>
                                    <th>{{ __('تاريخ البداية') }}</th>
                                    <th>{{ __('تاريخ النهاية') }}</th>
                                    <th>{{ __('المقاعد') }}</th>
                                    <th>{{ __('المسجلين') }}</th>
                                    <th>{{ __('المتاح') }}</th>
                                    <th>{{ __('الإجراءات') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($trainingCourses as $course)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>
                                        <strong>{{ $course->name }}</strong>
                                        @if($course->description)
                                            <br>
                                            <small class="text-muted">{{ Str::limit($course->description, 30) }}</small>
                                        @endif
                                    </td>
                                    <td>
                                        <span class="badge bg-info">
                                            {{ $course->course->name ?? __('غير محدد') }}
                                        </span>
                                    </td>
                                    <td>
                                        <span class="badge bg-primary">
                                            {{ $course->start_date->format('Y-m-d') }}
                                        </span>
                                    </td>
                                    <td>
                                        <span class="badge bg-danger">
                                            {{ $course->end_date->format('Y-m-d') }}
                                        </span>
                                    </td>
                                    <td class="text-center">
                                        <strong>{{ $course->seats }}</strong>
                                    </td>
                                    <td>
                                        @php
                                            $enrolledCount = $course->students()->whereIn('status', ['pending', 'approved'])->count();
                                        @endphp
                                        <span class="badge bg-warning">
                                            {{ $enrolledCount }}
                                        </span>
                                    </td>
                                    <td>
                                        @php
                                            $available = $course->seats - $enrolledCount;
                                            $color = $available > 5 ? 'success' : ($available > 0 ? 'warning' : 'danger');
                                        @endphp
                                        <span class="badge bg-{{ $color }}">
                                            {{ $available }}
                                        </span>
                                    </td>
                                    <td>
                                        <div class="btn-group" role="group">
                                            <a href="{{ route('admin.training-courses.students', $course->id) }}" 
                                               class="btn btn-info btn-sm" title="{{ __('عرض الطلاب') }}">
                                                <i class="fas fa-users"></i>
                                            </a>
                                            <a href="{{ route('admin.training-courses.edit', $course->id) }}" 
                                               class="btn btn-warning btn-sm" title="{{ __('تعديل') }}">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <form action="{{ route('admin.training-courses.destroy', $course->id) }}" 
                                                  method="POST" class="d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger btn-sm" 
                                                        onclick="return confirm('{{ __('⚠️ هل أنت متأكد من حذف هذه الدورة؟') }}')" 
                                                        title="{{ __('حذف') }}">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="9" class="text-center text-muted py-4">
                                        <i class="fas fa-calendar-times fa-3x d-block mb-2"></i>
                                        <h5>⚠️ {{ __('لا توجد دورات تدريبية') }}</h5>
                                        <p class="mb-0">{{ __('يمكنك إضافة دورة جديدة بالضغط على زر "إضافة دورة جديدة"') }}</p>
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <!-- Pagination -->
                    <div class="d-flex justify-content-between align-items-center mt-3">
                        <div>
                            {{ __('عرض') }} {{ $trainingCourses->firstItem() ?? 0 }} 
                            {{ __('إلى') }} {{ $trainingCourses->lastItem() ?? 0 }} 
                            {{ __('من أصل') }} {{ $trainingCourses->total() }} {{ __('دورات') }}
                        </div>
                        <div>
                            {{ $trainingCourses->links() }}
                        </div>
                    </div>

                    <!-- Quick Stats -->
                    <div class="row mt-4">
                        <div class="col-md-4">
                            <div class="card bg-primary text-white">
                                <div class="card-body text-center">
                                    <h5 class="mb-0">📚 {{ __('إجمالي الدورات') }}</h5>
                                    <h2 class="mb-0">{{ $trainingCourses->total() }}</h2>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="card bg-success text-white">
                                <div class="card-body text-center">
                                    <h5 class="mb-0">👨‍🎓 {{ __('إجمالي المسجلين') }}</h5>
                                    <h2 class="mb-0">
                                        {{ $trainingCourses->sum(function($course) { 
                                            return $course->students()->whereIn('status', ['pending', 'approved'])->count(); 
                                        }) }}
                                    </h2>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="card bg-warning text-white">
                                <div class="card-body text-center">
                                    <h5 class="mb-0">🪑 {{ __('إجمالي المقاعد المتاحة') }}</h5>
                                    <h2 class="mb-0">
                                        {{ $trainingCourses->sum(function($course) { 
                                            $enrolled = $course->students()->whereIn('status', ['pending', 'approved'])->count();
                                            return $course->seats - $enrolled;
                                        }) }}
                                    </h2>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    // Auto-hide alerts after 5 seconds
    setTimeout(function() {
        let alerts = document.querySelectorAll('.alert');
        alerts.forEach(function(alert) {
            let bsAlert = new bootstrap.Alert(alert);
            bsAlert.close();
        });
    }, 5000);
</script>
@endpush