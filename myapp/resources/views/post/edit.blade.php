@extends('layouts.blog')

@section('title', 'Edit')

@section('content')
    <main class="main main--has-right-sidebar">
        <article class="main__wysiwyg wysiwyg">
            <form method="post" class="wysiwyg__form flex-direction-column">
                @csrf
                @method('put')
                <input class="wysiwyg__title" type="text" name="title" placeholder="タイトルを入力して下さい。" value="{{ $post->title }}">
                <textarea name="post">{{ $post->post }}</textarea>
                <input class="wysiwyg__tags" type="text" name="tags" placeholder="tags" value="{{ $post->tags }}">
                <input type="submit" value="送信" class="button button--enabled wysiwyg__button margin-top-20px">
            </form>
        </article>
    </main>
@endsection
@include('layouts.sidebar')
