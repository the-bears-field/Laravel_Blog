<form adtion="/new" method="POST">
    @csrf
    <div><input type="text" name="title" value="{{ $title }}"></div>
    <textarea name="post">{{ $post }}</textarea>
    <div><input type="text" name="tags" value="{{ $tags }}"></div>
    <div><input type="submit" value="投稿"></div>
</form>