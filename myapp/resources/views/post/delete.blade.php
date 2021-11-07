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
</div>
<form action="/delete" method="POST">
    @csrf
    <input type="hidden" name="postId" value="{{ $post->id }}">
    <div><input type="submit" value="削除"></div>
</form>