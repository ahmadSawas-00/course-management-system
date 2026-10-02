@extends('layouts.master')

@section('title', __('من نحن'))

@section('header', __('عن شركتنا'))

@section('nav-links')
    <a href="/special">{{ __('رابط خاص') }}</a>
@endsection

@section('content')
    <h2>{{ __('من نحن') }}</h2>
    <p>{{ __('نحن شركة مكرسة لتقديم خدمات عالية الجودة.') }}</p>
    <p>{{ __('مهمتنا هي مساعدة الأفراد على تحقيق أهدافهم.') }}</p>
    
    <div style="background: #f0f0f0; padding: 20px; margin-top: 20px; border-radius: 10px;">
        <h3>{{ __('قيمنا:') }}</h3>
        <ul>
            <li>{{ __('الجودة') }}</li>
            <li>{{ __('النزاهة') }}</li>
            <li>{{ __('الابتكار') }}</li>
        </ul>
    </div>
@endsection