@extends('layouts.blog')

@section('title', 'Index')

@section('content')
    <main class="main main--has-left-sidebar align-left">
        <div class="message"></div>
        <div class="main__default-message">
            <p>左側のリストから変更したい項目を選択して下さい。</p>
        </div>
    </main>
@endsection

@section('sidebar')
    <aside class="sidebar left-sidebar settings-list">
        <a id="username" class="sidebar__inner left-sidebar__inner settings-list__link flex-direction-row">
            <section class="settings-list__item">
                <h1 class="settings-list__label">ユーザー名</h1>
                <p class="settings-list__content">{{ Auth::user()->name }}</p>
            </section>
            <i class="fas fa-chevron-right settings-list__arrow"></i>
        </a>
        {{-- /.sidebar__inner .left-sidebar__inner .settings-list__link --}}
        <a id="email" class="sidebar__inner left-sidebar__inner settings-list__link flex-direction-row">
            <section class="settings-list__item">
                <h1 class="settings-list__label">Email</h1>
                <p class="settings-list__content">{{ Auth::user()->email }}</p>
            </section>
            <i class="fas fa-chevron-right settings-list__arrow"></i>
        </a>
        {{-- /.sidebar__inner .left-sidebar__inner .settings-list__link --}}
        <a id="password" class="sidebar__inner left-sidebar__inner settings-list__link flex-direction-row">
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
