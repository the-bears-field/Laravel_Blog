@extends('layouts.blog')

@section('title', 'New')

@section('content')
    <main class="main main--has-right-sidebar">
        <article class="main__wysiwyg wysiwyg">
            <form action="/new" method="post" class="wysiwyg__form flex-direction-column">
                @csrf
                <input class="wysiwyg__title" type="text" name="title" placeholder="タイトルを入力して下さい。" value="">
                <textarea name="post"></textarea>
                <input class="wysiwyg__tags" type="text" name="tags" placeholder="tags" value="">
                <input type="submit" value="送信" class="button button--enabled wysiwyg__button margin-top-20px">
            </form>
        </article>
    </main>
@endsection
@include('layouts.sidebar')
