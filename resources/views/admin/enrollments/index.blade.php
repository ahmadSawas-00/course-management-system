@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">📝 {{ __('إدارة التسجيلات') }}</h5>
                    <a href="{{ route('admin.enrollments.create') }}" class="btn btn-primary btn-sm">
                        <i class="fas fa-plus"></i> {{ __('تسجيل جديد') }}
                    </a>
                </div>

                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-striped table-hover">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>{{ __('الطالب') }}</th>
                                    <th>{{ __('الدورة التدريبية') }}</th>
                                    <th>{{ __('تاريخ التسجيل') }}</th>
                                    <th>{{ __('الحالة') }}</th>
                                    <th>{{ __('الإجراءات') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($enrollments as $enrollment)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $enrollment->student->full_name ?? __('غير محدد') }}</td>
                                    <td>{{ $enrollment->trainingCourse->name ?? __('غير محدد') }}</td>
                                    <td>{{ $enrollment->enrollment_date->format('Y-m-d') }}</td>
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
                                        <span class="badge bg-{{ $statusColors[$enrollment->status] ?? 'secondary' }}">
                                            {{ $statusLabels[$enrollment->status] ?? $enrollment->status }}
                                        </span>
                                    </td>
                                    <td>
                                        <a href="{{ route('admin.enrollments.edit', $enrollment->id) }}" class="btn btn-warning btn-sm" title="{{ __('تعديل') }}">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <form action="{{ route('admin.enrollments.destroy', $enrollment->id) }}" method="POST" class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('{{ __('هل أنت متأكد من إلغاء هذا التسجيل؟') }}')">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="6" class="text-center text-muted">⚠️ {{ __('لا توجد تسجيلات') }}</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    {{ $enrollments->links() }}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection