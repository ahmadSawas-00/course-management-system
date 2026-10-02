@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <!-- Welcome Card -->
            <div class="card bg-primary text-white mb-4">
                <div class="card-body">
                    <h2 class="mb-2">👋 {{ __('مرحباً بك، :name!', ['name' => Auth::user()->name]) }}</h2>
                    <p class="mb-0">{{ __('نظام إدارة وحجز الكورسات - لوحة التحكم الرئيسية') }}</p>
                </div>
            </div>

            <!-- Statistics Cards -->
            <div class="row">
                <div class="col-md-3 mb-4">
                    <div class="card border-left-primary shadow h-100 py-2">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-2">
                                    <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                        📚 {{ __('عدد الكورسات') }}
                                    </div>
                                    <div class="h5 mb-0 font-weight-bold text-gray-800">
                                        {{ \App\Models\Course::count() }}
                                    </div>
                                </div>
                                <div class="col-auto">
                                    <i class="fas fa-book fa-2x text-gray-300"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-3 mb-4">
                    <div class="card border-left-success shadow h-100 py-2">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-2">
                                    <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                        👨‍🎓 {{ __('عدد الطلاب') }}
                                    </div>
                                    <div class="h5 mb-0 font-weight-bold text-gray-800">
                                        {{ \App\Models\Student::count() }}
                                    </div>
                                </div>
                                <div class="col-auto">
                                    <i class="fas fa-users fa-2x text-gray-300"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-3 mb-4">
                    <div class="card border-left-info shadow h-100 py-2">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-2">
                                    <div class="text-xs font-weight-bold text-info text-uppercase mb-1">
                                        📖 {{ __('عدد الدورات') }}
                                    </div>
                                    <div class="h5 mb-0 font-weight-bold text-gray-800">
                                        {{ \App\Models\TrainingCourse::count() }}
                                    </div>
                                </div>
                                <div class="col-auto">
                                    <i class="fas fa-calendar-alt fa-2x text-gray-300"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-3 mb-4">
                    <div class="card border-left-warning shadow h-100 py-2">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-2">
                                    <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                                        📝 {{ __('عدد التسجيلات') }}
                                    </div>
                                    <div class="h5 mb-0 font-weight-bold text-gray-800">
                                        {{ \App\Models\Enrollment::count() }}
                                    </div>
                                </div>
                                <div class="col-auto">
                                    <i class="fas fa-clipboard-list fa-2x text-gray-300"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Quick Actions -->
            <div class="row mt-4">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="mb-0">⚡ {{ __('الإجراءات السريعة') }}</h5>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-3 mb-3">
                                    <a href="{{ route('admin.courses.index') }}" class="btn btn-primary w-100 py-3">
                                        <i class="fas fa-book fa-2x d-block mb-2"></i>
                                        {{ __('إدارة الكورسات') }}
                                    </a>
                                </div>
                                <div class="col-md-3 mb-3">
                                    <a href="{{ route('admin.students.index') }}" class="btn btn-success w-100 py-3">
                                        <i class="fas fa-users fa-2x d-block mb-2"></i>
                                        {{ __('إدارة الطلاب') }}
                                    </a>
                                </div>
                                <div class="col-md-3 mb-3">
                                    <a href="{{ route('admin.training-courses.index') }}" class="btn btn-info w-100 py-3">
                                        <i class="fas fa-calendar-alt fa-2x d-block mb-2"></i>
                                        {{ __('إدارة الدورات') }}
                                    </a>
                                </div>
                                <div class="col-md-3 mb-3">
                                    <a href="{{ route('admin.enrollments.index') }}" class="btn btn-warning w-100 py-3">
                                        <i class="fas fa-clipboard-list fa-2x d-block mb-2"></i>
                                        {{ __('إدارة التسجيلات') }}
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Recent Enrollments -->
            <div class="row mt-4">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="mb-0">🔄 {{ __('أحدث التسجيلات') }}</h5>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-striped">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>{{ __('الطالب') }}</th>
                                            <th>{{ __('الدورة التدريبية') }}</th>
                                            <th>{{ __('تاريخ التسجيل') }}</th>
                                            <th>{{ __('الحالة') }}</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse(\App\Models\Enrollment::with(['student', 'trainingCourse'])->latest()->take(5)->get() as $enrollment)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $enrollment->student->full_name ?? __('غير محدد') }}</td>
                                            <td>{{ $enrollment->trainingCourse->name ?? __('غير محدد') }}</td>
                                            <td>{{ $enrollment->enrollment_date->format('Y-m-d') }}</td>
                                            <td>
                                                <span class="badge bg-{{ $enrollment->status == 'approved' ? 'success' : ($enrollment->status == 'pending' ? 'warning' : 'danger') }}">
                                                    {{ $enrollment->status == 'approved' ? '✅ ' . __('مقبول') : ($enrollment->status == 'pending' ? '⏳ ' . __('قيد الانتظار') : '❌ ' . __('ملغي')) }}
                                                </span>
                                            </td>
                                        </tr>
                                        @empty
                                        <tr>
                                            <td colspan="5" class="text-center text-muted">⚠️ {{ __('لا توجد تسجيلات حتى الآن') }}</td>
                                        </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection