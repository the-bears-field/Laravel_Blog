@extends('layouts.blog')

@section('content')
<main class="main main--no-sidebar">
    <div class="main__login-form unlogged-user-form-div">
        @error('email')
            <span class="error-message" role="alert">{{ $message }}</span>
        @enderror
        @error('password')
            <span class="error-message" role="alert">{{ $message }}</span>
        @enderror
        <h1 class="unlogged-user-form-title">ログイン</h1>
        <form class="unlogged-user-form flex-direction-column" action="{{ route('login') }}" method="POST">
            @csrf
            <div class="flex-direction-row input-wrapper">
                <div class="input-wrapper__label">
                    <input type="text" class="input-wrapper__input" name="email" placeholder="Email" value="{{ old('email') }}" required autocomplete="email" autofocus>
                </div>
            </div>
            <div class="flex-direction-row input-wrapper border-top-none">
                <div class="input-wrapper__label">
                    <input class="input-wrapper__input" type="password" name="password" placeholder="password" required autocomplete="current-password">
                </div>
                <span class="password-toggle-icon">
                    <i class="fas fa-eye"></i>
                </span>
            </div>
            <div class="flex-direction-row margin-top-20px">
                <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
                <label class="form-check-label" for="remember">
                    {{ __('Remember Me') }}
                </label>
            </div>
            <input type="submit" class="button button--enabled margin-top-20px" value="ログイン">
            @if (Route::has('password.request'))
                <a class="btn btn-link" href="{{ route('password.request') }}">
                    {{ __('Forgot Your Password?') }}
                </a>
            @endif
        </form>
    </div>
</main>
@endsection
