@if($posts->isEmpty())
    <div>
        <p>まだ投稿されていません。</p>
    </div>
@else
    @foreach($posts as $post)
        <div>
            <p><a href="{{ route('post.show', ['postId' => $post->id]) }}">{{ $post->title }}</a></p>
            <time datetime="{{ $post->created_at->toDateString() }}">{{ $post->created_at->format('Y年n月j日') }}</time>
            @if($post->created_at->toDateTimeString() !== $post->updated_at->toDateTimeString())
                <time datetime="{{ $post->updated_at->toDateString() }}">{{ $post->updated_at->format('Y年n月j日') }}</time>
            @endif
            <ul>
                @foreach($post->tags as $tag)
                    <li><a href="null">{{ $tag->name }}</a></li>
                @endforeach
            </ul>
            <p>{{ $post->post }}</p>
        </div>
    @endforeach
@endif