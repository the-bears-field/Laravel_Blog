<?php
declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\Post;
use App\Services\PostService;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PostController extends Controller
{
    private PostService $postService;

    public function __construct(PostService $postService)
    {
        $this->postService = $postService;
    }

    public function index(Request $request): View
    {
        $posts = $this->postService->getAll();
        return view('post.index', compact('posts'));
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

    public function edit(Request $request)
    {
        $postId = $request->postId;
        $userId = Auth::id();
        $post = Post::with('users')->find($postId);
        if(!$post) return redirect('/');
        $user = $post->users->find($userId);
        $params = [
            'title' => $post->title,
            'post' => $post->post
        ];

        return $user ? view('post.edit', $params) : redirect('/');
    }

    public function update(Request $request)
    {
        $postId = $request->postId;
        $userId = Auth::id();
        $post = Post::with('users')->find($postId);
        if(!$post) return redirect('/');
        $user = $post->users->find($userId);
        $params = [
            'title' => $request->title,
            'post' => $request->post
        ];

        if($user) Post::find($postId)->update($params);

        return redirect('/');
    }

    public function delete(Request $request)
    {
        $postId = $request->postId;
        $userId = Auth::id();
        $post = Post::with('users')->find($postId);
        if(!$post) return redirect('/');
        $user = $post->users->find($userId);
        $params = [
            'title' => $post->title,
            'post' => $post->post
        ];

        return $user ? view('post.delete', $params) : redirect('/');
    }

    public function destroy(Request $request)
    {
        $postId = $request->postId;
        $userId = Auth::id();
        $post = Post::with('users')->find($postId);
        if(!$post) return redirect('/');
        $user = $post->users->find($userId);

        if($user){
            $user->posts()->detach($postId);
            Post::find($postId)->delete();
        }

        return redirect('/');
    }
}
