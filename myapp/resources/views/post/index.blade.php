@if($posts->isEmpty())
    <div>
        <p>まだ投稿されていません。</p>
    </div>
@else
    @foreach($posts as $post)
        <div>
            <p><a href="{{ route('post.show', ['postId' => $post->id]) }}">{{ $post->title }}</a></p>
            <p>{{ $post->post }}</p>
        </div>
    @endforeach
@endif