@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">👨‍🎓 {{ __('الطلاب المسجلين في') }}: {{ $trainingCourse->name }}</h5>
                    <a href="{{ route('admin.training-courses.index') }}" class="btn btn-secondary btn-sm">
                        <i class="fas fa-arrow-right"></i> {{ __('رجوع') }}
                    </a>
                </div>

                <div class="card-body">
                    <div class="alert alert-info">
                        <i class="fas fa-info-circle"></i> 
                        {{ __('إجمالي المسجلين') }}: <strong>{{ $students->count() }}</strong> 
                        {{ __('من أصل') }} <strong>{{ $trainingCourse->seats }}</strong> {{ __('مقعد') }}
                    </div>

                    <div class="table-responsive">
                        <table class="table table-striped table-hover">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>{{ __('الطالب') }}</th>
                                    <th>{{ __('البريد الإلكتروني') }}</th>
                                    <th>{{ __('تاريخ التسجيل') }}</th>
                                    <th>{{ __('الحالة') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($students as $student)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $student->full_name }}</td>
                                    <td>{{ $student->email }}</td>
                                    <td>{{ $student->pivot->enrollment_date->format('Y-m-d') }}</td>
                                    <td>
                                        @php
                                            $statusColors = [
                                                'pending' => 'warning',
                                                'approved' => 'success',
                                                'rejected' => 'danger',
                                                'cancelled' => 'secondary'
                                            ];
                                            $statusLabels = [
                                                'pending' => '⏳ ' . __('قيد الانتظار'),
                                                'approved' => '✅ ' . __('مقبول'),
                                                'rejected' => '❌ ' . __('مرفوض'),
                                                'cancelled' => '🚫 ' . __('ملغي')
                                            ];
                                        @endphp
                                        <span class="badge bg-{{ $statusColors[$student->pivot->status] ?? 'secondary' }}">
                                            {{ $statusLabels[$student->pivot->status] ?? $student->pivot->status }}
                                        </span>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="5" class="text-center text-muted">⚠️ {{ __('لا يوجد طلاب مسجلين في هذه الدورة') }}</td>
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
@endsection