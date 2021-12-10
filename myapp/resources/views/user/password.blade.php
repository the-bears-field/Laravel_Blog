@extends('layouts.blog')

@section('title', 'パスワードを変更 / Kumano.code')

@section('content')
    <main class="main main--has-left-sidebar align-left">
        <div class="message">
        </div>
        <div class="main__settings settings">
            <div class="settings__label flex-direction-row">
                <a class="settings__back" href="/user"><i class="fas fa-arrow-left"></i></a>
                <h1 class="settings__title">パスワードを変更</h1>
            </div>
            <form class="flex-direction-column" method="post" action="/user/password">
                @csrf
                @if($errors->has('current-password'))
                    @foreach($errors->get('current-password') as $message)
                        <p>{{ $message }}</p>
                    @endforeach
                @endif
                <div class="flex-direction-row settings__input-wrapper input-wrapper">
                    <div class="input-wrapper__label">
                        <input class="input-wrapper__input" type="password" name="current-password" placeholder="現在のパスワードを入力">
                    </div>
                    <div class="password-toggle-icon">
                        <i class="fas fa-eye"></i>
                    </div>
                </div>
                @if($errors->has('password'))
                    @foreach($errors->get('password') as $message)
                        <p>{{ $message }}</p>
                    @endforeach
                @endif
                <div class="flex-direction-row settings__input-wrapper input-wrapper margin-top-50px">
                    <div class="input-wrapper__label">
                        <input class="input-wrapper__input" type="password" name="password" placeholder="新しいパスワードを入力">
                    </div>
                    <div class="password-toggle-icon">
                        <i class="fas fa-eye"></i>
                    </div>
                </div>
                @if($errors->has('password-confirmation'))
                    @foreach($errors->get('password-confirmation') as $message)
                        <p>{{ $message }}</p>
                    @endforeach
                @endif
                <div class="flex-direction-row settings__input-wrapper input-wrapper border-top-none">
                    <div class="input-wrapper__label">
                        <input class="input-wrapper__input" type="password" name="password-confirmation" placeholder="新しいパスワードを、もう一度入力">
                    </div>
                    <div class="password-toggle-icon">
                        <i class="fas fa-eye"></i>
                    </div>
                </div>
                <input class="button button--enabled settings__button margin-top-20px" type="submit" value="保存">
            </form>
        </div>
    </main>
@endsection

@section('sidebar')
    <aside class="sidebar left-sidebar settings-list">
        <a id="username" class="sidebar__inner left-sidebar__inner settings-list__link flex-direction-row" href="/user/name">
            <section class="settings-list__item">
                <h1 class="settings-list__label">ユーザー名</h1>
                <p class="settings-list__content">{{ Auth::user()->name }}</p>
            </section>
            <i class="fas fa-chevron-right settings-list__arrow"></i>
        </a>
        {{-- /.sidebar__inner .left-sidebar__inner .settings-list__link --}}
        <a id="email" class="sidebar__inner left-sidebar__inner settings-list__link flex-direction-row" href="/user/email">
            <section class="settings-list__item">
                <h1 class="settings-list__label">Email</h1>
                <p class="settings-list__content">{{ Auth::user()->email }}</p>
            </section>
            <i class="fas fa-chevron-right settings-list__arrow"></i>
        </a>
        {{-- /.sidebar__inner .left-sidebar__inner .settings-list__link --}}
        <a id="password" class="sidebar__inner left-sidebar__inner settings-list__link flex-direction-row" href="/user/password">
            <section class="settings-list__item">
                <h1 class="settings-list__label">パスワード</h1>
                <p class="settings-list__content"></p>
            </section>
            <i class="fas fa-chevron-right settings-list__arrow"></i>
        </a>
        {{-- /.sidebar__inner .left-sidebar__inner .settings-list__link --}}
        <a id="deactivate" class="sidebar__inner left-sidebar__inner settings-list__link flex-direction-row" href="/user/delete">
            <section class="settings-list__item">
                <h1 class="settings-list__label">アカウントを削除</h1>
                <p class="settings-list__content"></p>
            </section>
            <i class="fas fa-chevron-right settings-list__arrow"></i>
        </a>
        {{-- /.sidebar__inner .left-sidebar__inner .settings-list__link --}}
    </aside>
@endsection
