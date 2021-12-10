@extends('layouts.blog')

@section('title', '記事の削除 / Kumano.code')

@section('content')
    <main class="main main--has-right-sidebar flex-direction-column">
        <div class="main__posts posts">
            <article class="posts__content flex-direction-column">
                <h1 class="posts__title margin-top-20px">{{ $post->title }}</h1>
                <div class="posts__datetime datetime margin-top-10px flex-direction-row">
                    <time class="datetime__text" datetime="{{ $post->created_at->toDateString() }}">
                        <i class="far fa-clock"></i>
                        {{ $post->created_at->format('Y年n月j日') }}
                    </time>
                    @if($post->created_at->toDateTimeString() !== $post->updated_at->toDateTimeString())
                        <time class="datetime__text" datetime="{{ $post->updated_at->toDateString() }}">
                            <i class="fas fa-sync-alt"></i>
                            {{ $post->updated_at->format('Y年n月j日') }}
                        </time>
                    @endif
                </div>
                @if($post->tags->isNotEmpty())
                    <div class="posts__tags tags flex-direction-row">
                        @foreach($post->tags as $tag)
                            <p class="tags__link" href="null">{{ $tag->name }}</p>
                        @endforeach
                    </div>
                @endif
                <div class="posts__text posts__text--post margin-top-50px">
                    {!! clean($post->post) !!}
                </div>
                <form class="posts__button-wrapper flex-direction-row" action="{{ route('destroy', ['postId' => $post->id]) }}" method="post">
                    @csrf
                    @method('delete')
                    <button class="button button--enabled button--warning" type="submit">削除</button>
                </form>
            </article>
        </div>
    </main>
@endsection
@include('layouts.sidebar')
