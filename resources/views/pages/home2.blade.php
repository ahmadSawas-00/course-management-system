@extends('layouts.master')

@section('title', __('الرئيسية'))

@section('header', __('مرحباً بك في الصفحة الرئيسية'))

@section('content')
    <h2>{{ __('هذه هي الصفحة الرئيسية') }}</h2>
    <p>{{ __('مرحباً بك في موقعنا! هذا المحتوى مقدم من الصفحة الرئيسية.') }}</p>
    
    <div style="margin-top: 20px;">
        <h3>{{ __('العناصر المميزة:') }}</h3>
        <ul>
            <li>{{ __('العنصر 1') }}</li>
            <li>{{ __('العنصر 2') }}</li>
            <li>{{ __('العنصر 3') }}</li>
        </ul>
    </div>
@endsection

@section('footer')
    <p>{{ __('تذييل الصفحة الرئيسية - تواصل معنا: email@example.com') }}</p>
@endsection