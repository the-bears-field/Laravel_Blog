@extends('layouts.blog')

@section('title', 'Edit')

@section('content')
    <form action="{{ route('update', ['postId' => $post->id]) }}" method="POST">
        @csrf
        @method('put')
        <div><input type="text" name="title" value="{{ $post->title }}"></div>
        <textarea name="post">{{ $post->post }}</textarea>
        <div><input type="text" name="tags" value="{{ $post->tags }}"></div>
        <div><input type="submit" value="投稿"></div>
    </form>
@endsection