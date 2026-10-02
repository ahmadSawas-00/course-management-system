<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" dir="{{ app()->getLocale() == 'ar' ? 'rtl' : 'ltr' }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name', 'Laravel') }}</title>
    
    <!-- Bootstrap RTL / LTR Condition -->
    @if(app()->getLocale() == 'ar')
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.rtl.min.css" rel="stylesheet">
    @else
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    @endif
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body>
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-8 text-center">
                <div class="card shadow-lg">
                    <div class="card-body py-5">
                        <h1 class="display-4 text-primary mb-4">
                            <i class="fas fa-graduation-cap"></i>
                            {{ config('app.name', 'Laravel') }}
                        </h1>
                        <h3 class="mb-4">{{ __('نظام إدارة وحجز الكورسات') }}</h3>
                        <p class="lead text-muted mb-5">
                            {{ __('نظام متكامل لإدارة الكورسات والطلاب والدورات التدريبية') }}
                        </p>
                        
                        <div class="d-flex justify-content-center gap-3">
                            @if (Route::has('login'))
                                @auth
                                    <a href="{{ url('/dashboard') }}" class="btn btn-primary btn-lg px-4">
                                        <i class="fas fa-tachometer-alt"></i> {{ __('لوحة التحكم') }}
                                    </a>
                                @else
                                    <a href="{{ route('login') }}" class="btn btn-success btn-lg px-5">
                                        <i class="fas fa-sign-in-alt"></i> {{ __('تسجيل دخول') }}
                                    </a>
                                    @if (Route::has('register'))
                                        <a href="{{ route('register') }}" class="btn btn-outline-primary btn-lg px-5">
                                            <i class="fas fa-user-plus"></i> {{ __('تسجيل جديد') }}
                                        </a>
                                    @endif
                                @endauth
                            @endif
                        </div>
                    </div>
                </div>

                <div class="row mt-5">
                    <div class="col-md-4">
                        <div class="card">
                            <div class="card-body">
                                <i class="fas fa-book fa-3x text-primary mb-3"></i>
                                <h5>{{ __('إدارة الكورسات') }}</h5>
                                <p class="text-muted">{{ __('إضافة وتعديل وحذف الكورسات') }}</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card">
                            <div class="card-body">
                                <i class="fas fa-users fa-3x text-success mb-3"></i>
                                <h5>{{ __('إدارة الطلاب') }}</h5>
                                <p class="text-muted">{{ __('تسجيل الطلاب ورفع الملفات') }}</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card">
                            <div class="card-body">
                                <i class="fas fa-calendar-check fa-3x text-warning mb-3"></i>
                                <h5>{{ __('حجز الدورات') }}</h5>
                                <p class="text-muted">{{ __('تسجيل الطلاب في الدورات') }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>