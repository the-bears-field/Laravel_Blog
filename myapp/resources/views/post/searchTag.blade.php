@extends('layouts.blog')

@section('title', $tagName)

@section('content')
    <main class="main main--has-right-sidebar flex-direction-column">
        @if($posts->isEmpty())
            <article class="search-result-message">
                #{{ $tagName }} に一致する結果は見つかりませんでした。
            </article>
        @else
            <article class="search-result-message">
                #{{ $tagName }} の検索結果
            </article>
            @foreach($posts as $post)
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
                                    <a class="posts-nav__link flex-direction-row margin-top-10px" href="/delete/{{ $post->id }}">
                                        <i class="fas fa-trash-alt"></i>
                                        <span class="posts-nav__link-text">削除</span>
                                    </a>
                                </div>
                            </div>
                        @endcan
                        <h1 class="posts__title margin-top-20px"><a href="{{ route('post.show', ['postId' => $post->id]) }}">{{ $post->title }}</a></h1>
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
                                    <a class="tags__link" href="/tag/{{ $tag->name }}">{{ $tag->name }}</a>
                                @endforeach
                            </div>
                        @endif
                        <div class="posts__text">
                            {!! clean($post->post) !!}
                        </div>
                        <a class="button button--enabled posts__button" href="{{ route('post.show', ['postId' => $post->id]) }}">続きを読む</a>
                    </article>
                </div>
            @endforeach
            <div class="main__paginator paginator">
                {{ $posts->links('pagination.default') }}
            </div>
        @endif
    </main>
@endsection

@section('sidebar')
    <aside class="sidebar right-sidebar">
        <div class="sidebar__inner right-sidebar__inner">
            <form class="sidebar__search search flex-direction-row" method="get" action="{{ route('post.search') }}">
                <input type="search" class="search__input" name="searchWord" placeholder="ブログ内で検索">
                <button class="search__button fas fa-search" type="submit"></button>
            </form>
        </div>
        <div class="sidebar__inner right-sidebar__inner flex-direction-column">
            <h2 class="sidebar__caption">タグ一覧</h2>
            <div class="sidebar__tags">
                @foreach($tags as $tag)
                    <a class="sidebar__tags-item" href="/tag/{{ $tag->name }}">{{ $tag->name }}</a>
                @endforeach
            </div>
        </div>
    </aside>
@endsection
