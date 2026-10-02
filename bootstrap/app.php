<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Http\Request;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        // 1. إضافة الـ Middleware
        $middleware->web(append: [
            \App\Http\Middleware\SetLocale::class,
        ]);
    })
    ->booted(function () {
        // 2. تعريف الـ RateLimiter بعد اكتمال إقلاع التطبيق والتأكد من تجهيز الـ Facades
        RateLimiter::for('enrollments', function (Request $request) {
            return Limit::perMinute(2)->by(
                $request->user()?->id ?? $request->ip()
            )->response(function (Request $request, array $headers) {
                return back()->with('error', __('تجاوزت الحد المسموح من محاولات الحجز! يرجى الانتظار دقيقة قبل المحاولة مجدداً.'));
            });
        });
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        //
    })->create();