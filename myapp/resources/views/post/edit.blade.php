@extends('layouts.blog')

@section('title', '記事の編集 / Kumano.code')

@section('content')
    <main class="main main--has-right-sidebar flex-direction-column">
        <article class="main__wysiwyg wysiwyg">
            <form method="post" class="wysiwyg__form flex-direction-column">
                @csrf
                @method('put')
                <input class="wysiwyg__title" type="text" name="title" placeholder="タイトルを入力して下さい。" value="{{ $post->title }}">
                <textarea id="post-form" name="post">{{ clean($post->post) }}</textarea>
                <input class="wysiwyg__tags" type="text" name="tags" placeholder="tags" value="{{ $post->tags }}">
                <input type="submit" value="送信" class="button button--enabled wysiwyg__button margin-top-20px">
            </form>
        </article>
    </main>
@endsection
@include('layouts.sidebar')
