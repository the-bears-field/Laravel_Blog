<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;

class PostController extends Controller
{
    public function index(Request $request)
    {
        $posts = Post::all()->sortByDesc('id');
        return view('post.index', ['posts' => $posts]);
    }

    public function show(Request $request)
    {
        $postId = $request->postId;
        $post = Post::find($postId);
        return $post ? view('post.show', ['post' => $post]) : redirect('/');
    }
}
