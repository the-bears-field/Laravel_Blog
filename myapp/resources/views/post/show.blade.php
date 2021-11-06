<div>
    <p>{{ $post->title }}</p>
    <time datetime="{{ $post->created_at->toDateString() }}">{{ $post->created_at->format('Y年n月j日') }}</time>
    @if($post->created_at->toDateTimeString() !== $post->updated_at->toDateTimeString())
        <time datetime="{{ $post->updated_at->toDateString() }}">{{ $post->updated_at->format('Y年n月j日') }}</time>
    @endif
    <ul>
    @foreach($post->tags as $tag)
        <li>{{ $tag->name }}</li>
    @endforeach
    </ul>
    <p>{{ $post->post }}</p>
    @can('view', $post)
        <ul>
            <li><a href="/edit/{{ $post->id }}">編集</a></li>
            <li><a href="/delete/{{ $post->id }}">削除</a></li>
        </ul>
    @endcan
</div>