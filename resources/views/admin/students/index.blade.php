@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">👨‍🎓 {{ __('إدارة الطلاب') }}</h5>
                    <a href="{{ route('admin.students.create') }}" class="btn btn-primary btn-sm">
                        <i class="fas fa-plus"></i> {{ __('إضافة طالب جديد') }}
                    </a>
                </div>

                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-striped table-hover">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>{{ __('الصورة') }}</th>
                                    <th>{{ __('الاسم الكامل') }}</th>
                                    <th>{{ __('البريد الإلكتروني') }}</th>
                                    <th>{{ __('رقم الهاتف') }}</th>
                                    <th>{{ __('الملفات') }}</th>
                                    <th>{{ __('الإجراءات') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($students as $student)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>
                                        @if($student->profile_image)
                                            <img src="{{ asset('storage/students/profile_images/' . $student->profile_image) }}" 
                                                 alt="{{ $student->full_name }}" 
                                                 style="width: 50px; height: 50px; object-fit: cover; border-radius: 50%;">
                                        @else
                                            <div class="bg-secondary rounded-circle d-inline-flex align-items-center justify-content-center text-white" 
                                                 style="width: 50px; height: 50px; font-size: 20px;">
                                                {{ substr($student->full_name, 0, 1) }}
                                            </div>
                                        @endif
                                    </td>
                                    <td><strong>{{ $student->full_name }}</strong></td>
                                    <td>{{ $student->email }}</td>
                                    <td>{{ $student->phone ?? __('غير محدد') }}</td>
                                    <td>
                                        @if($student->documents)
                                            <a href="{{ asset('storage/students/documents/' . $student->documents) }}" 
                                               target="_blank" class="btn btn-info btn-sm">
                                                <i class="fas fa-file"></i> {{ __('عرض') }}
                                            </a>
                                        @else
                                            <span class="text-muted">{{ __('لا يوجد') }}</span>
                                        @endif
                                    </td>
                                    <td>
                                        <a href="{{ route('admin.students.edit', $student->id) }}" class="btn btn-warning btn-sm">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <form action="{{ route('admin.students.destroy', $student->id) }}" method="POST" class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('{{ __('هل أنت متأكد من حذف هذا الطالب؟') }}')">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="7" class="text-center text-muted">⚠️ {{ __('لا يوجد طلاب مسجلين') }}</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    {{ $students->links() }}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection