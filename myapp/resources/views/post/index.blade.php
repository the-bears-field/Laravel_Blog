@if($posts->isEmpty())
    <div>
        <p>まだ投稿されていません。</p>
    </div>
@else
    @foreach($posts as $post)
        <div>
            <p>{{ $post->title }}</p>
            <p>{{ $post->post }}</p>
        </div>
    @endforeach
@endif