<form action="/edit" method="POST">
    @csrf
    <div><input type="text" name="title" value="{{ $post->title }}"></div>
    <textarea name="post">{{ $post->post }}</textarea>
    <div><input type="text" name="tags" value="{{ $post->tags }}"></div>
    <div><input type="submit" value="投稿"></div>
</form>