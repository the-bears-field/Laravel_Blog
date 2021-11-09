@extends('layouts.blog')

@section('title', 'Show')

@section('content')
    <main class="main main--has-right-sidebar">
        <div class="main__posts posts">
            <article class="posts__content flex-direction-column">
                @can('viewAny', $post)
                    <div class="posts__nav posts-nav">
                        <span class="posts-nav__icon fas fa-ellipsis-h"></span>
                        <div class="posts-nav__menu" ontouchstart="">
                        <a class="posts-nav__link flex-direction-row" href="/edit/{{ $post->id }}">
                            <i class="fas fa-pen"></i>
                            <span class="posts-nav__link-text">編集</span>
                        </a>
                        <a class="posts-nav__link flex-direction-row margin-top-10px" href="/delete/{{ $post->id }}>">
                            <i class="fas fa-trash-alt"></i>
                            <span class="posts-nav__link-text">削除</span>
                        </a>
                    </div>
                    </div>
                @endcan
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
                            <a class="tags__link" href="null">{{ $tag->name }}</a>
                        @endforeach
                    </div>
                @endif
                <div class="posts__text posts__text--post margin-top-50px">
                    {{ $post->post }}
                </div>
            </article>
        </div>
    </main>
@endsection
@include('layouts.sidebar')
