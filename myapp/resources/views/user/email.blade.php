@extends('layouts.blog')

@section('title', 'Index')

@section('content')
    <main class="main main--has-left-sidebar align-left">
        <div class="message">
        </div>
        <div class="main__settings settings">
            <div class="settings__label flex-direction-row">
                <a class="settings__back" href="/user"><i class="fas fa-arrow-left"></i></a>
                <h1 class="settings__title">ユーザー名を変更</h1>
            </div>
            <form class="flex-direction-column" method="post" action="/user/email">
                @csrf
                <p class="settings__text margin-top-20px">{{ Auth::user()->email }}</p>
                <div class="flex-direction-row settings__input-wrapper input-wrapper">
                    <div class="input-wrapper__label">
                        <input id="email-input" class="input-wrapper__input" type="email" name="email" placeholder="メールアドレスを入力" value="">
                    </div>
                </div>
                <div class="flex-direction-row settings__input-wrapper input-wrapper border-top-none">
                    <div class="input-wrapper__label">
                        <input id="password-input" class="input-wrapper__input" type="password" name="password" placeholder="パスワードを入力">
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
        <a id="deactivate" class="sidebar__inner left-sidebar__inner settings-list__link flex-direction-row">
            <section class="settings-list__item">
                <h1 class="settings-list__label">アカウントを削除</h1>
                <p class="settings-list__content"></p>
            </section>
            <i class="fas fa-chevron-right settings-list__arrow"></i>
        </a>
        {{-- /.sidebar__inner .left-sidebar__inner .settings-list__link --}}
    </aside>
@endsection
