<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}" dir="{{ app()->getLocale() == 'ar' ? 'rtl' : 'ltr' }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', __('My Website'))</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: Arial, sans-serif;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }
        
        /* Header Styles */
        .header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 20px;
            text-align: center;
        }
        
        .nav {
            background: #333;
            padding: 10px;
            text-align: center;
            display: flex;
            justify-content: center;
            align-items: center;
            gap: 15px;
            flex-wrap: wrap;
        }
        
        .nav a {
            color: white;
            text-decoration: none;
            padding: 5px 10px;
        }
        
        .nav a:hover {
            background: #555;
            border-radius: 5px;
        }

        .lang-btn {
            border: 1px solid #fff;
            border-radius: 4px;
            transition: background 0.2s;
        }

        .lang-btn:hover {
            background: #fff;
            color: #333 !important;
        }
        
        /* Content Styles */
        .content {
            flex: 1;
            padding: 40px 20px;
            max-width: 1200px;
            margin: 0 auto;
            width: 100%;
        }
        
        /* Footer Styles */
        .footer {
            background: #333;
            color: white;
            text-align: center;
            padding: 20px;
            margin-top: auto;
        }
    </style>
    
    @stack('styles')
</head>
<body>
    <!-- Header Section -->
    <div class="header">
        <h1>@yield('header', __('My Website'))</h1>
    </div>
    
    <div class="nav">
        <a href="/">{{ __('الرئيسية') }}</a>
        <a href="/about">{{ __('من نحن') }}</a>
        <a href="/contact">{{ __('اتصل بنا') }}</a>
        @yield('nav-links')

        <!-- Language Switcher Button -->
        @if(app()->getLocale() == 'ar')
            <a href="{{ route('lang.switch', 'en') }}" class="lang-btn">🌐 English</a>
        @else
            <a href="{{ route('lang.switch', 'ar') }}" class="lang-btn">🌐 العربية</a>
        @endif
    </div>
    
    <!-- Main Content -->
    <div class="content">
        @yield('content')
    </div>
    
    <!-- Footer Section -->
    <div class="footer">
        @yield('footer', __('© :year جميع الحقوق محفوظة.', ['year' => date('Y')]))
    </div>
    
    @stack('scripts')
</body>
</html>