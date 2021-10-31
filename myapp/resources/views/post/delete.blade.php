<div>
    <p>{{ $title }}</p>
    <p>{{ $post }}</p>
</div>
<form action="/new" method="POST">
    @csrf
    <div><input type="submit" value="削除"></div>
</form>