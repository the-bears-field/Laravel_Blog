<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;
use Illuminate\Support\Facades\Auth;

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

    public function new(Request $request)
    {
        return view('post.new');
    }

    public function create(Request $request)
    {
        $user = Auth::user();
        $formData = $request->all();
        unset($formData['_token']);
        $post = new Post;
        $post->fill($formData)->save();
        $user->posts()->syncWithoutDetaching($post->id);
        return redirect('/');
    }
}
