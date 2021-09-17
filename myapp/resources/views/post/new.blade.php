<form adtion="/new" method="POST">
    @csrf
    <div><input type="text" name="title"></div>
    <textarea name="post"></textarea>
    <div><input type="submit" value="投稿"></div>
</form>