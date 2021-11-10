<!DOCTYPE html>
<html lang="ja">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta http-equiv="X-UA-Compatible" content="IE=Edge">
<link rel="stylesheet" href="{{ asset('/css/normalize.css') }}">
<link rel="stylesheet" href="{{ asset('/css/style.css'). '?datetime='. date("YmdHis") }}">
<link type="text/css" rel="stylesheet" href="{{ mix('css/app.css') }}">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script src="{{ asset('/js/blog.js'). '?datetime='. date("YmdHis") }}"></script>
<title>@yield('title')</title>
</head>
<body>
<div class="message-box">
    <div class="message-box__window">
        <div class="message-box__content flex-direction-column">
            <p class="message-box__text"></p>
            <div class="message-box__send-links flex-direction-row">
                <button class="button button--enabled cancel">キャンセル</button>
                <button class="button button--enabled"></button>
            </div>
        </div>
    </div>
</div>

<header class="header flex-direction-row">
    <a class="header__logo" href="/">Kumano.code</a>
    <div class="header__nav">
        <div class="header__nav-icon">
            <span class="header__nav-line"></span>
            <span class="header__nav-line"></span>
            <span class="header__nav-line"></span>
        </div>
    </div>
    <div class="header__menu">
        @if(Auth::check())
            <a class="header__link" href="/new" ontouchstart="">新規投稿</a>
            <a class="header__link" href="null" ontouchstart="">アカウント</a>
            <a class="header__link" href="{{ route('logout') }}"
                onclick="event.preventDefault();
                document.getElementById('logout-form').submit();">
                {{ __('ログアウト') }}
            </a>
            <form id="logout-form" action="{{ route('logout') }}" method="POST">
                @csrf
            </form>
        @else
            <a class="header__link" href="/login" ontouchstart="">ログイン</a>
            <a class="header__link" href="register" ontouchstart="">新規登録</a>
        @endif
    </div>
</header>
<div class="message"></div>
@yield('content')
<footer class="footer">
    <p class="footer__copyright">copyright 2019 Satoshi Kumano</p>
</footer>
</body>
</html>