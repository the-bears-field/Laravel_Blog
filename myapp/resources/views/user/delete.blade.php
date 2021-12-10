@extends('layouts.blog')

@section('title', 'アカウントの削除 / Kumano.code')

@section('content')
    <main class="main main--has-left-sidebar align-left">
        <div class="message">
        </div>
        <div class="main__settings settings">
            <div class="settings__label flex-direction-row">
                <span class="settings__back"><i class="fas fa-arrow-left"></i></span>
                <h1 class="settings__title">アカウントの削除</h1>
            </div>
            <div class="flex-direction-column">
                <div class="margin-top-20px">
                    <h2>{{ Auth::user()->name }}</h2>
                    <p>{{ Auth::user()->email }}</p>
                </div>
                <p class="settings__text margin-top-20px">
                    上記アカウントが削除されます。<br>
                    一度、アカウントの削除を実行すると、アカウントの復元はできなくなります。<br>
                    以上をご理解の上、アカウントの削除を実行して下さい。
                </p>
                <p class="settings__text settings__warning-message margin-top-20px"></p>
                <form id="account-deactivator" class="flex-direction-column" method="post" action="/user/delete">
                    @csrf
                    <div class="flex-direction-row settings__input-wrapper input-wrapper margin-top-20px">
                        <div class="input-wrapper__label">
                            <input class="input-wrapper__input" type="password" name="password" placeholder="パスワードを入力">
                        </div>
                        <div class="password-toggle-icon">
                            <i class="fas fa-eye"></i>
                        </div>
                    </div>
                    <input class="button button--enabled button--warning settings__button margin-top-20px" type="submit" value="アカウントの削除">
                </form>
            </div>
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
