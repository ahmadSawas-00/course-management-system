<x-guest-layout>
    <form method="POST" action="{{ route('register') }}">
        @csrf

        <!-- Name -->
        <div class="mb-3">
            <label for="name" class="form-label">{{ __('الاسم الكامل') }}</label>
            <input id="name" class="form-control" type="text" name="name" value="{{ old('name') }}" required autofocus>
            @error('name')
                <div class="text-danger mt-1">{{ $message }}</div>
            @enderror
        </div>

        <!-- Email Address -->
        <div class="mb-3">
            <label for="email" class="form-label">{{ __('البريد الإلكتروني') }}</label>
            <input id="email" class="form-control" type="email" name="email" value="{{ old('email') }}" required>
            @error('email')
                <div class="text-danger mt-1">{{ $message }}</div>
            @enderror
        </div>

        <!-- Password -->
        <div class="mb-3">
            <label for="password" class="form-label">{{ __('كلمة المرور') }}</label>
            <input id="password" class="form-control" type="password" name="password" required>
            @error('password')
                <div class="text-danger mt-1">{{ $message }}</div>
            @enderror
        </div>

        <!-- Confirm Password -->
        <div class="mb-3">
            <label for="password_confirmation" class="form-label">{{ __('تأكيد كلمة المرور') }}</label>
            <input id="password_confirmation" class="form-control" type="password" name="password_confirmation" required>
            @error('password_confirmation')
                <div class="text-danger mt-1">{{ $message }}</div>
            @enderror
        </div>

        <div class="d-flex justify-content-between align-items-center">
            <a href="{{ route('login') }}" class="text-decoration-none">
                {{ __('لديك حساب؟ تسجيل دخول') }}
            </a>
            <button type="submit" class="btn btn-primary">
                {{ __('تسجيل جديد') }}
            </button>
        </div>
    </form>
</x-guest-layout>