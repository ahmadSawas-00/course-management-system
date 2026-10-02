@extends('layouts.master')

@section('title', __('اتصل بنا'))

@section('header', __('تواصل معنا'))

@section('content')
    <h2>{{ __('اتصل بنا') }}</h2>
    
    <form style="max-width: 500px; margin-top: 20px;">
        <div style="margin-bottom: 15px;">
            <label style="display: block; margin-bottom: 5px;">{{ __('الاسم:') }}</label>
            <input type="text" style="width: 100%; padding: 8px; border: 1px solid #ddd; border-radius: 5px;">
        </div>
        
        <div style="margin-bottom: 15px;">
            <label style="display: block; margin-bottom: 5px;">{{ __('البريد الإلكتروني:') }}</label>
            <input type="email" style="width: 100%; padding: 8px; border: 1px solid #ddd; border-radius: 5px;">
        </div>
        
        <div style="margin-bottom: 15px;">
            <label style="display: block; margin-bottom: 5px;">{{ __('الرسالة:') }}</label>
            <textarea style="width: 100%; padding: 8px; border: 1px solid #ddd; border-radius: 5px;" rows="5"></textarea>
        </div>
        
        <button type="submit" style="background: #667eea; color: white; padding: 10px 20px; border: none; border-radius: 5px; cursor: pointer;">
            {{ __('إرسال الرسالة') }}
        </button>
    </form>
@endsection