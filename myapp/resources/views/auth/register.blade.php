@extends('layouts.blog')

@section('content')
<main class="main main--no-sidebar">
    <div class="unlogged-user-form-div">
        <h1 class="unlogged-user-form-title">新規登録</h1>
        @error('name')
            <span class="error-message" role="alert">{{ $message }}</span>
        @enderror
        @error('email')
            <span class="error-message" role="alert">{{ $message }}</span>
        @enderror
        @error('password')
            <span class="error-message" role="alert">{{ $message }}</span>
        @enderror
        <form class="unlogged-user-form flex-direction-column" action="{{ route('register') }}" method="POST">
            @csrf
            <div class="flex-direction-row input-wrapper">
                <label class="input-wrapper__label">
                    <input type="text" class="input-wrapper__input" name='name' placeholder="User Name" value="{{ old('name') }}" required autocomplete="name" autofocus>
                </label>
            </div>
            <div class="flex-direction-row input-wrapper border-top-none">
                <label class="input-wrapper__label">
                    <input type="text" class="input-wrapper__input" name='email' placeholder="Email" value="{{ old('email') }}" required autocomplete="email">
                </label>
            </div>
            <div class="flex-direction-row input-wrapper border-top-none">
                <label class="input-wrapper__label">
                    <input class="input-wrapper__input" type="password" name="password" placeholder="パスワードを入力" required autocomplete="new-password">
                </label>
                <span class="password-toggle-icon">
                    <i class="fas fa-eye"></i>
                </span>
            </div>
            <div class="flex-direction-row input-wrapper border-top-none">
                <label class="input-wrapper__label">
                    <input class="input-wrapper__input" type="password" name="password_confirmation" placeholder="再度パスワードを入力" required autocomplete="new-password">
                </label>
                <span class="password-toggle-icon">
                    <i class="fas fa-eye"></i>
                </span>
            </div>
            <input type="submit" class="button button--enabled margin-top-20px" value="新規登録">
        </form>
    </div>
</main>
@endsection
